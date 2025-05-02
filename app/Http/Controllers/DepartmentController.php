<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(){
        $departments = Department::get();
        return DepartmentResource::collection($departments);
    }
}
