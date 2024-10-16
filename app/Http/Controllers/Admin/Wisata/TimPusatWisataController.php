<?php

namespace App\Http\Controllers\Admin\Wisata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TimPusatWisataController extends Controller
{
    public function ketuaDashboard()
    {
        // Logika untuk menampilkan dashboard ketua tim
        return view('admin.timpusatwisata.ketua.dashboard');
    }

    public function ketuaLaporan()
    {
        // Logika untuk menampilkan laporan ketua tim
        return view('admin.timpusatwisata.ketua.laporan');
    }

    public function adminDashboard()
    {
        // Logika untuk menampilkan dashboard admin
        return view('admin.timpusatwisata.admin.dashboard');
    }

    public function adminLaporan()
    {
        // Logika untuk menampilkan laporan admin
        return view('admin.timpusatwisata.admin.laporan');
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $timId = $admin->tim_id;

        // Laporan pembayaran berdasarkan tim dan periode
        $laporanPembayaran = DB::table('penggunaan_anggaran as pa')
            ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->where('a.tim_id', $timId) // Filter by tim_id
            ->select('t.name as tim', 'p.nama_periode', 'dp.nama_rincian', 'pa.jumlah_digunakan', 'pa.status_pembayaran', 'pa.bukti_pembayaran')
            ->orderBy('t.name')
            ->orderBy('p.nama_periode')
            ->get()
            ->groupBy('tim')
            ->map(function ($tim) {
                return $tim->groupBy('nama_periode');
            });

        // Total keseluruhan
        $totalKeseluruhan = DB::table('penggunaan_anggaran as pa')
            ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->where('a.tim_id', $timId) // Filter by tim_id
            ->sum('pa.jumlah_digunakan'); // Total keseluruhan

        // Jumlah per periode
        $jumlahPerPeriode = DB::table('penggunaan_anggaran as pa')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->where('a.tim_id', $timId) // Filter by tim_id
            ->select('p.nama_periode', DB::raw('SUM(pa.jumlah_digunakan) as total_jumlah'))
            ->groupBy('p.nama_periode')
            ->orderBy('p.nama_periode')
            ->get();

        return view('admin.timpusatwisata.index', compact('laporanPembayaran', 'totalKeseluruhan', 'jumlahPerPeriode'));
    }

    public function create()
    {
        // Logika untuk menampilkan form pembuatan data keuangan
        return view('admin.timpusatwisata.create');
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

        return redirect()->route('admin.timpusatwisata.index')->with('success', 'Data keuangan berhasil dibuat.');
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit data keuangan
        // $data = Model::findOrFail($id); // Ambil data berdasarkan ID
        return view('admin.timpusatwisata.edit', compact('data')); // Kirim data ke view
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

        return redirect()->route('admin.timpusatwisata.index')->with('success', 'Data keuangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Logika untuk menghapus data keuangan
        // $data = Model::findOrFail($id);
        // $data->delete(); // Hapus data

        return redirect()->route('admin.timpusatwisata.index')->with('success', 'Data keuangan berhasil dihapus.');
    }
}
