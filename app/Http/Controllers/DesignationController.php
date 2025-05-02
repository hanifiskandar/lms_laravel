<?php

namespace App\Http\Controllers;

use App\Http\Resources\DesignationResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    public function index(){
        $designations = Designation::get();
        return DesignationResource::collection($designations);
    }
}
