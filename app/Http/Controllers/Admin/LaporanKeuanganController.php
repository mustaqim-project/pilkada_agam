<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\laporan_keuangan;
use App\Models\anggaran;
use App\Models\periode;
use App\Models\jenis_pembiayaan;
use App\Traits\FileUploadTrait;

class LaporanKeuanganController extends Controller
{
    use FileUploadTrait;

    public function keuangan()
    {
        $laporanKeuangan = laporan_keuangan::with(['anggaran.tim', 'periode', 'jenisPembiayaan'])->get();
        $anggarans = anggaran::all();
        $periodes = periode::all();
        $jenisPembiayaans = jenis_pembiayaan::all();

        return view('admin.laporan_keuangan.keuangan', compact('laporanKeuangan', 'anggarans', 'periodes', 'jenisPembiayaans'));
    }

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
            'status' => 'nullable|string', // make status nullable for default value
        ]);

        $status = $request->status ?? 'unpaid'; // Default to 'Unpaid'
        $imagePath = $this->handleFileUpload($request, 'bukti_pembayaran') ?? ''; // Default to empty string

        laporan_keuangan::create([
            'anggaran_id' => $request->anggaran_id,
            'periode_id' => $request->periode_id,
            'jenis_pembiayaan_id' => $request->jenis_pembiayaan_id,
            'jumlah_digunakan' => $request->jumlah_digunakan,
            'keterangan' => $request->keterangan,
            'status' => $status,
            'bukti_pembayaran' => $imagePath,
        ]);
        return back()->with('success', 'Laporan berhasil ditambahkan.');

        // return redirect()->route('admin.laporan-keuangan.index')->with('success', 'Laporan berhasil ditambahkan.');
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
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ]);

        $laporan = laporan_keuangan::findOrFail($id);

        $status = $request->status ?? 'unpaid'; // Default to 'Unpaid'
        $imagePath = $this->handleFileUpload($request, 'bukti_pembayaran', $laporan->bukti_pembayaran)?? '';

        $laporan->update([
            'anggaran_id' => $request->anggaran_id,
            'periode_id' => $request->periode_id,
            'jenis_pembiayaan_id' => $request->jenis_pembiayaan_id,
            'jumlah_digunakan' => $request->jumlah_digunakan,
            'status' => $request->status,
            'bukti_pembayaran' => $imagePath,
        ]);
        // return redirect()->route('admin.laporan-keuangan.index')->with('success', 'Laporan berhasil diperbarui.');
        return back()->with('success', 'Laporan berhasil diperbarui.');

    }

    public function destroy($id)
    {
        laporan_keuangan::destroy($id);

        return redirect()->route('admin.laporan-keuangan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
