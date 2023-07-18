<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PasswordResetTokensController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Password_Reset_Tokens;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(16));
            Mail::to($request->email)->send(new ResetPassword($token, $user));

            (new PasswordResetTokensController)->store($user->email, $token);
        }

        return redirect()->back()->withErrors(['error' => __('Si un compte est associé avec ce courriel, un message lui a été envoyé.')]);
    }
}
