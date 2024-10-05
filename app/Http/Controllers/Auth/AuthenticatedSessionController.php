<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('mobile.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Melakukan autentikasi
        if ($request->authenticate()) {
            $request->session()->regenerate();

            // Redirect ke halaman dashboard setelah berhasil login
            return view('mobile.frontend.dashboard.index');
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); // Menyimpan input email saat gagal
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
