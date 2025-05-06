<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

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

    // public function organization()
    // {
    //     try {
            
    //         $organizations = Organization::orderBy('id')->get(); 

    //         if ($organizations->isNotEmpty()) {
    //             return $this->jsonResponse(
    //                 OrganizationResource::collection($organizations),
    //                 'Data fetched successfully.'
    //             );
    //         }

    //         return $this->jsonResponse([], 'No Data found.');
            
    //     } catch (\Exception $e) {
            
    //         \Log::error('Error fetching data.', ['error_message' => $e->getMessage()]);
    //         return $this->jsonResponse(null, 'Failed to fetch data.', 'error', 500);
    //     }
    // }
}
