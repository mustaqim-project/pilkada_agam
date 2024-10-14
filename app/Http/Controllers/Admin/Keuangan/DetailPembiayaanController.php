<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\DetailPembiayaan;
use Illuminate\Http\Request;

class DetailPembiayaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan semua data dari tabel 'detail_pembiayaan'
        $detailPembiayaan = DetailPembiayaan::all();
        return view('admin.keuangan.detail_pembiayaan.index', compact('detailPembiayaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat data baru
        return view('admin.keuangan.detail_pembiayaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis_pembiayaan_id' => 'required|integer',
            'nama_rincian' => 'required|string|max:255',
        ]);

        // Simpan data baru ke database
        DetailPembiayaan::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.keuangan.detail_pembiayaan.index')
                         ->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail dari data tertentu
        $detailPembiayaan = DetailPembiayaan::findOrFail($id);
        return view('admin.keuangan.detail_pembiayaan.show', compact('detailPembiayaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menampilkan form edit untuk data tertentu
        $detailPembiayaan = DetailPembiayaan::findOrFail($id);
        return view('admin.keuangan.detail_pembiayaan.edit', compact('detailPembiayaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jenis_pembiayaan_id' => 'required|integer',
            'nama_rincian' => 'required|string|max:255',
        ]);

        // Update data di database
        $detailPembiayaan = DetailPembiayaan::findOrFail($id);
        $detailPembiayaan->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.keuangan.detail_pembiayaan.index')
                         ->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus data dari database
        $detailPembiayaan = DetailPembiayaan::findOrFail($id);
        $detailPembiayaan->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.keuangan.detail_pembiayaan.index')
                         ->with('success', 'Data berhasil dihapus.');
    }
}
