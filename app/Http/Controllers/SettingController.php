<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use App\Models\LeaveType;
use App\Models\Department;

class SettingController extends Controller
{
    public function states()
    {
        $states = State::all()->map(function ($state) {
            return [
                'id' => $state->name,
                'name' => $state->name,
            ];
        });

        return response()->json([
            'data' => $states
        ]);
    }

    public function leaveTypes()
    {
        $leaveTypes = LeaveType::orderBy('id')->get();

        if ($leaveTypes->isNotEmpty()) {
            return response()->json([
                'data' => $leaveTypes
            ]);
        }
    }

    public function departments()
    {
        $departments = Department::select('id', 'name')->orderBy('id')->get();

        return response()->json([
            'data' => $departments
        ]);
    }

    public function users()
    {
        $users = User::select('id', 'name')->orderBy('id')->get();

        return response()->json([
            'data' => $users
        ]);
    }
}
