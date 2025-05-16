<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\LeaveType;

class SettingController extends Controller
{
    public function states(){
        
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
}
