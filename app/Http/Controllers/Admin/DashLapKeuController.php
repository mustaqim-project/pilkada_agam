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
$totalAnggaranPerTim = DB::table('anggaran as a')
    ->join('tims as t', 'a.tim_id', '=', 't.id')
    ->selectRaw("t.name as tim, CONCAT(SUM(a.total_anggaran), '') AS total_anggaran") // Menggunakan CONCAT untuk format string
    ->groupBy('t.name')
    ->get();

    $labels = $totalAnggaranPerTim->pluck('tim');
    $data = $totalAnggaranPerTim->pluck('total_anggaran');

    // Memformat data ke dalam bentuk 000.000.000
    $data = $data->map(function ($item) {
        return number_format($item, 0, '.', '.'); // Format tanpa desimal dan menggunakan titik sebagai pemisah ribuan
    });



        // Total Anggaran yang Sudah Dikeluarkan per Tim
        $totalAnggaranDigunakanPerTim = DB::table('penggunaan_anggaran as pa')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->select('t.name as tim', DB::raw('SUM(pa.jumlah_digunakan) AS total_anggaran_digunakan'))
            ->groupBy('t.name')
            ->get();

        // Sisa Anggaran per Tim
        $sisaAnggaranPerTim = DB::table('tims as t')
            ->leftJoin(
                DB::raw('(SELECT
                tim_id,
                SUM(total_anggaran) AS total_anggaran
                FROM anggaran
                GROUP BY tim_id) AS a'),
                'a.tim_id',
                '=',
                't.id'
            )
            ->leftJoin(
                DB::raw('(SELECT
                p.anggaran_id,
                SUM(pa.jumlah_digunakan) AS jumlah_digunakan
                FROM penggunaan_anggaran pa
                JOIN periode p ON pa.periode_id = p.id
                GROUP BY p.anggaran_id) AS pa'),
                'a.tim_id',
                '=',
                DB::raw('(SELECT tim_id FROM anggaran WHERE id = pa.anggaran_id)')
            )
            ->select(
                't.name as tim',
                DB::raw('COALESCE(SUM(a.total_anggaran), 0) AS total_anggaran'),
                DB::raw('COALESCE(SUM(pa.jumlah_digunakan), 0) AS total_anggaran_digunakan'),
                DB::raw('COALESCE(SUM(a.total_anggaran), 0) - COALESCE(SUM(pa.jumlah_digunakan), 0) AS sisa_anggaran')
            )
            ->groupBy('t.name')
            ->get();


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
        $laporanPembayaran = DB::table('penggunaan_anggaran as pa')
            ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->select('t.name as tim', 'p.nama_periode', 'dp.nama_rincian', 'pa.jumlah_digunakan', 'pa.status_pembayaran', 'pa.bukti_pembayaran')
            ->get();

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
