<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\laporan_keuangan;
use App\Models\anggaran;
use App\Models\periode;
use App\Models\jenis_pembiayaan;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        $laporanKeuangan = laporan_keuangan::with(['anggaran.tim', 'periode', 'jenisPembiayaan'])->get();
        $anggarans = anggaran::all();
        $periodes = periode::all();
        $jenisPembiayaans = jenis_pembiayaan::all();

        return view('admin.laporan_keuangan.index', compact('laporanKeuangan', 'anggarans', 'periodes', 'jenisPembiayaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggaran_id' => 'required',
            'periode_id' => 'required',
            'jenis_pembiayaan_id' => 'required',
            'jumlah_digunakan' => 'required|numeric',
            'keterangan' => 'required|string',
            'status' => 'required',
        ]);

        laporan_keuangan::create($request->all());

        return redirect()->route('admin.laporan-keuangan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $laporan = laporan_keuangan::find($id);
        return response()->json($laporan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'anggaran_id' => 'required',
            'periode_id' => 'required',
            'jenis_pembiayaan_id' => 'required',
            'jumlah_digunakan' => 'required|numeric',
            'keterangan' => 'required|string',
            'status' => 'required',
        ]);

        $laporan = laporan_keuangan::find($id);
        $laporan->update($request->all());

        return redirect()->route('admin.laporan-keuangan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        laporan_keuangan::destroy($id);

        return redirect()->route('admin.laporan-keuangan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
