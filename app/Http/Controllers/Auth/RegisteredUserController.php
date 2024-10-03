<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Menetapkan middleware untuk mengontrol akses berdasarkan permission
        $this->middleware(['permission:user register,admin'])->only(['create', 'store']);
    }

    /**
     * Display the registration view.
     */
    public function create(): View
{
    // Mendapatkan pengguna yang sedang login
    $authUser = auth()->user(); // Menggunakan auth()->user()

    // Mengecek apakah pengguna memiliki role 'Super Admin'
    if ($authUser->hasRole('Super Admin')) {
        // Jika Super Admin, ambil semua pengguna dengan relasi Admin
        $admins = User::with('admin')->get();
    } else {
        // Jika bukan Super Admin, ambil berdasarkan pj_id dengan relasi Admin
        $admins = User::with('admin')->where('pj_id', $authUser->id)->get();
    }

    return view('admin.tim_lapangan.index', [
        'admins' => $admins,
    ]);
}


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'pj_id' => ['required', 'exists:admins,id'], // Validasi admin (penanggung jawab)
            'tim' => ['required', 'in:DS,PKH,MM,Asyiah,Parpol,JJ'], // Validasi untuk enum 'tim'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pj_id' => $request->pj_id, // Menyimpan admin (penanggung jawab)
            'tim' => $request->tim, // Menyimpan tim yang dipilih
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
