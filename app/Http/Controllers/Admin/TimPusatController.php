<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimPusatController extends Controller
{
    public function __construct()
    {
        // Middleware untuk akses berdasarkan izin
        $this->middleware(['permission:Tim Pusat DS ketua_tim_dashboard,admin'])->only('ketuaDashboard');
        $this->middleware(['permission:Tim Pusat DS ketua_tim_laporan,admin'])->only('ketuaLaporan');
        $this->middleware(['permission:Tim Pusat DS admin_dashboard,admin'])->only('adminDashboard');
        $this->middleware(['permission:Tim Pusat DS admin_laporan,admin'])->only('adminLaporan');
        $this->middleware(['permission:Tim Pusat DS keuangan_index,admin'])->only('index');
        $this->middleware(['permission:Tim Pusat DS keuangan_create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:Tim Pusat DS keuangan_update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:Tim Pusat DS keuangan_delete,admin'])->only('destroy');
    }

    public function ketuaDashboard()
    {
        // Logika untuk menampilkan dashboard ketua tim
        return view('admin.timpusatds.ketua.dashboard');
    }

    public function ketuaLaporan()
    {
        // Logika untuk menampilkan laporan ketua tim
        return view('admin.timpusatds.ketua.laporan');
    }

    public function adminDashboard()
    {
        // Logika untuk menampilkan dashboard admin
        return view('admin.timpusatds.admin.dashboard');
    }

    public function adminLaporan()
    {
        // Logika untuk menampilkan laporan admin
        return view('admin.timpusatds.admin.laporan');
    }

    public function index()
    {
        // Logika untuk menampilkan keuangan DS
        return view('admin.timpusatds.index');
    }

    public function create()
    {
        // Logika untuk menampilkan form pembuatan data keuangan
        return view('admin.timpusatds.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan data keuangan
        $validatedData = $request->validate([
            'field1' => 'required|string|max:255', // Ganti field1 dengan nama field yang sesuai
            'field2' => 'required|numeric',         // Ganti field2 dengan nama field yang sesuai
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);

        // Logika untuk menyimpan data keuangan ke database
        // Model::create($validatedData); // Contoh menggunakan model

        return redirect()->route('admin.timpusatds.index')->with('success', 'Data keuangan berhasil dibuat.');
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit data keuangan
        // $data = Model::findOrFail($id); // Ambil data berdasarkan ID
        return view('admin.timpusatds.edit', compact('data')); // Kirim data ke view
    }

    public function update(Request $request, $id)
    {
        // Validasi dan update data keuangan
        $validatedData = $request->validate([
            'field1' => 'required|string|max:255',
            'field2' => 'required|numeric',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);

        // Logika untuk memperbarui data keuangan di database
        // $data = Model::findOrFail($id);
        // $data->update($validatedData); // Perbarui data

        return redirect()->route('admin.timpusatds.index')->with('success', 'Data keuangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Logika untuk menghapus data keuangan
        // $data = Model::findOrFail($id);
        // $data->delete(); // Hapus data

        return redirect()->route('admin.timpusatds.index')->with('success', 'Data keuangan berhasil dihapus.');
    }
}
