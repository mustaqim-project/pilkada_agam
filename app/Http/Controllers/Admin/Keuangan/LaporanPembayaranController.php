<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPembayaran;
use Illuminate\Support\Facades\DB;
use App\Traits\FileUploadTrait;

class LaporanPembayaranController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        // $laporanPembayaran = DB::table('penggunaan_anggaran as pa')
        // ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
        // ->join('periode as p', 'pa.periode_id', '=', 'p.id')
        // ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
        // ->join('tims as t', 'a.tim_id', '=', 't.id')
        // ->leftJoin('laporan_pembayaran as lp', 'pa.id', '=', 'lp.penggunaan_anggaran_id')
        // ->select(
        //     't.name as tim',
        //     'p.nama_periode',
        //     'dp.nama_rincian',
        //     'pa.jumlah_digunakan',
        //     'pa.status_pembayaran',
        //     'pa.bukti_pembayaran',
        //     'lp.tujuan_pembayaran',
        //     'lp.nominal',
        //     'lp.bukti_pembayaran as bukti_pembayaran_laporan',
        //     'lp.tanggal_pembayaran',
        //     'lp.id as laporan_id', // Menambahkan ID laporan_pembayaran
        //     'pa.id as penggunaan_anggaran_id' // Menambahkan ID penggunaan anggaran
        // )
        // ->orderBy('t.name')
        // ->orderBy('p.nama_periode')
        // ->get()
        // ->groupBy('tim')
        // ->map(function ($tim) {
        //     return $tim->groupBy('nama_periode');
        // });

        $laporanPembayaran = DB::table('penggunaan_anggaran AS pa')
            ->select(
                't.name AS tim',
                'p.nama_periode',
                'dp.nama_rincian',
                DB::raw('SUM(pa.jumlah_digunakan) AS jumlah_digunakan'),
                'pa.status_pembayaran',
                'pa.bukti_pembayaran',
                'lp.tujuan_pembayaran',
                DB::raw('SUM(lp.nominal) AS total_nominal'),
                'lp.bukti_pembayaran AS bukti_pembayaran_laporan',
                'lp.tanggal_pembayaran',
                'lp.id AS laporan_id', // This needs to be in GROUP BY
                'pa.id AS penggunaan_anggaran_id'
            )
            ->join('detail_pembiayaan AS dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->join('periode AS p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran AS a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims AS t', 'a.tim_id', '=', 't.id')
            ->leftJoin('laporan_pembayaran AS lp', 'pa.id', '=', 'lp.penggunaan_anggaran_id')
            ->groupBy(
                'pa.id',
                't.name',
                'p.nama_periode',
                'dp.nama_rincian',
                'pa.status_pembayaran',
                'pa.bukti_pembayaran',
                'lp.tujuan_pembayaran',
                'lp.bukti_pembayaran',
                'lp.tanggal_pembayaran',
                'lp.id' // Add this line
            )
            ->orderBy('t.name')
            ->orderBy('p.nama_periode')
            ->get();


        return view('admin.keuangan.LaporanPembayaran.index', compact('laporanPembayaran'));
    }

    // Menyimpan laporan pembayaran baru
    public function store(Request $request)
    {
        $request->validate([
            'penggunaan_anggaran_id' => 'nullable|integer',
            'tujuan_pembayaran' => 'required|string|max:255',
            'nominal' => 'required|string|max:225',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:5120', // batas ukuran 5MB
            'tanggal_pembayaran' => 'required|date',
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_pembayaran')) {
            $data['bukti_pembayaran'] = $this->handleFileUpload($request, 'bukti_pembayaran');
        }

        LaporanPembayaran::create($data);

        return redirect()->route('admin.keuangan.laporan_pembayaran.index')
            ->with('toast_success', 'Data penggunaan anggaran berhasil disimpan.');
    }

    // Mengupdate laporan pembayaran
    public function update(Request $request, $id)
    {
        $laporanPembayaran = LaporanPembayaran::findOrFail($id);

        $request->validate([
            'penggunaan_anggaran_id' => 'nullable|integer',
            'tujuan_pembayaran' => 'required|string|max:255',
            'nominal' => 'required|string|max:225',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:5120', // batas ukuran 5MB
            'tanggal_pembayaran' => 'required|date',
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus file lama jika ada
            if ($laporanPembayaran->bukti_pembayaran) {
                // Hapus file dari storage jika diperlukan
            }
            $data['bukti_pembayaran'] = $this->handleFileUpload($request, 'bukti_pembayaran');
        }

        $laporanPembayaran->update($data);

        return redirect()->route('admin.keuangan.laporan_pembayaran.index')
            ->with('toast_success', 'Data penggunaan anggaran berhasil diupdate.');
    }



    public function destroy($id)
    {
        // Temukan laporan pembayaran berdasarkan ID
        $laporan = LaporanPembayaran::findOrFail($id);
        $laporan->delete();


        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
