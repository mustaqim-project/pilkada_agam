<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KetuaDashboardController extends Controller
{



    public function kanvasingDashboard()
    {
        $admin = Auth::guard('admin')->user();
        $authUserId = $admin->id;
        $timId = $admin->tim_id;


        switch ($timId) {
            case 1:
                $kanvasingWisata = DB::table('kanvasing_ds')->where('user_id', $authUserId)->get();
                $kanvasingTable = 'kanvasing_ds';
                break;
            case 2:
                $kanvasingWisata = DB::table('kanvasing_pkhs')->where('user_id', $authUserId)->get();
                $kanvasingTable = 'kanvasing_pkhs';
                break;
            case 3:
                $kanvasingWisata = DB::table('kanvasing_mms')->where('user_id', $authUserId)->get();
                $kanvasingTable = 'kanvasing_mms';
                break;
            case 4:
                $kanvasingWisata = DB::table('kanvasing_aisyiahs')->where('user_id', $authUserId)->get();
                $kanvasingTable = 'kanvasing_aisyiahs';
                break;
            default:
                $kanvasingWisata = DB::table('kanvasing_wisata')->where('user_id', $authUserId)->get();
                $kanvasingTable = 'kanvasing_wisata';
                break;
        }

        // Total Kanvasing
        $totalKanvasing = DB::table($kanvasingTable)->count();

        // Kanvasing Harian
        $kanvasingHarian = DB::table($kanvasingTable)
            ->whereDate('created_at', now())
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total'))
            ->groupBy('date', 'hour')
            ->get();

        // Kanvasing Mingguan
        $startDate = now()->subDays(6); // 7 hari termasuk hari ini
        $endDate = now();
        $kanvasingMingguan = DB::table($kanvasingTable)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->get();

        // Kanvasing Bulanan
        $kanvasingBulanan = DB::table($kanvasingTable)
            ->whereYear('created_at', now()->year)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get();

        // Jumlah Kanvasing berdasarkan Wilayah, Kecamatan, dan Kelurahan
        $kanvasingPerLokasi = DB::table($kanvasingTable . ' as kw')
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
            ->leftJoin($kanvasingTable . ' as k', 'kl.id', '=', 'k.kelurahan_id')
            ->groupBy('w.id', 'w.nama_wilayah')
            ->orderBy('w.nama_wilayah')
            ->get();

        return view('admin.dashboard.ketuatim', compact(
            'totalKanvasing',
            'kanvasingHarian',
            'kanvasingMingguan',
            'kanvasingBulanan',
            'kanvasingPerLokasi',
            'kanvasingPerWilayah',
            'kanvasingWisata' // Menambahkan variabel kanvasingWisata ke view
        ));
    }
}
