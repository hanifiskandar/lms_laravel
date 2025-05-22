<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeaveBalanceResource;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Http\Resources\LeaveRequestResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Exports\LeaveRequestsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{

    protected $user;
    protected $userId;
    protected $departmentId;
    protected $currentYear;


    public function __construct()
    {
        $this->userId = auth()->id();
        $this->user = auth()->user();
        $this->departmentId = $this->user->department_id;
        $this->currentYear = now()->year;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Log::debug('index leave');
        Log::debug($request->all());

        $leaveRequestQuery = LeaveRequest::with('user', 'leaveType')
            ->when($request->filled('leave_type'), function ($query) use ($request) {
                $query->where('leave_type_id', $request->input('leave_type'));
            })
            ->when($request->filled('duration'), function ($query) use ($request) {
                $query->where('duration', $request->input('duration'));
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereDate('start_date', '>=', $request->input('start_date'));
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $query->whereDate('end_date', '<=', $request->input('end_date'));
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
        Log::debug($request->all());

        $validated = $request->validate([
            'leave_type_id' => 'required',
            'duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 10MB
        ]);

        if (!$this->checkLeaveBalance($request)) {
            return response()->json([
                'message' => 'Your leave balance is not enough.',
            ], 422);
        }

        try {
            DB::beginTransaction();

            $fileData = $this->handleFileUpload($request);

            $leaveRequest = LeaveRequest::create([
                ...$validated,
                ...$fileData,
                'user_id' => $this->userId,
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

    public function show($id)
    {
        $leaveRequest = LeaveRequest::with('user', 'leaveType')->findOrFail($id);
        return new LeaveRequestResource($leaveRequest);
    }

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

    private function checkLeaveBalance(Request $request): bool
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $duration = $request->input('duration');
        $leaveTypeId = $request->input('leave_type_id');

        // Count only weekdays (Monday to Friday)
        $daysDiff = $startDate->diffInDaysFiltered(function (Carbon $date) {
            return !$date->isWeekend(); // Skip Saturday and Sunday
        }, $endDate);

        // Include the start date if it's a weekday
        if (!$startDate->isWeekend()) {
            $daysDiff++;
        }

        // Calculate requested days
        $requestedDays = $duration === 'half_day' ? $daysDiff * 0.5 : $daysDiff;

        $leaveBalance = LeaveBalance::where('user_id', $this->userId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('year', $this->currentYear)
            ->first();

        Log::debug("Requested days: " . $requestedDays);

        return $leaveBalance && $leaveBalance->balance >= $requestedDays;
    }

    public function leaveApprovalRequests(Request $request)
    {
        Log::debug('index approval leave');
        Log::debug($request->all());

        $leaveApprovalRequestQuery = LeaveRequest::with('user', 'leaveType')
            ->when($request->filled('leave_type'), function ($query) use ($request) {
                $query->where('leave_type_id', $request->input('leave_type'));
            })
            ->when($request->filled('duration'), function ($query) use ($request) {
                $query->where('duration', $request->input('duration'));
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereDate('start_date', '>=', $request->input('start_date'));
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $query->whereDate('end_date', '<=', $request->input('end_date'));
            })
            ->whereHas('user', function ($query) {
                $query->where('department_id', $this->departmentId);
            })
            ->where('user_id', '!=', $this->userId);

        $perPage = $request->input('per_page', 10);
        $leaveRequests = $leaveApprovalRequestQuery->paginate($perPage);

        return LeaveRequestResource::collection($leaveRequests);
    }

    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $leaveRequest->update([
            'approved_by_id' => auth()->id(),
            'approved_at' => now(),
            'status' => 2,
        ]);

        return response()->json([
            'message' => 'Leave request approved successfully.',
            'data' => $leaveRequest,
        ]);
    }

    public function reject($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $leaveRequest->update([
            'approved_by_id' => auth()->id(),
            'approved_at' => now(),
            'status' => 3,
        ]);

        return response()->json([
            'message' => 'Leave request rejected successfully.',
            'data' => $leaveRequest,
        ]);
    }

    public function exportPDF(Request $request)
    {
        \Log::debug('req pdf');
        \Log::debug($request->all());
        $leaveRequests = LeaveRequest::with('user', 'leaveType')
            ->when($request->filled('leave_type'), function ($query) use ($request) {
                $query->where('leave_type_id', $request->input('leave_type'));
            })
            ->when($request->filled('duration'), function ($query) use ($request) {
                $query->where('duration', $request->input('duration'));
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereDate('start_date', '>=', $request->input('start_date'));
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $query->whereDate('end_date', '<=', $request->input('end_date'));
            })
            ->orderBy('id', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.leave-requests', ['leaveRequests' => $leaveRequests])
            ->setPaper('a4', 'landscape');

        return $pdf->download('leave-requests.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LeaveRequestsExport($request), 'leave-requests.xlsx');
    }




}
