<?php

namespace App\Http\Controllers\Admin\Wisata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KanvasingWisata;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Admin;


class KoordinatorKecematanWisataController extends Controller
{
    public function dashboard()
    {
        $jumlahRespondenJenisKelamin = KanvasingWisata::select('jenis_kelamin', DB::raw('COUNT(*) AS jumlah_responden'))
            ->groupBy('jenis_kelamin')
            ->get();

        // 2. Distribusi Usia Responden
        $distribusiUsia = KanvasingWisata::select(DB::raw('YEAR(CURDATE()) - YEAR(tgl_lahir) AS usia'), DB::raw('COUNT(*) AS jumlah_responden'))
            ->groupBy('usia')
            ->orderBy('usia')
            ->get();

        // 3. Jumlah Responden Berdasarkan Pekerjaan
        $jumlahRespondenPekerjaan = DB::table('kanvasing_wisata AS kw')
            ->join('pekerjaans AS p', 'kw.pekerjaan_id', '=', 'p.id')
            ->select('p.name AS nama_pekerjaan', DB::raw('COUNT(*) AS jumlah_responden'))
            ->groupBy('p.name') // Mengelompokkan berdasarkan ID pekerjaan
            ->get();

        // 4. Jumlah Responden per Kecamatan
        $jumlahRespondenKecamatan = KanvasingWisata::select('k.nama_kecamatan', DB::raw('COUNT(*) AS jumlah_responden'))
            ->join('kecamatan as k', 'kanvasing_wisata.kecematan_id', '=', 'k.id')
            ->groupBy('k.id', 'k.nama_kecamatan')
            ->get();


        // 5. Jumlah Responden per Kelurahan
        $jumlahRespondenKelurahan = KanvasingWisata::select('kelurahan_id', DB::raw('COUNT(*) AS jumlah_responden'))
            ->groupBy('kelurahan_id')
            ->get();

        // 6. Peta Lokasi Responden
        $lokasiResponden = KanvasingWisata::select('longitude', 'latitude')
            ->whereNotNull('longitude')
            ->whereNotNull('latitude')
            ->get();

        // 7. Jumlah Penggunaan Brosur, Stiker, dan Kartu Coblos
        $jumlahPenggunaanPromosi = KanvasingWisata::select(
            DB::raw('SUM(brosur) AS total_brosur'),
            DB::raw('SUM(stiker) AS total_stiker'),
            DB::raw('SUM(kartu_coblos) AS total_kartu_coblos')
        )->first();

        // 8. Jumlah Responden per Hari/Minggu/Bulan
        // a. Per Hari
        $jumlahRespondenPerHari = KanvasingWisata::select(DB::raw('DATE(created_at) AS tanggal'), DB::raw('COUNT(*) AS jumlah_responden'))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // b. Per Minggu
        $jumlahRespondenPerMinggu = KanvasingWisata::select(DB::raw('YEARWEEK(created_at, 1) AS minggu'), DB::raw('COUNT(*) AS jumlah_responden'))
            ->groupBy('minggu')
            ->get();

        // c. Per Bulan
        $jumlahRespondenPerBulan = KanvasingWisata::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS bulan'), DB::raw('COUNT(*) AS jumlah_responden'))
            ->groupBy('bulan')
            ->get();

        // 9. Jumlah Kegiatan Berdasarkan Pengguna
        $jumlahKegiatanPengguna = KanvasingWisata::select('user_id', DB::raw('COUNT(foto_kegiatan) AS jumlah_kegiatan'))
            ->whereNotNull('foto_kegiatan')
            ->groupBy('user_id')
            ->get();

        // 10. Jumlah Keseluruhan Terupdate
        $jumlahKeseluruhanTerupdate = KanvasingWisata::count();

        // 11. Aktivitas Per Promosi (Brosur, Stiker, Kartu Coblos)
        $aktivitasPerPromosi = KanvasingWisata::select(
            DB::raw('SUM(brosur) AS total_brosur'),
            DB::raw('SUM(stiker) AS total_stiker'),
            DB::raw('SUM(kartu_coblos) AS total_kartu_coblos')
        )->first();

        // 12. Rata-rata Responden per User
        $rataRataRespondenPerUser = KanvasingWisata::with('user:id,name')
            ->select('user_id', DB::raw('COUNT(*) / COUNT(DISTINCT user_id) AS rata_rata_responden'))
            ->groupBy('user_id')
            ->get();



        // 13. Jumlah Responden per Wilayah
        $jumlahRespondenWilayah = DB::table('kanvasing_wisata AS kw')
            ->select('w.nama_wilayah', DB::raw('COUNT(*) AS jumlah_responden'))
            ->join('kecamatan AS k', 'kw.kecematan_id', '=', 'k.id')
            ->join('wilayah AS w', 'k.wilayah_id', '=', 'w.id')
            ->groupBy('w.id', 'w.nama_wilayah')
            ->orderBy('jumlah_responden', 'DESC')
            ->get();



        // Mengirim data ke view
        return view('admin.wisata.koordinator.wilayah.dashboard', compact(
            'jumlahRespondenJenisKelamin',
            'distribusiUsia',
            'jumlahRespondenPekerjaan',
            'jumlahRespondenKecamatan',
            'jumlahRespondenKelurahan',
            'lokasiResponden',
            'jumlahPenggunaanPromosi',
            'jumlahRespondenPerHari',
            'jumlahRespondenPerMinggu',
            'jumlahRespondenPerBulan',
            'jumlahKegiatanPengguna',
            'jumlahKeseluruhanTerupdate',
            'aktivitasPerPromosi',
            'rataRataRespondenPerUser',
            'jumlahRespondenWilayah'
        ));
    }

    // Fungsi untuk halaman laporan
    public function laporan()
    {
        $admin = Auth::guard('admin')->user();
        $sentReports = $admin->reports()->with('assignee')->get();
        $receivedReports = $admin->assignedReports()->with('creator')->get();

        return view('admin.reports.index', data: compact('sentReports', 'receivedReports'));
    }


    public function create()
    {
        $atasans = Admin::where('id', '<>', Auth::id())->get();
        return view('admin.reports.create', compact('atasans'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'assigned_to' => 'required|exists:admins,id',
            'report_content' => 'required|string',
            'period' => 'required|string',
        ]);

        Report::create([
            'created_by' => Auth::id(),
            'assigned_to' => $request->input('assigned_to'),
            'report_content' => $request->input('report_content'),
            'period' => $request->input('period'),
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil dikirim.');
    }

    public function show($id)
    {
        $report = Report::with(['creator', 'assignee'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }




}
