<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\PasswordResetTokensController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Password_Reset_Tokens;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        $reset = Password_Reset_Tokens::where('token', $request->token)->first();

        return view('auth.reset-password', [
            'email' => $reset->email,
            'token' => $request->token
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'token.required' => __('Aucun token n\'a été donné.'),
            'email.required' => __('Le courriel est requis.'),
            'email.required' => __('Le format du courriel est incorrect.'),
            'password.required' => __('Le mot de passe est requis.'),
            'password.confirmed' => __('Le mot de passe doit être identique à la confirmation.'),
            'password.min' => __('Le mot de passe doit avoir au moins 8 caractères.'),
        ]);

        if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput();
        else {
            $reset = Password_Reset_Tokens::where('token', $request->token)->first();

            if ($reset) {
                if ($reset->email == $request->email) {
                    $user = User::where('email', $request->email)->first();

                    $user->password = Hash::make($request->password);

                    $user->save();

                    $reset->delete();
                }

                return redirect('/login');
            }
            else {
                return back()->withErrors(['error' => __('Le token donné est invalide.')])->withInput();
            }
        }
    }
}
