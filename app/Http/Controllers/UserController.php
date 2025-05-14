<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use App\Exports\UsersExport;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $usersQuery = User::with('designation', 'department')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($query2) use ($search) {
                    $query2->where('name', 'like', "%{$search}%")
                        ->orWhere('nric', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('designation'), function ($query) use ($request) {
                $query->where('designation_id', $request->input('designation'));
            })
            ->when($request->filled('department'), function ($query) use ($request) {
                $query->where('department_id', $request->input('department'));
            });

        $perPage = $request->input('per_page', 10);
        $users = $usersQuery->paginate($perPage);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nric' => 'required|string|min:12',
            'mobile_phone' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'start_date' => 'required',
            'martial_status' => 'required',
            'designation_id' => 'required',
            'department_id' => 'required',
            'username' => 'required|string|min:12',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'is_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                ...$validated,
                'password' => Hash::make($validated['password']),
                'is_active' => $validated['is_active'] ?? false,
            ]);

            DB::commit();

            $user->load(['designation', 'department']);

            return new UserResource($user);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        \Log::debug('show sini');
        $user = User::with('designation', 'department', 'emergencyContacts','familyMembers','children')->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        \Log::debug('update');
        \Log::debug($request->all());
        $user = User::findOrFail($id);

        $validated = [];
        $validatedContacts = [];
        $validatedFamily = [];

        DB::beginTransaction();

        try {
            if ($request->filled('page') && $request->page === 'Personal') {
                $validated = $request->validate([
                    'address_line1' => 'required',
                    'address_line2' => 'nullable|string',
                    'address_line3' => 'nullable|string',
                    'city' => 'required',
                    'state' => 'required',
                    'postcode' => 'required',
                    'office_phone' => 'nullable|string',
                    'mobile_phone' => 'required',
                    'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                ]);

                $validatedContacts = $request->validate([
                    'emergency_contacts' => 'required|array|min:1',
                    'emergency_contacts.*.id' => 'nullable|integer|exists:emergency_contacts,id',
                    'emergency_contacts.*.name' => 'required|string',
                    'emergency_contacts.*.relation' => 'required|string',
                    'emergency_contacts.*.mobile_phone' => 'required|string',
                ]);
            } elseif ($request->filled('page') && $request->page === 'Family') {
                $validated = $request->validate([
                    'spouse_name' => 'nullable|string',
                    'spouse_nric' => 'nullable|string',
                    'spouse_job' => 'nullable|string',
                    'spouse_mobile_phone' => 'nullable|string',
                ]);

                $validatedFamily = $request->validate([
                    'family_members' => 'required|array|min:1',
                    'family_members.*.id' => 'nullable|integer|exists:family_members,id',
                    'family_members.*.name' => 'required|string',
                    'family_members.*.nric' => 'required|string',
                    'family_members.*.gender' => 'required|string',
                    'family_members.*.dob' => 'nullable|date',
                    'family_members.*.mobile_phone' => 'required|string',
                    'family_members.*.relation' => 'required|string',
                    'family_members.*.martial_status' => 'required|string',
                    'family_members.*.activity' => 'required|string',
                    'family_members.*.organization' => 'nullable|string',
                ]);
            } else {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'nric' => 'required|string|min:12',
                    'mobile_phone' => 'required',
                    'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                    'start_date' => 'required',
                    'end_date' => 'sometimes',
                    'martial_status' => 'required',
                    'designation_id' => 'required',
                    'department_id' => 'required',
                    'password' => ['sometimes', 'confirmed', Password::min(8)->letters()->numbers()],
                    'is_active' => 'nullable|boolean',
                ]);

                if (isset($validated['password'])) {
                    $validated['password'] = Hash::make($validated['password']);
                }
            }

            // Update main user fields
            $user->update($validated);

            // Handle related entities
            if (!empty($validatedContacts)) {
                $this->manageEmergencyContacts($user, $validatedContacts['emergency_contacts']);
            }

            if (!empty($validatedFamily)) {
                $this->manageFamilyMembers($user, $validatedFamily['family_members']);
            }

            if ($request->has('children')) {
                $this->manageChildren($user, $request->children);
            }

            DB::commit();

            $user->load(['designation', 'department', 'emergencyContacts', 'familyMembers', 'children']);

            return new UserResource($user);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Update failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {   
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    private function manageEmergencyContacts(User $user, array $contacts)
    {
        $existingIds = $user->emergencyContacts()->pluck('id')->toArray();
        $incomingIds = collect($contacts)->pluck('id')->filter()->toArray();

        // Delete contacts that were removed
        $toDelete = array_diff($existingIds, $incomingIds);
        $user->emergencyContacts()->whereIn('id', $toDelete)->delete();

        // Create or update contacts
        foreach ($contacts as $contact) {
            if (isset($contact['id'])) {
                $user->emergencyContacts()->where('id', $contact['id'])->update([
                    'name' => $contact['name'],
                    'relation' => $contact['relation'],
                    'mobile_phone' => $contact['mobile_phone'],
                ]);
            } else {
                $user->emergencyContacts()->create([
                    'name' => $contact['name'],
                    'relation' => $contact['relation'],
                    'mobile_phone' => $contact['mobile_phone'],
                ]);
            }
        }
    }

    private function manageFamilyMembers(User $user, array $families)
    {
        $existingIds = $user->familyMembers()->pluck('id')->toArray();
        $incomingIds = collect($families)->pluck('id')->filter()->toArray();

        // Delete contacts that were removed
        $toDelete = array_diff($existingIds, $incomingIds);
        $user->familyMembers()->whereIn('id', $toDelete)->delete();

        // Create or update contacts
        foreach ($families as $family) {
            if (isset($family['id'])) {
                $user->familyMembers()->where('id', $family['id'])->update([
                    'name' => $family['name'],
                    'nric' => $family['nric'],
                    'gender' => $family['gender'],
                    'dob' => $family['dob'],
                    'mobile_phone' => $family['mobile_phone'],
                    'relation' => $family['relation'],
                    'martial_status' => $family['martial_status'],
                    'activity' => $family['activity'],
                    'organization' => $family['organization'],
                ]);
            } else {
                $user->familyMembers()->create([
                    'name' => $family['name'],
                    'nric' => $family['nric'],
                    'gender' => $family['gender'],
                    'dob' => $family['dob'],
                    'mobile_phone' => $family['mobile_phone'],
                    'relation' => $family['relation'],
                    'martial_status' => $family['martial_status'],
                    'activity' => $family['activity'],
                    'organization' => $family['organization'],
                ]);
            }
        }
    }

    private function manageChildren(User $user, array $children)
    {
        $existingIds = $user->children()->pluck('id')->toArray();
        $incomingIds = collect($children)->pluck('id')->filter()->toArray();

        // Delete contacts that were removed
        $toDelete = array_diff($existingIds, $incomingIds);
        $user->children()->whereIn('id', $toDelete)->delete();

        // Create or update contacts
        foreach ($children as $child) {
            if (isset($child['id'])) {
                $user->children()->where('id', $child['id'])->update([
                    'name' => $child['name'],
                    'nric' => $child['nric'],
                    'gender' => $child['gender'],
                    'dob' => $child['dob'],
                    'martial_status' => $child['martial_status'],
                    'activity' => $child['activity'],
                ]);
            } else {
                $user->children()->create([
                    'name' => $child['name'],
                    'nric' => $child['nric'],
                    'gender' => $child['gender'],
                    'dob' => $child['dob'],
                    'martial_status' => $child['martial_status'],
                    'activity' => $child['activity'],
                ]);
            }
        }
    }

}
