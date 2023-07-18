<?php

namespace App\Http\Controllers;

use App\Models\Password_Reset_Tokens;
use Illuminate\Http\Request;

class PasswordResetTokensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($email, $token)
    {
        $passwordReset = Password_Reset_Tokens::create([
            'email' => $email,
            'token' => $token
        ]);

        return;
    }

    /**
     * Display the specified resource.
     */
    public function show(Password_Reset_Tokens $password_Reset_Tokens)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Password_Reset_Tokens $password_Reset_Tokens)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Password_Reset_Tokens $password_Reset_Tokens)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Password_Reset_Tokens $password_Reset_Tokens)
    {
        //
    }
}
