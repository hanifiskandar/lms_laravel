<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Http\Resources\LeaveRequestResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $leaveRequestQuery = LeaveRequest::with('user', 'leaveType')
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
        $leaveRequests = $leaveRequestQuery->paginate($perPage);

        return LeaveRequest::collection($leaveRequests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'sometimes|file|max:10240', // max 10MB
        ]);

        try {
            DB::beginTransaction();

            $fileData = $this->handleFileUpload($request);

            $leaveRequest = LeaveRequest::create([
                ...$validated,
                ...$fileData,
                'user_id' => auth()->id(), // assuming user is logged in
            ]);

            DB::commit();

            $leaveRequest->load(['user', 'leaveType']);

            return new LeaveRequest($leaveRequest);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create leave request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $leaveRequest = LeaveRequest::with('user', 'leaveType')->findOrFail($id);
        return new LeaveRequestResource($leaveRequest);
    }


    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {   
    //     $user = User::findOrFail($id);
    //     $user->delete();
    //     return response()->json(null, 204);
    // }

    private function handleFileUpload(Request $request): array
    {
        if (!$request->hasFile('attachment')) {
            return [];
        }

        $file = $request->file('attachment');
        $path = $file->store('leave_attachments', 'public');

        return [
            'file_original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize(),
        ];
    }


}
