<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
// use App\Exports\UsersExport;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Maatwebsite\Excel\Facades\Excel;


class UserPersonalController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'address_line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'country' => 'required',
        ]);


        $user->update([
            ...$validated,
            'address_line2' => $request->input('address_line2'),
            'address_line3' => $request->input('address_line3')
        ]);

        $user->load(['designation', 'department']);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('designation', 'department')->findOrFail($id);
        return new UserResource($user);
    }
}
