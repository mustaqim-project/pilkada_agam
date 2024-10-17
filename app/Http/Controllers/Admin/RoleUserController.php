<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRoleUserStoreRequest;
use App\Http\Requests\AdminRoleUserUpdateRequest;
use App\Mail\RoleUserCreateMail;
use App\Models\Admin;
use App\Models\tim;
use App\Models\jabatan;
use App\Models\Bank;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class RoleUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:access management index,admin'])->only(['index']);
        $this->middleware(['permission:access management create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:access management update,admin'])->only(['edit', 'update', 'handleTitle']);
        $this->middleware(['permission:access management destroy,admin'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $admins = Admin::all();
        return view('admin.role-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();
        $admins = Admin::all();
        $teams = tim::all(); // Fetching teams
        $positions = jabatan::all(); // Fetching Jabatan positions
        $banks = Bank::all(); // Fetching Jabatan positions

        return view('admin.role-user.create', compact('roles', 'admins', 'teams', 'positions', 'banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRoleUserStoreRequest $request): RedirectResponse
    {
        try {
            $user = new Admin();
            $user->image = '';  // Atur sesuai kebutuhan upload image
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = 1;

            // Menambahkan kode_bank, no_rek, jum_gaji
            $user->kode_bank = $request->kode_bank;
            $user->no_rek = $request->no_rek;
            $user->jum_gaji = $request->jum_gaji;

            // Menambahkan atasan_id, tim_id, jabatan_id
            $user->atasan_id = $request->atasan_id;  // Pastikan ini ada dalam permintaan
            $user->tim_id = $request->tim_id;        // Pastikan ini ada dalam permintaan
            $user->jabatan_id = $request->jabatan_id; // Pastikan ini ada dalam permintaan

            $user->save();

            /** assign the role to user */
            $user->assignRole($request->role);

            /** send mail to the user */
            Mail::to($request->email)->send(new RoleUserCreateMail($request->email, $request->password));

            toast(__('admin.Created Successfully!'), 'success');

            return redirect()->route('admin.role-users.index');
        } catch (\Throwable $th) {
            throw $th; // Sebaiknya, log error di sini untuk keperluan debugging
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $roles = Role::all();
        $admins = Admin::all();
        $teams = tim::all(); // Fetching teams
        $positions = jabatan::all(); // Fetching Jabatan positions
        $banks = Bank::all(); // Fetching Jabatan positions
        $user = Admin::findOrFail($id);
        $roles = Role::all();
        return view('admin.role-user.create', compact('user', 'roles', 'admins', 'teams', 'positions', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRoleUserUpdateRequest $request, string $id)
    {
        if ($request->has('password') && !empty($request->password)) {
            $request->validate([
                'password' => ['confirmed', 'min:6']
            ]);
        }

        $user = Admin::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        // Memperbarui kode_bank dan no_rek
        $user->kode_bank = $request->kode_bank;
        $user->no_rek = $request->no_rek;
        $user->jum_gaji = $request->jum_gaji;

        if ($request->has('password') && !empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        /** assign the role to user */
        $user->syncRoles($request->role);

        toast(__('admin.Update Successfully!'), 'success');

        return redirect()->route('admin.role-users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Admin::findOrFail($id);
        if ($user->getRoleNames()->first() === 'Super Admin') {
            return response(['status' => 'error', 'message' => __('admin.Can\'t Delete the Super User')]);
        }
        $user->delete();

        return response(['status' => 'success', 'message' => __('admin.Deleted Successfully')]);
    }


    public function getAtasan(Request $request)
    {
        // Validasi input
        $request->validate([
            'tim_id' => 'required|exists:tims,id',
            'jabatan_id' => 'required|exists:jabatans,id',
        ]);

        // Ambil urutan jabatan yang dipilih
        $jabatan = jabatan::find($request->jabatan_id);

        // Ambil admin berdasarkan tim dan jabatan
        $admins = Admin::where('tim_id', $request->tim_id)
            ->whereIn('jabatan_id', function ($query) use ($jabatan) {
                $query->select('id')
                    ->from('jabatans')
                    ->where('urutan', '<', $jabatan->urutan);
            })
            ->get();

        return response()->json($admins);
    }
}
