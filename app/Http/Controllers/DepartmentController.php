<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Department;

class DepartmentController extends Controller
{
    // public function index(){
    //     $departments = Department::get();
    //     return DepartmentResource::collection($departments);
    // }

    public function index(Request $request)
    {
        Log::debug($request->all());
        Log::debug('Department COonl');
        $departmentsQuery = Department::with('headDepartment')
            ->when($request->filled('department'), function ($query) use ($request) {
                $query->where('id', $request->input('department'));
            })
            ->orderBy('id', 'asc');


        $perPage = $request->input('per_page', 10);
        $departments = $departmentsQuery->paginate($perPage);

        return DepartmentResource::collection($departments);
    }

    public function show($id){

        $department = Department::with('headDepartment')->findOrFail($id);

        return new DepartmentResource($department);
    }

    public function update(Request $request, $id)
    {

        $department = Department::findOrFail($id);

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'head_id' => [
                    'required',
                    Rule::unique('departments', 'head_id')->ignore($department->id),
                ],
            ]);

            $department->update($validated);

            DB::commit();

            $department->load('designation');

            return new DepartmentResource($department);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Update failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
