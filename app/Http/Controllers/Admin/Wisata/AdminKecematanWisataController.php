<?php

namespace App\Http\Controllers\Admin\Wisata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KanvasingWisata;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Admin;
use App\Models\Kecematan;
use App\Models\Kelurahan;
use App\Models\pekerjaan;
use App\Models\data_ganda;
use Carbon\Carbon;

use App\Traits\FileUploadTrait;

class AdminKecematanWisataController extends Controller
{

    use FileUploadTrait;

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
            'attachment' => 'nullable|string', // Validasi untuk lampiran
        ]);

        Report::create([
            'created_by' => Auth::id(),
            'assigned_to' => $request->input('assigned_to'),
            'report_content' => $request->input('report_content'),
            'period' => $request->input('period'),
            'attachment' => $request->input('attachment'), // Menyimpan lampiran
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil dikirim.');
    }

    public function show($id)
    {
        $report = Report::with(['creator', 'assignee'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }


    public function Kanvasing()
    {
        // Get the authenticated user's ID
        $user_id = Auth::guard('admin')->user()->id;

        // Retrieve the KanvasingWisata records for the logged-in user
        $wisatas = KanvasingWisata::with(['kecematan', 'pekerjaan'])
            ->where('user_id', $user_id) // Filter by user_id
            ->get();

        $kecamatans = Kecematan::all();
        $pekerjaans = Pekerjaan::all(); // Make sure the class name is correct

        return view('admin.wisata.kanvasing', compact('wisatas', 'kecamatans', 'pekerjaans'));
    }

    public function Absensi()
    {
        // Get the authenticated user's ID
        $user_id = Auth::guard('admin')->user()->id;

        $today = Carbon::today();
        $kecamatans = Kecematan::all();
        $pekerjaans = Pekerjaan::all(); // Make sure the class name is correct

        // Retrieve the KanvasingWisata records for the logged-in user on today's date
        $wisatas = KanvasingWisata::with(['kecematan', 'pekerjaan'])
            ->where('user_id', $user_id) // Filter by user_id
            ->whereDate('jadwal', $today) // Filter based on date
            ->get();

        return view('admin.wisata.absensi', compact('wisatas', 'kecamatans', 'pekerjaans'));
    }



    public function storeWisata(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'kecematan_id' => 'required',
            'kelurahan_id' => 'required',
            'no_ktp' => 'required|string|max:16',
            'nama_responden' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'pekerjaan_id' => 'required',
            'no_hp' => 'required',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required|string|max:255',
            'jadwal' => 'required|date',
            'status' => 'required|boolean',
            'hadir' => 'required|boolean',
        ]);

        // Cek apakah no_ktp sudah ada
        $existingKTP = KanvasingWisata::where('no_ktp', $request->no_ktp)->first();
        if ($existingKTP) {
            return redirect()->back()->with('error', 'Data sudah tersedia.')->withInput();
        }

        // Cek usia
        $birthDate = new \Carbon\Carbon($request->tgl_lahir);
        $age = $birthDate->diffInYears(now());

        if ($age < 17 || $age > 35) {
            return redirect()->back()->with('error', 'Usia melebihi atau kurang dari 17-35 tahun.')->withInput();
        }

        // Jika validasi berhasil, simpan data
        $kanvasingWisata = new KanvasingWisata();
        $kanvasingWisata->user_id = Auth::guard('admin')->user()->id;
        $kanvasingWisata->kecematan_id = $request->kecematan_id;
        $kanvasingWisata->kelurahan_id = $request->kelurahan_id;
        $kanvasingWisata->no_ktp = $request->no_ktp;
        $kanvasingWisata->nama_responden = $request->nama_responden;
        $kanvasingWisata->tgl_lahir = $request->tgl_lahir;
        $kanvasingWisata->no_hp = $request->no_hp;
        $kanvasingWisata->jenis_kelamin = $request->jenis_kelamin;
        $kanvasingWisata->pekerjaan_id = $request->pekerjaan_id;
        $kanvasingWisata->alamat = $request->alamat;
        $kanvasingWisata->jadwal = $request->jadwal;
        $kanvasingWisata->status = $request->status == 1 ? 1 : 0;
        $kanvasingWisata->hadir = $request->hadir == 1 ? 1 : 0;

        $kanvasingWisata->save();

        $data_ganda = new data_ganda();
        $data_ganda->kecamatan = $request->kecematan_id;
        $data_ganda->nagari = $request->kelurahan_id;
        $data_ganda->no_ktp = $request->no_ktp;
        $data_ganda->nama_responden = $request->nama_responden;
        $data_ganda->alamat = $request->alamat;
        $data_ganda->longitude = 0;
        $data_ganda->latitude = 0;
        $data_ganda->save();

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }







    public function toggleHadir(Request $request)
    {
        try {
            $wisata = KanvasingWisata::findOrFail($request->id);
            $wisata->hadir = $request->hadir;
            $wisata->save();

            return response(['status' => 'success', 'message' => __('admin.Updated successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin.Update failed!')], 500); // Tangani error
        }
    }


    public function updateWisata(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kecematan_id' => 'required',
            'kelurahan_id' => 'required',
            'no_ktp' => 'required|string|max:16',
            'nama_responden' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'pekerjaan_id' => 'required',
            'alamat' => 'required|string|max:255',
            'jadwal' => 'required|date',
            'status' => 'required|boolean',
            'hadir' => 'required|boolean',
        ]);

        $kanvasingWisata = KanvasingWisata::findOrFail($id);


        $kanvasingWisata->user_id = $request->user_id;
        $kanvasingWisata->kecematan_id = $request->kecematan_id;
        $kanvasingWisata->kelurahan_id = $request->kelurahan_id;
        $kanvasingWisata->no_ktp = $request->no_ktp;
        $kanvasingWisata->nama_responden = $request->nama_responden;
        $kanvasingWisata->tgl_lahir = $request->tgl_lahir;
        $kanvasingWisata->jenis_kelamin = $request->jenis_kelamin;
        $kanvasingWisata->pekerjaan_id = $request->pekerjaan_id;
        $kanvasingWisata->alamat = $request->alamat;
        $kanvasingWisata->jadwal = $request->jadwal;
        $kanvasingWisata->status = $request->status == 1 ? 1 : 0;
        $kanvasingWisata->hadir = $request->hadir == 1 ? 1 : 0;



        $kanvasingWisata->save();

        return back()->with('success', 'Data berhasil diperbarui.');
    }



    public function destroy($id)
    {
        $kanvasingWisata = KanvasingWisata::findOrFail($id);
        $kanvasingWisata->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }


    public function getKelurahans(Request $request)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $request->kecamatan_id)->get();
        return response()->json($kelurahans);
    }
}
