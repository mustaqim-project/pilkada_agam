<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Models\laporan_keuangan;
use App\Models\anggaran;
use App\Models\periode;
use App\Models\jenis_pembiayaan;

class LaporanKeuanganController extends Controller
{
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:LaporanKeuangan index,admin'])->only(['index']);
        $this->middleware(['permission:LaporanKeuangan create,admin'])->only(['store']);
        $this->middleware(['permission:LaporanKeuangan update,admin'])->only(['update']);
        $this->middleware(['permission:LaporanKeuangan delete,admin'])->only('destroy');
    }

    public function index()
    {
        $laporanKeuangan = laporan_keuangan::with(['anggaran', 'periode', 'jenisPembiayaan'])->get();
        $periodes = periode::with('anggaran.tim')->get(); // Eager load 'anggaran' dan 'tim'
        $anggarans = anggaran::with('tim')->get(); // Eager load 'tim' pada anggaran
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
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ]);

        $imagePath = $this->handleFileUpload($request, 'bukti_pembayaran');

        laporan_keuangan::create([
            'anggaran_id' => $request->anggaran_id,
            'periode_id' => $request->periode_id,
            'jenis_pembiayaan_id' => $request->jenis_pembiayaan_id,
            'jumlah_digunakan' => $request->jumlah_digunakan,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'bukti_pembayaran' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Laporan Keuangan berhasil dibuat.');
    }

    public function edit($id)
    {
        $laporan = laporan_keuangan::findOrFail($id);
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

        $imagePath = $this->handleFileUpload($request, 'bukti_pembayaran', $laporan->bukti_pembayaran);

        $laporan->update([
            'anggaran_id' => $request->anggaran_id,
            'periode_id' => $request->periode_id,
            'jenis_pembiayaan_id' => $request->jenis_pembiayaan_id,
            'jumlah_digunakan' => $request->jumlah_digunakan,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'bukti_pembayaran' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Laporan Keuangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = laporan_keuangan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan Keuangan berhasil dihapus.');
    }
}
