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
        $authUser = Auth::guard('admin')->user();

        if ($authUser->hasRole('Super Admin')) {
            $admins = User::with('admin')->get();
        } else {
            $admins = User::with('admin')->where('pj_id', $authUser->id)->get();
        }

        return view('admin.users.index', [
            'admins' => $admins,
        ]);
    }



    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Perbaiki unique table dengan tabel `users`
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'pj_id' => ['required', 'exists:admins,id'], // Validasi admin (penanggung jawab)
        'tim' => ['required', 'in:DS,PKH,MM,Asyiah,Parpol,JJ'], // Validasi untuk enum 'tim'
    ]);

    // Buat user baru berdasarkan input yang telah divalidasi
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'pj_id' => $request->pj_id, // Simpan admin penanggung jawab yang dipilih
        'tim' => $request->tim, // Simpan tim yang dipilih
    ]);

    // Event untuk user terdaftar
    event(new Registered($user));

    // Login otomatis setelah registrasi
    Auth::login($user);

    // Redirect ke halaman daftar pengguna dengan pesan sukses
    return redirect()->route('admin.users.index')->with('success', 'Tim berhasil ditambahkan.');
}

}
