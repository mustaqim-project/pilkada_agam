<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\PenggunaanAnggaran;
use App\Models\periode;
use App\Models\DetailPembiayaan;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;

class PenggunaanAnggaranController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggunaanAnggaran = PenggunaanAnggaran::with(['periode', 'detailPembiayaan'])->get();

        $periodes = periode::all();
        $DetailPembiayaans = DetailPembiayaan::all();

        return view('admin.keuangan.penggunaan_anggaran.index', compact('penggunaanAnggaran', 'periodes', 'DetailPembiayaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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

        // Cek apakah bukti pembayaran sudah ada
        if ($request->hasFile('bukti_pembayaran')) {
            $imagePath = $this->handleFileUpload($request, 'bukti_pembayaran');
        }

        // Simpan data baru ke database
        $penggunaanAnggaran = new PenggunaanAnggaran();
        $penggunaanAnggaran->periode_id = $request->periode_id;
        $penggunaanAnggaran->detail_pembiayaan_id = $request->detail_pembiayaan_id;
        $penggunaanAnggaran->jumlah_digunakan = $request->jumlah_digunakan;
        $penggunaanAnggaran->status_pembayaran = $request->status_pembayaran;
        $penggunaanAnggaran->bukti_pembayaran = isset($imagePath) ? $imagePath : null;
        $penggunaanAnggaran->keterangan = $request->keterangan;

        $penggunaanAnggaran->save();

        return redirect()->route('admin.keuangan.penggunaan_anggaran.index')
                         ->with('success', 'Data penggunaan anggaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        return view('admin.keuangan.penggunaan_anggaran.show', compact('penggunaanAnggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
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

        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);

        // Update data dengan input baru
        $penggunaanAnggaran->periode_id = $request->periode_id;
        $penggunaanAnggaran->detail_pembiayaan_id = $request->detail_pembiayaan_id;
        $penggunaanAnggaran->jumlah_digunakan = $request->jumlah_digunakan;
        $penggunaanAnggaran->status_pembayaran = $request->status_pembayaran;
        $penggunaanAnggaran->keterangan = $request->keterangan;

        // Cek apakah ada file bukti pembayaran baru
        if ($request->hasFile('bukti_pembayaran')) {
            $penggunaanAnggaran->bukti_pembayaran = $this->handleFileUpload($request, 'bukti_pembayaran');
        }

        $penggunaanAnggaran->save();

        return redirect()->route('admin.keuangan.penggunaan_anggaran.index')
                         ->with('success', 'Data penggunaan anggaran berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        $penggunaanAnggaran->delete();

        return redirect()->route('admin.keuangan.penggunaan_anggaran.index')
                         ->with('success', 'Data penggunaan anggaran berhasil dihapus.');
    }
}
