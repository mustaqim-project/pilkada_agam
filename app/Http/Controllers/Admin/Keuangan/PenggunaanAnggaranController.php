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


    // public function index()
    // {
    //     $penggunaanAnggaran = PenggunaanAnggaran::with([
    //         'periode.anggaran.tim',  // Periode -> Anggaran -> Tim
    //         'detailPembiayaan'       // Relasi ke DetailPembiayaan tetap
    //     ])->get();
    //     $periodes = periode::with('anggaran.tim')->get();
    //     $detailPembiayaans = DetailPembiayaan::all();
    //     // dd(vars: $penggunaanAnggaran);
    //     return view('admin.keuangan.penggunaan_anggaran.index', compact('penggunaanAnggaran', 'periodes', 'detailPembiayaans'));
    // }
    public function index()
    {
        // Mengambil data penggunaan anggaran dengan relasi yang dibutuhkan
        $laporanPembayaran = PenggunaanAnggaran::with(['periode.anggaran.tim'])
            ->get()
            ->groupBy(function ($item) {
                return $item->periode->anggaran->tim->name;
            });

            dd($laporanPembayaran);
            $periodes = periode::with('anggaran.tim')->get();
                $detailPembiayaans = DetailPembiayaan::all();
        return view('admin.keuangan.penggunaan_anggaran.index', compact('laporanPembayaran', 'periodes', 'detailPembiayaans'));
    }


    public function create()
    {
        return view('admin.keuangan.penggunaan_anggaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|integer',
            'detail_pembiayaan_id' => 'required|integer',
            'jumlah_digunakan' => 'required|string|max:255',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,gpg,webp|max:5000', // batas ukuran 2MB
        ]);

        // Cek apakah ada file bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $imagePath = $this->handleFileUpload($request, 'bukti_pembayaran');
        }

        // Simpan data baru
        $penggunaanAnggaran = new PenggunaanAnggaran();
        $penggunaanAnggaran->periode_id = $request->periode_id;
        $penggunaanAnggaran->detail_pembiayaan_id = $request->detail_pembiayaan_id;
        $penggunaanAnggaran->jumlah_digunakan = $request->jumlah_digunakan;
        $penggunaanAnggaran->status_pembayaran = $request->status_pembayaran;
        $penggunaanAnggaran->bukti_pembayaran = isset($imagePath) ? $imagePath : null;
        $penggunaanAnggaran->keterangan = $request->keterangan;
        $penggunaanAnggaran->save();

        return redirect()->route('admin.keuangan.penggunaan_anggaran.index')
            ->with('toast_success', 'Data penggunaan anggaran berhasil ditambahkan.');
    }


    public function show($id)
    {
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        return view('admin.keuangan.penggunaan_anggaran.show', compact('penggunaanAnggaran'));
    }

    public function edit($id)
    {
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        return view('admin.keuangan.penggunaan_anggaran.edit', compact('penggunaanAnggaran'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'periode_id' => 'required|integer',
            'detail_pembiayaan_id' => 'required|integer',
            'jumlah_digunakan' => 'required|string|max:255',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,gpg,webp|max:5000', // batas ukuran 2MB

        ]);

        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);

        $penggunaanAnggaran->periode_id = $request->periode_id;
        $penggunaanAnggaran->detail_pembiayaan_id = $request->detail_pembiayaan_id;
        $penggunaanAnggaran->jumlah_digunakan = $request->jumlah_digunakan;
        $penggunaanAnggaran->status_pembayaran = $request->status_pembayaran;
        $penggunaanAnggaran->keterangan = $request->keterangan;

        if ($request->hasFile('bukti_pembayaran')) {
            $penggunaanAnggaran->bukti_pembayaran = $this->handleFileUpload($request, 'bukti_pembayaran');
        }

        $penggunaanAnggaran->save();

        return redirect()->route('admin.keuangan.penggunaan_anggaran.index')
            ->with('toast_success', 'Data penggunaan anggaran berhasil diupdate.');
    }




    public function destroy($id)
    {
        $penggunaanAnggaran = PenggunaanAnggaran::findOrFail($id);
        $penggunaanAnggaran->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
