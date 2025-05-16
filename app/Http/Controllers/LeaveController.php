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

    protected $userId;

    public function __construct()
    {
        $this->userId = auth()->id();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        \Log::debug('index leave');
        \Log::debug($request->all());
        $leaveRequestQuery = LeaveRequest::with('user', 'leaveType')
            ->when($request->filled('leave_type'), function ($query) use ($request) {
                $query->where('leave_type_id', $request->input('leave_type'));
            })
            ->when($request->filled('duration'), function ($query) use ($request) {
                $query->where('duration', $request->input('duration'));
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->where('start_date', $request->input('start_date'));
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $query->where('end_date', $request->input('end_date'));
            })
            ->where('user_id',$this->userId);


        $perPage = $request->input('per_page', 10);
        $leaveRequests = $leaveRequestQuery->paginate($perPage);

        return LeaveRequestResource::collection($leaveRequests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::debug($request->all());

        $validated = $request->validate([
            'leave_type_id' => 'required',
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
                'user_id' => $this->userId, // assuming user is logged in
            ]);

            DB::commit();

            $leaveRequest->load(['user', 'leaveType']);

            return new LeaveRequestResource($leaveRequest);
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
