<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\DetailPembiayaan;
use App\Models\jenis_pembiayaan;
use Illuminate\Http\Request;

class DetailPembiayaanController extends Controller
{
    // Menampilkan daftar Detail Pembiayaan
    public function index()
    {
        $jenisPembiayaans = jenis_pembiayaan::all();
        $detailPembiayaan = DetailPembiayaan::with('jenisPembiayaan')->get();

        return view('admin.keuangan.detail_pembiayaan.index', compact('detailPembiayaan', 'jenisPembiayaans'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pembiayaan_id' => 'required|integer',
            'nama_rincian' => 'required|string|max:255',
        ]);

        DetailPembiayaan::create($request->all());

        return redirect()->route('admin.keuangan.detail_pembiayaan.index')
                         ->with('success', 'Data berhasil ditambahkan.');
    }

    // Mengedit data berdasarkan ID
    public function edit($id)
    {
        $detailPembiayaan = DetailPembiayaan::findOrFail($id);
        return view('admin.keuangan.detail_pembiayaan.edit', compact('detailPembiayaan'));
    }

    // Mengupdate data berdasarkan ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_pembiayaan_id' => 'required|integer',
            'nama_rincian' => 'required|string|max:255',
        ]);

        $detailPembiayaan = DetailPembiayaan::findOrFail($id);
        $detailPembiayaan->update($request->all());

        return redirect()->route('admin.keuangan.detail_pembiayaan.index')
                         ->with('success', 'Data berhasil diupdate.');
    }

    // Menghapus data berdasarkan ID
    public function destroy($id)
    {
        $detailPembiayaan = DetailPembiayaan::findOrFail($id);
        $detailPembiayaan->delete();

        return redirect()->route('admin.keuangan.detail_pembiayaan.index')
                         ->with('success', 'Data berhasil dihapus.');
    }
}
