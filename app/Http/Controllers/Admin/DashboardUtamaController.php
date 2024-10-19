<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\tim;
use App\Models\anggaran;
use App\Models\periode;
use App\Models\jenis_pembiayaan;
use App\Models\laporan_kegiatan;
use App\Models\kanvasing_ds;
use App\Models\kanvasing_pkh;
use App\Models\kanvasing_mm;
use App\Models\kanvasing_aisyiah;
use App\Models\kanvasing_parpol;
use App\Models\kanvasing_jj;
use App\Models\spanduk_ds;
use App\Models\spanduk_pkh;
use App\Models\spanduk_mm;
use App\Models\spanduk_aisyiah;
// use App\Models\spanduk_parpol;
use App\Models\spanduk_jj;
use App\Models\data_ganda;
use App\Models\KanvasingWisata;

class DashboardUtamaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Dashboard Utama,admin'])->only(['index']);
    }

    public function index()
    {
        $counts = [
            'Tim' => tim::count(),
            'Anggaran' => anggaran::count(),
            'Periode' => periode::count(),
            'Jenis Pembiayaan' => jenis_pembiayaan::count(),
            'Laporan Kegiatan' => laporan_kegiatan::count(),
            'Kanvasing DS' => kanvasing_ds::count(),
            'Kanvasing PKH' => kanvasing_pkh::count(),
            'Kanvasing Muhammdiyah' => kanvasing_mm::count(),
            'Kanvasing Aisyiah' => kanvasing_aisyiah::count(),
            'Kanvasing Wisata' => KanvasingWisata::count(),
            'Data Ganda' => data_ganda::select('no_ktp')->groupBy('no_ktp')->havingRaw('COUNT(no_ktp) > 1')->get()->count(),
        ];

        return view('admin.dashboard.dashboard-utama', compact('counts'));
    }



    public function kanvasing()
    {

        // Ambil semua data dari setiap tabel kanvasing
        $kanvasingWisataDs = DB::table('kanvasing_ds')->get();
        $kanvasingWisataPkhs = DB::table('kanvasing_pkhs')->get();
        $kanvasingWisataMms = DB::table('kanvasing_mms')->get();
        $kanvasingWisataAisyiahs = DB::table('kanvasing_aisyiahs')->get();
        $kanvasingWisata = DB::table('kanvasing_wisata')->get();

        // Gabungkan semua hasil ke dalam satu koleksi
        $kanvasingWisataAll = $kanvasingWisataDs
            ->merge($kanvasingWisataPkhs)
            ->merge($kanvasingWisataMms)
            ->merge($kanvasingWisataAisyiahs)
            ->merge($kanvasingWisata);

        // Total Kanvasing
        $totalKanvasing = $kanvasingWisataAll->count();

        // Kanvasing Harian
        $kanvasingHarian = $kanvasingWisataAll->filter(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->isToday();
        })->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H'); // Mengelompokkan berdasarkan tanggal dan jam
        })->map(function ($group) {
            return $group->count(); // Menghitung total per jam
        });

        // Kanvasing Mingguan
        $startDate = now()->subDays(6); // 7 hari termasuk hari ini
        $endDate = now();
        $kanvasingMingguan = $kanvasingWisataAll->filter(function ($item) use ($startDate, $endDate) {
            return \Carbon\Carbon::parse($item->created_at)->between($startDate, $endDate);
        })->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d'); // Mengelompokkan berdasarkan tanggal
        })->map(function ($group) {
            return $group->count(); // Menghitung total per tanggal
        });

        // Kanvasing Bulanan
        $kanvasingBulanan = $kanvasingWisataAll->filter(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->year == now()->year; // Hanya ambil tahun ini
        })->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->format('m'); // Mengelompokkan berdasarkan bulan
        })->map(function ($group) {
            return $group->count(); // Menghitung total per bulan
        });

        // Jumlah Kanvasing berdasarkan Wilayah, Kecamatan, dan Kelurahan
        $kanvasingPerLokasi = DB::table('kelurahan as kel')
            ->join('kecamatan as kec', 'kel.kecamatan_id', '=', 'kec.id')
            ->join('wilayah as w', 'kec.wilayah_id', '=', 'w.id')
            ->leftJoin('kanvasing_ds as kw', 'kw.kelurahan_id', '=', 'kel.id')
            ->select('w.nama_wilayah', 'kec.nama_kecamatan', 'kel.nama_kelurahan', DB::raw('COUNT(kw.id) as total_kanvasing'))
            ->groupBy('w.nama_wilayah', 'kec.nama_kecamatan', 'kel.nama_kelurahan')
            ->get();

        // Jumlah Kanvasing berdasarkan Wilayah
        $kanvasingPerWilayah = DB::table('wilayah as w')
            ->select('w.id as wilayah_id', 'w.nama_wilayah', DB::raw('COUNT(k.id) as jumlah_kanvasing'))
            ->leftJoin('kecamatan as kc', 'w.id', '=', 'kc.wilayah_id')
            ->leftJoin('kelurahan as kl', 'kc.id', '=', 'kl.kecamatan_id')
            ->leftJoin('kanvasing_ds as k', 'kl.id', '=', 'k.kelurahan_id') // Menyertakan hanya salah satu tabel untuk join
            ->groupBy('w.id', 'w.nama_wilayah')
            ->orderBy('w.nama_wilayah')
            ->get();


        $counts = [
            'Kanvasing DS' => kanvasing_ds::count(),
            'Kanvasing PKH' => kanvasing_pkh::count(),
            'Kanvasing Muhammdiyah' => kanvasing_mm::count(),
            'Kanvasing Aisyiah' => kanvasing_aisyiah::count(),
            'Kanvasing Wisata' => KanvasingWisata::count(),
            'Data Ganda' => data_ganda::select('no_ktp')->groupBy('no_ktp')->havingRaw('COUNT(no_ktp) > 1')->get()->count(),
        ];

        return view('admin.dashboard.dashboard-kanvasing',

        compact(
            'counts',
            'totalKanvasing',
            'kanvasingHarian',
            'kanvasingMingguan',
            'kanvasingBulanan',
            'kanvasingPerLokasi',
            'kanvasingPerWilayah',
            'kanvasingWisataAll'
        ));
    }
}
