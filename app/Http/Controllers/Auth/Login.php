<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // valideren van de input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // probeer in te loggen
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // nieuwe sessie want security
            $request->session()->regenerate();

            // naar vorige of homepagina
            return redirect()->intended('/')->with('success', 'Welcome back to chirper!');
        }

        // als login niet lukt, geef error terug
        return back()
            ->withErrors(['email' => 'Wrong email buddy'])
            ->onlyInput('email');
    }
}
