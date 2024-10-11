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
            ->select('t.name as tim', DB::raw('SUM(a.total_anggaran) AS total_anggaran'))
            ->groupBy('t.name')
            ->get();

        // Total Anggaran yang Sudah Dikeluarkan per Tim
        $totalAnggaranDigunakanPerTim = DB::table('penggunaan_anggaran as pa')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->select('t.name as tim', DB::raw('SUM(pa.jumlah_digunakan) AS total_anggaran_digunakan'))
            ->groupBy('t.name')
            ->get();

        // Sisa Anggaran per Tim
        $sisaAnggaranPerTim = DB::table('anggaran as a')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->leftJoin('periode as p', 'a.id', '=', 'p.anggaran_id')
            ->leftJoin('penggunaan_anggaran as pa', 'p.id', '=', 'pa.periode_id')
            ->select('t.name as tim',
                DB::raw('SUM(a.total_anggaran) AS total_anggaran'),
                DB::raw('SUM(pa.jumlah_digunakan) AS total_anggaran_digunakan'),
                DB::raw('(SUM(a.total_anggaran) - SUM(pa.jumlah_digunakan)) AS sisa_anggaran'))
            ->groupBy('t.name')
            ->get();

        // Penggunaan Anggaran per Jenis Pembiayaan
        $penggunaanPerJenisPembiayaan = DB::table('penggunaan_anggaran as pa')
            ->join('detail_pembiayaan as dp', 'pa.detail_pembiayaan_id', '=', 'dp.id')
            ->join('jenis_pembiayaan as jp', 'dp.jenis_pembiayaan_id', '=', 'jp.id')
            ->select('jp.nama_pembiayaan', DB::raw('SUM(pa.jumlah_digunakan) AS total_digunakan'))
            ->groupBy('jp.nama_pembiayaan')
            ->get();

        // Penggunaan Anggaran per Periode
        $penggunaanPeriode = DB::table('penggunaan_anggaran as pa')
            ->join('periode as p', 'pa.periode_id', '=', 'p.id')
            ->join('anggaran as a', 'p.anggaran_id', '=', 'a.id')
            ->join('tims as t', 'a.tim_id', '=', 't.id')
            ->select('t.name as tim', 'p.nama_periode', DB::raw('SUM(pa.jumlah_digunakan) AS total_digunakan'))
            ->groupBy('t.name', 'p.nama_periode')
            ->orderBy('p.nama_periode')
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
            ->select('t.name as tim',
                DB::raw('SUM(p.anggaran_periode) AS total_anggaran_periode'),
                DB::raw('SUM(pa.jumlah_digunakan) AS total_digunakan'),
                DB::raw('(SUM(p.anggaran_periode) - SUM(pa.jumlah_digunakan)) AS sisa_anggaran'))
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
            'laporanPembayaran'
        ));
    }
}
