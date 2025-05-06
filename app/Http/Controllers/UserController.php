<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
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

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'is_active' => isset($validated['is_active']) ? $validated['is_active'] : false,
        ]);

        $user->load(['designation', 'department']);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('designation', 'department')->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'nric' => 'sometimes|string|min:12',
            'mobile_phone' => 'sometimes',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'start_date' => 'sometimes',
            'end_date' => 'sometimes',
            'martial_status' => 'sometimes',
            'designation_id' => 'sometimes',
            'department_id' => 'sometimes',
            'password' => ['sometimes', 'confirmed', Password::min(8)->letters()->numbers()],
            'is_active' => 'nullable|boolean',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        $user->load(['designation', 'department']);

        return new UserResource($user);
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

    // public function exportPDF(Request $request)
    // {

    //     $users = User::query()
    //         ->with(['organization', 'department'])
    //         ->when($request->filled('search'), function ($query) use ($request) {
    //             $search = $request->input('search');
    //             $query->where(function ($query2) use ($search) {
    //                 $query2->where('name', 'like', "%{$search}%")
    //                     ->orWhere('nric', 'like', "%{$search}%")
    //                     ->orWhere('email', 'like', "%{$search}%");
    //             });
    //         })
    //         ->when($request->filled('organization'), function ($query) use ($request) {
    //             $query->where('organization_id', $request->input('organization'));
    //         })
    //         ->when($request->filled('department'), function ($query) use ($request) {
    //             $query->where('department_id', $request->input('department'));
    //         })
    //         ->get();

    //     $pdf = Pdf::loadView('exports.users', ['users' => $users])
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download('users.pdf');
    // }

    // public function exportExcel(Request $request)
    // {
    //     return Excel::download(new UsersExport($request), 'users.xlsx');
    // }
}
