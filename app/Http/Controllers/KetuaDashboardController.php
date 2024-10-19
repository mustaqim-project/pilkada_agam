<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KetuaDashboardController extends Controller
{
    public function kanvasingDashboard()
    {
        $totalKanvasing = DB::table('kanvasing_wisata')->count();

        // Kanvasing Harian
        $kanvasingHarian = DB::table('kanvasing_wisata')
            ->whereDate('created_at', now())
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total'))
            ->groupBy('date', 'hour')
            ->get();

        // Kanvasing Mingguan
        $startDate = now()->subDays(6); // 7 hari termasuk hari ini
        $endDate = now();
        $kanvasingMingguan = DB::table('kanvasing_wisata')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->get();

        // Kanvasing Bulanan
        $kanvasingBulanan = DB::table('kanvasing_wisata')
            ->whereYear('created_at', now()->year)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get();

        // Jumlah Kanvasing berdasarkan Wilayah, Kecamatan, dan Kelurahan
        $kanvasingPerLokasi = DB::table('kanvasing_wisata as kw')
        ->join('kelurahan as kel', 'kw.kelurahan_id', '=', 'kel.id')
        ->join('kecamatan as kec', 'kel.kecamatan_id', '=', 'kec.id')
        ->join('wilayah as w', 'kec.wilayah_id', '=', 'w.id')
        ->select('w.nama_wilayah', 'kec.nama_kecamatan', 'kel.nama_kelurahan', DB::raw('COUNT(kw.id) as total_kanvasing'))
        ->groupBy('w.nama_wilayah', 'kec.nama_kecamatan', 'kel.nama_kelurahan')
        ->get();
// Jumlah Kanvasing berdasarkan Wilayah
$kanvasingPerWilayah = DB::table('wilayah as w')
    ->select('w.id as wilayah_id', 'w.nama_wilayah', DB::raw('COUNT(k.id) as jumlah_kanvasing'))
    ->leftJoin('kecamatan as kc', 'w.id', '=', 'kc.wilayah_id')
    ->leftJoin('kelurahan as kl', 'kc.id', '=', 'kl.kecamatan_id')
    ->leftJoin('kanvasing_wisata as k', 'kl.id', '=', 'k.kelurahan_id')
    ->groupBy('w.id', 'w.nama_wilayah')
    ->orderBy('w.nama_wilayah')
    ->get();


        return view('admin.dashboard.ketuatim', compact(
            'totalKanvasing',
            'kanvasingHarian',
            'kanvasingMingguan',
            'kanvasingBulanan',
            'kanvasingPerLokasi',
            'kanvasingPerWilayah'
        ));
    }
}
