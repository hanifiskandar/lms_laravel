<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeaveBalanceResource;
use App\Models\LeaveRequest;
use App\Models\Leavebalance;
use App\Http\Resources\LeaveRequestResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LeaveBalanceController extends Controller
{

    protected $userId;
    protected $currentYear;

    public function __construct()
    {
        $this->userId = auth()->id();
        $this->currentYear = now()->year;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        \Log::debug('index leave');
        \Log::debug($request->all());

        \Log::debug(now()->year);
        // $year = $request->input('year') ?? $this->currentYear;

        // \Log::debug($year);
        // \Log::debug($this->userId);

        $year = $request->input('year') ?? $this->currentYear;
        $leaveTypes = $request->input('leave_type');
        
        // Explode leave_type if it's a string like "1,2,3"
        if (is_string($leaveTypes)) {
            $leaveTypes = explode(',', $leaveTypes);
        }
        
        // Now query with whereIn for leave_type_id
        $leaveBalances = LeaveBalance::with('leaveType')
            ->where('year', $year)
            ->where('user_id', $this->userId)
            ->when(!empty($leaveTypes), function ($query) use ($leaveTypes) {
                return $query->whereIn('leave_type_id', $leaveTypes);
            })
            ->orderBy('leave_type_id', 'asc')  // <-- Add this line
            ->get();
        \Log::debug($leaveBalances);

        return LeaveBalanceResource::collection($leaveBalances);
    }

}
