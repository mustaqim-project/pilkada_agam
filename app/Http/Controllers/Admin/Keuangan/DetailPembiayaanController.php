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
        $jenisPembiayaans = jenis_pembiayaan::with('detailPembiayaan')->get();
        $detailPembiayaan = DetailPembiayaan::with('jenisPembiayaan')->get();
        return view('admin.keuangan.detail_pembiayaan.index', compact('detailPembiayaan', 'jenisPembiayaans'));
    }

    // Menyimpan data baru
    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pembiayaan_id' => 'required|integer',
            'nama_rincian' => 'required|string|max:255',
        ]);

        DetailPembiayaan::create($request->all());

        return redirect()->route('admin.keuangan.detail_pembiayaan.index')
            ->with('toast_success', 'Data berhasil ditambahkan!');
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
            ->with('toast_success', 'Data berhasil diperbarui!');
    }

    // Menghapus data berdasarkan ID
    public function destroy($id)
    {
        $detailPembiayaan = DetailPembiayaan::findOrFail($id);
        $detailPembiayaan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }

}
