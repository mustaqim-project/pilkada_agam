<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashLapKeuController extends Controller
{
    public function index()
    {
        // Total Anggaran Keseluruhan
        $totalAnggaranKeseluruhan = DB::table('anggaran')
            ->select(DB::raw('SUM(total_anggaran) AS total_anggaran_keseluruhan'))
            ->first();

        // Total Anggaran per Tim
        // Bagian PHP (Tetap seperti ini)
        $totalAnggaranPerTim = DB::table('anggaran as a')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->selectRaw("t.name as tim, SUM(a.total_anggaran) AS total_anggaran")
            ->groupBy('t.name')
            ->get();

        $labels = $totalAnggaranPerTim->pluck('tim');
        $data = $totalAnggaranPerTim->pluck('total_anggaran');


        // Total Anggaran yang Sudah Dikeluarkan per Tim
        $totalAnggaranDigunakanPerTim = DB::table('penggunaan_anggaran as pa')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->where('pa.status_pembayaran', 1)  // Menambahkan kondisi status_pembayaran = 1
            ->select('t.name as tim', DB::raw('SUM(pa.jumlah_digunakan) AS total_anggaran_digunakan'))
            ->groupBy('t.name')
            ->get();


        // Sisa Anggaran per Tim

        $sisaAnggaranPerTim = DB::table('tims as t')
        ->select(
            't.id AS Tim_ID',
            't.name AS Tim',
            'a.total_anggaran AS Total_Anggaran', // Mengambil total_anggaran langsung dari tabel anggaran
            DB::raw('COALESCE(SUM(lp.nominal), 0) AS Total_Digunakan'),
            DB::raw('a.total_anggaran - COALESCE(SUM(lp.nominal), 0) AS Sisa_Anggaran') // Menghitung sisa anggaran langsung
        )
        ->leftJoin('anggaran as a', 't.id', '=', 'a.tim_id')
        ->leftJoin('periode as p', 'a.id', '=', 'p.anggaran_id')
        ->leftJoin('penggunaan_anggaran as pa', 'p.id', '=', 'pa.periode_id')
        ->leftJoin('laporan_pembayaran as lp', 'pa.id', '=', 'lp.penggunaan_anggaran_id')
        ->groupBy('t.id', 't.name', 'a.total_anggaran') // Memastikan grup berdasarkan total_anggaran
        ->orderBy('Tim_ID', 'ASC')
        ->get();


        // $sisaAnggaranPerTim = DB::table('tims as t')
        //     ->leftJoin(
        //         DB::raw('(SELECT
        //         tim_id,
        //         SUM(total_anggaran) AS total_anggaran
        //         FROM anggaran
        //         GROUP BY tim_id) AS a'),
        //         'a.tim_id',
        //         '=',
        //         't.id'
        //     )
        //     ->leftJoin(
        //         DB::raw('(SELECT
        //         p.anggaran_id,
        //         SUM(pa.jumlah_digunakan) AS jumlah_digunakan
        //         FROM penggunaan_anggaran pa
        //         JOIN periode p ON pa.periode_id = p.id
        //         WHERE pa.status_pembayaran = 1
        //         GROUP BY p.anggaran_id) AS pa'),
        //         'a.tim_id',
        //         '=',
        //         DB::raw('(SELECT tim_id FROM anggaran WHERE id = pa.anggaran_id)')
        //     )
        //     ->select(
        //         't.name as tim',
        //         DB::raw('COALESCE(SUM(a.total_anggaran), 0) AS total_anggaran'),
        //         DB::raw('COALESCE(SUM(pa.jumlah_digunakan), 0) AS total_anggaran_digunakan'),
        //         DB::raw('COALESCE(SUM(a.total_anggaran), 0) - COALESCE(SUM(pa.jumlah_digunakan), 0) AS sisa_anggaran')
        //     )
        //     ->groupBy('t.name')
        //     ->get();;


        // Penggunaan Anggaran per Jenis Pembiayaan
        $penggunaanPerJenisPembiayaan = DB::table('penggunaan_anggaran as pa')
            ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->join('jenis_pembiayaan as jp', 'dp.jenis_pembiayaan_id', '=', 'jp.id')
            ->select('jp.nama_pembiayaan', DB::raw('SUM(pa.jumlah_digunakan) AS total_digunakan'))
            ->groupBy('jp.nama_pembiayaan')
            ->get();

        // // Penggunaan Anggaran per Periode
        // $penggunaanPeriode = DB::table('tims as t')
        // ->leftJoin('anggaran as a', 't.id', '=', 'a.tim_id')
        // ->leftJoin('periode as p', 'a.id', '=', 'p.anggaran_id')
        // ->leftJoin('penggunaan_anggaran as pa', 'p.id', '=', 'pa.periode_id')
        // ->select('t.name as tim', 'p.nama_periode', DB::raw('COALESCE(SUM(pa.jumlah_digunakan), 0) AS total_digunakan'))
        // ->groupBy('t.name', 'p.nama_periode')
        // ->orderBy('p.nama_periode')
        // ->orderBy('t.name')
        // ->get();

        $penggunaanPeriode = DB::table('tims as t')
            ->leftJoin('anggaran as a', 't.id', '=', 'a.tim_id')
            ->leftJoin('periode as p', 'a.id', '=', 'p.anggaran_id')
            ->leftJoin('penggunaan_anggaran as pa', 'p.id', '=', 'pa.periode_id')
            ->select('t.name as tim', 'p.nama_periode', DB::raw('COALESCE(SUM(pa.jumlah_digunakan), 0) AS total_digunakan'))
            ->whereNotNull('p.nama_periode')  // Menyaring periode yang tidak null
            ->where('pa.status_pembayaran', 1)  // Menambahkan kondisi status_pembayaran = 1
            ->groupBy('t.name', 'p.nama_periode')
            ->orderBy('p.nama_periode')
            ->orderBy('t.name')
            ->get();


        // Status Pembayaran
        $statusPembayaran = DB::table('penggunaan_anggaran as pa')
            ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->select('t.name as tim', 'p.nama_periode', 'dp.nama_rincian', 'pa.jumlah_digunakan', 'pa.status_pembayaran')
            ->get();

        // Rekapitulasi Anggaran Terpakai dan Sisa Anggaran
        $rekapitulasiAnggaran = DB::table('penggunaan_anggaran as pa')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->where('pa.status_pembayaran', 1)  // Menambahkan kondisi status_pembayaran = 1
            ->select(
                't.name as tim',
                DB::raw('SUM(p.anggaran_periode) AS total_anggaran_periode'),
                DB::raw('SUM(pa.jumlah_digunakan) AS total_digunakan'),
                DB::raw('(SUM(p.anggaran_periode) - SUM(pa.jumlah_digunakan)) AS sisa_anggaran')
            )
            ->groupBy('t.name')
            ->get();

        // Penggunaan Anggaran per Pembiayaan Detail
        $penggunaanPerPembiayaanDetail = DB::table('penggunaan_anggaran as pa')
            ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->select('dp.nama_rincian', DB::raw('SUM(pa.jumlah_digunakan) AS total_digunakan'))
            ->groupBy('dp.nama_rincian')
            ->get();

        // Anggaran Digunakan vs Total Anggaran per Tim
        $anggaranDigunakanVsTotal = DB::table('penggunaan_anggaran as pa')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->select('t.name as tim', 'a.total_anggaran', DB::raw('SUM(pa.jumlah_digunakan) AS total_digunakan'))
            ->groupBy('t.name', 'a.total_anggaran')
            ->get();

        // Laporan Pembayaran Lengkap
        // $laporanPembayaran = DB::table('penggunaan_anggaran as pa')
        //     ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
        //     ->join('periode as p', 'pa.periode_id', '=', 'p.id')
        //     ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
        //     ->join('tims as t', 'a.tim_id', '=', 't.id')
        //     ->select('t.name as tim', 'p.nama_periode', 'dp.nama_rincian', 'pa.jumlah_digunakan', 'pa.status_pembayaran', 'pa.bukti_pembayaran')
        //     ->get();

        // $laporanPembayaran = DB::table('penggunaan_anggaran as pa')
        //     ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
        //     ->join('periode as p', 'pa.periode_id', '=', 'p.id')
        //     ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
        //     ->join('tims as t', 'a.tim_id', '=', 't.id')
        //     ->select('t.name as tim', 'p.nama_periode', 'dp.nama_rincian', 'pa.jumlah_digunakan', 'pa.status_pembayaran', 'pa.bukti_pembayaran')
        //     ->orderBy('t.name')
        //     ->orderBy('p.nama_periode')
        //     ->get()
        //     ->groupBy('tim')
        //     ->map(function ($tim) {
        //         return $tim->groupBy('nama_periode');
        //     });

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
        //     'lp.penggunaan_anggaran_id',
        //     'lp.tujuan_pembayaran',
        //     'lp.nominal',
        //     'lp.bukti_pembayaran as bukti_pembayaran_laporan',
        //     'lp.tanggal_pembayaran'
        // )
        // ->orderBy('t.name')
        // ->orderBy('p.nama_periode')
        // ->orderBy('lp.tanggal_pembayaran') // Tambahkan ini untuk urutkan pembayaran per tanggal
        // ->get()
        // ->groupBy('penggunaan_anggaran_id') // Kelompokkan berdasarkan penggunaan_anggaran_id
        // ->map(function ($tim) {
        //     return $tim->groupBy('nama_periode');
        // });

        $laporanPembayaran = DB::table('penggunaan_anggaran as pa')
            ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->leftJoin('laporan_pembayaran as lp', 'pa.id', '=', 'lp.penggunaan_anggaran_id')
            ->select(
                't.name as tim',
                'p.nama_periode',
                'dp.nama_rincian',
                'pa.jumlah_digunakan',
                'pa.status_pembayaran',
                'pa.bukti_pembayaran',
                'lp.tujuan_pembayaran',
                'lp.nominal',
                'lp.bukti_pembayaran as bukti_pembayaran_laporan',
                'lp.tanggal_pembayaran',
                'lp.id as laporan_id', // Menambahkan ID laporan_pembayaran
                'pa.id as penggunaan_anggaran_id' // Menambahkan ID penggunaan anggaran
            )
            ->orderBy('t.name')
            ->orderBy('p.nama_periode')
            ->get()
            ->groupBy('tim')
            ->map(function ($tim) {
                return $tim->groupBy('nama_periode');
            });


        return view('admin.dashboard.lapkeu', compact(
            'totalAnggaranKeseluruhan',
            'totalAnggaranPerTim',
            'totalAnggaranDigunakanPerTim',
            'sisaAnggaranPerTim',
            'penggunaanPerJenisPembiayaan',
            'penggunaanPeriode',
            'statusPembayaran',
            'rekapitulasiAnggaran',
            'penggunaanPerPembiayaanDetail',
            'anggaranDigunakanVsTotal',
            'laporanPembayaran',
            'labels',
            'data'
        ));
    }
}
