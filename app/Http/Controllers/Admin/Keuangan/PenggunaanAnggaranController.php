<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\PenggunaanAnggaran;
use Illuminate\Http\Request;

class PenggunaanAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan semua data dari tabel 'penggunaan_anggaran'
        $penggunaanAnggaran = PenggunaanAnggaran::all();
        return view('admin.keuangan.penggunaan_anggaran.index', compact('penggunaanAnggaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat data baru
        return view('admin.keuangan.penggunaan_anggaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'periode_id' => 'required|integer',
            'detail_pembiayaan_id' => 'required|integer',
            'jumlah_digunakan' => 'required|string|max:255',
            'status_pembayaran' => 'nullable|string|max:255',
            'bukti_pembayaran' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan data baru ke database
        PenggunaanAnggaran::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.keuangan.penggunaan_anggaran.index')
                         ->with('success', 'Data penggunaan anggaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail dari data tertentu
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        return view('admin.keuangan.penggunaan_anggaran.show', compact('penggunaanAnggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menampilkan form edit untuk data tertentu
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        return view('admin.keuangan.penggunaan_anggaran.edit', compact('penggunaanAnggaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'periode_id' => 'required|integer',
            'detail_pembiayaan_id' => 'required|integer',
            'jumlah_digunakan' => 'required|string|max:255',
            'status_pembayaran' => 'nullable|string|max:255',
            'bukti_pembayaran' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Update data di database
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        $penggunaanAnggaran->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.keuangan.penggunaan_anggaran.index')
                         ->with('success', 'Data penggunaan anggaran berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus data dari database
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        $penggunaanAnggaran->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.keuangan.penggunaan_anggaran.index')
                         ->with('success', 'Data penggunaan anggaran berhasil dihapus.');
    }
}
