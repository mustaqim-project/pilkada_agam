<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\tim;
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
    public function __construct()
    {
        $this->middleware(['permission:user register,admin'])->only(['create', 'store']);
    }

    public function index() {}


    public function create(): View
    {
        $authUser = Auth::guard('admin')->user();
        $tims = tim::all(); // Ambil data tim

        if ($authUser->hasRole('Super Admin')) {
            $admins = User::with(['admin', 'tim'])->get(); // Mengambil admin dan tim
        } else {
            $admins = User::with(['admin', 'tim'])->where('pj_id', $authUser->id)->get();
        }

        return view('admin.users.index', [
            'admins' => $admins,
            'tims' => $tims, // Kirim data tim ke view
        ]);
    }



    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'pj_id' => ['required', 'exists:admins,id'],
            'tim_id' => ['required', 'exists:tims,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pj_id' => $request->pj_id,
            'tim_id' => $request->tim_id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect()->route('admin.users.index')->with('success', 'Tim berhasil ditambahkan.');
        return back()->with('success', 'Tim berhasil ditambahkan.');
    }
}
