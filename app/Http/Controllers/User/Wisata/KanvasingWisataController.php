<?php

namespace App\Http\Controllers\User\Wisata;

use App\Http\Controllers\Controller;
use App\Models\KanvasingWisata;
use App\Models\kanvasing_ds;
use App\Models\kanvasing_aisyiah;
use App\Models\kanvasing_mm;
use App\Models\kanvasing_pkh;
use App\Models\Kecematan;
use App\Models\Kelurahan;
use App\Models\pekerjaan;
use App\Models\data_ganda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\FileUploadTrait;

class KanvasingWisataController extends Controller
{
    use FileUploadTrait;

    // Method untuk menampilkan semua data
    public function index()
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login terlebih dahulu!']);
        }

        $authUserId = auth()->id(); // Mendapatkan ID user yang sedang login
        $timId = auth()->user()->tim_id; // Mendapatkan tim ID dari user

        // Pemilihan model berdasarkan tim_id
        if ($timId == 1) {
            $kanvasingWisata = kanvasing_ds::with(['kecematan', 'kelurahan'])
                ->where('user_id', $authUserId)
                ->get();
        } elseif ($timId == 2) {
            $kanvasingWisata = kanvasing_pkh::with(['kecematan', 'kelurahan'])
                ->where('user_id', $authUserId)
                ->get();
        } elseif ($timId == 3) {
            $kanvasingWisata = kanvasing_mm::with(['kecematan', 'kelurahan'])
                ->where('user_id', $authUserId)
                ->get();
        } elseif ($timId == 4) {
            $kanvasingWisata = kanvasing_aisyiah::with(['kecematan', 'kelurahan'])
                ->where('user_id', $authUserId)
                ->get();
        } else {
            $kanvasingWisata = KanvasingWisata::with(['kecematan', 'kelurahan'])
                ->where('user_id', $authUserId)
                ->get();
        }


        $totalPerTanggal = $kanvasingWisata->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($row) {
            return count($row);
        });


        return view('mobile.frontend.kanvasing_wisata.index', compact('kanvasingWisata', 'totalPerTanggal'));
    }

    // Method untuk menampilkan form pembuatan data baru
    public function create()
    {
        $kecamatans = Kecematan::all();
        $pekerjaans = pekerjaan::all();

        return view('mobile.frontend.kanvasing_wisata.create', compact('kecamatans', 'pekerjaans'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'kecematan_id' => 'required',
    //         'kelurahan_id' => 'required',
    //         'no_ktp' => 'required|string|max:16',
    //         'nama_responden' => 'required|string|max:255',
    //         'tgl_lahir' => 'required|date',
    //         'jenis_kelamin' => 'required|string|max:10',
    //         'pekerjaan_id' => 'required',
    //         'alamat' => 'required|string|max:255',
    //         'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         // 'brosur' => 'required|boolean',
    //         // 'stiker' => 'required|boolean',
    //         // 'kartu_coblos' => 'required|boolean',
    //         'longitude' => 'required|numeric',
    //         'latitude' => 'required|numeric',
    //     ]);

    //     $imagePath = $this->handleFileUpload($request, 'foto_kegiatan');
    //     $timId = auth()->user()->tim_id;

    //     // Pemilihan model berdasarkan tim_id
    //     if ($timId == 1) {
    //         $kanvasingWisata = new kanvasing_ds();
    //     } elseif ($timId == 2) {
    //         $kanvasingWisata = new kanvasing_pkh();
    //     } elseif ($timId == 3) {
    //         $kanvasingWisata = new kanvasing_mm();
    //     } elseif ($timId == 4) {
    //         $kanvasingWisata = new kanvasing_aisyiah();
    //     } else {
    //         $kanvasingWisata = new KanvasingWisata();
    //         $kanvasingWisata->jadwal = $request->jadwal;

    //     }

    //     $kanvasingWisata->user_id = $request->user_id;
    //     $kanvasingWisata->kecematan_id = $request->kecematan_id;
    //     $kanvasingWisata->kelurahan_id = $request->kelurahan_id;
    //     $kanvasingWisata->no_ktp = $request->no_ktp;
    //     $kanvasingWisata->nama_responden = $request->nama_responden;
    //     $kanvasingWisata->tgl_lahir = $request->tgl_lahir;
    //     $kanvasingWisata->jenis_kelamin = $request->jenis_kelamin;
    //     $kanvasingWisata->pekerjaan_id = $request->pekerjaan_id;
    //     $kanvasingWisata->alamat = $request->alamat;
    //     $kanvasingWisata->status = $request->status == 0;
    //     $kanvasingWisata->hadir = $request->hadir == 0;
    //     $kanvasingWisata->foto_kegiatan = $imagePath ?? null;
    //     // $kanvasingWisata->brosur = $request->brosur;
    //     // $kanvasingWisata->stiker = $request->stiker;
    //     // $kanvasingWisata->kartu_coblos = $request->kartu_coblos;
    //     $kanvasingWisata->longitude = $request->longitude;
    //     $kanvasingWisata->latitude = $request->latitude;

    //     $kanvasingWisata->save();

    //     $data_ganda = new data_ganda();
    //     $data_ganda->kecamatan = $request->kecematan_id;
    //     $data_ganda->nagari = $request->kelurahan_id;
    //     $data_ganda->no_ktp = $request->no_ktp;
    //     $data_ganda->nama_responden = $request->nama_responden;
    //     $data_ganda->alamat = $request->alamat;
    //     $data_ganda->longitude = $request->longitude;
    //     $data_ganda->latitude = $request->latitude;
    //     $data_ganda->save();

    //     return redirect()->route('kanvasing_wisata.create')->with('message', 'Data berhasil disimpan!');
    // }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kecematan_id' => 'required',
            'kelurahan_id' => 'required',
            'no_ktp' => 'required|string|max:16',
            'no_hp' => 'required|string|max:13',
            'nama_responden' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'pekerjaan_id' => 'required',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);
        $timId = auth()->user()->tim_id;

        if ($timId == 1) {
            $kanvasingWisata = new kanvasing_ds();
            $existingEntry = kanvasing_ds::where('no_ktp', $request->no_ktp)->exists();
        } elseif ($timId == 2) {
            $kanvasingWisata = new kanvasing_pkh();
            $existingEntry = kanvasing_pkh::where('no_ktp', $request->no_ktp)->exists();
        } elseif ($timId == 3) {
            $kanvasingWisata = new kanvasing_mm();
            $existingEntry = kanvasing_mm::where('no_ktp', $request->no_ktp)->exists();
        } elseif ($timId == 4) {
            $kanvasingWisata = new kanvasing_aisyiah();
            $existingEntry = kanvasing_aisyiah::where('no_ktp', $request->no_ktp)->exists();
        } else {
            $kanvasingWisata = new KanvasingWisata();
            $kanvasingWisata->jadwal = $request->jadwal;
            $existingEntry = KanvasingWisata::where('no_ktp', $request->no_ktp)->exists();
        }

        // Cek entri duplikat
        if ($existingEntry) {
            return redirect()->back()->withErrors(['error' => 'Nomor KTP sudah terdaftar!']);
        }

        $imagePath = $this->handleFileUpload($request, 'foto');

        if ($timId == 1) {
            $kanvasingWisata = new kanvasing_ds();
        } elseif ($timId == 2) {
            $kanvasingWisata = new kanvasing_pkh();
        } elseif ($timId == 3) {
            $kanvasingWisata = new kanvasing_mm();
        } elseif ($timId == 4) {
            $kanvasingWisata = new kanvasing_aisyiah();
        } else {
            $kanvasingWisata = new KanvasingWisata();
            $kanvasingWisata->jadwal = $request->jadwal;
        }

        $kanvasingWisata->user_id = $request->user_id;
        $kanvasingWisata->kecematan_id = $request->kecematan_id;
        $kanvasingWisata->kelurahan_id = $request->kelurahan_id;
        $kanvasingWisata->no_ktp = $request->no_ktp;
        $kanvasingWisata->no_hp = $request->no_hp;
        $kanvasingWisata->nama_responden = $request->nama_responden;
        $kanvasingWisata->tgl_lahir = $request->tgl_lahir;
        $kanvasingWisata->jenis_kelamin = $request->jenis_kelamin;
        $kanvasingWisata->pekerjaan_id = $request->pekerjaan_id;
        $kanvasingWisata->alamat = $request->alamat;
        $kanvasingWisata->status = $request->status == 0;
        $kanvasingWisata->hadir = $request->hadir == 0;
        $kanvasingWisata->foto_kegiatan = $imagePath ?? null;
        $kanvasingWisata->longitude = $request->longitude;
        $kanvasingWisata->latitude = $request->latitude;

        $kanvasingWisata->save();

        // Simpan data ganda
        $data_ganda = new data_ganda();
        $data_ganda->kecamatan = $request->kecematan_id;
        $data_ganda->nagari = $request->kelurahan_id;
        $data_ganda->no_ktp = $request->no_ktp;
        $data_ganda->nama_responden = $request->nama_responden;
        $data_ganda->alamat = $request->alamat;
        $data_ganda->longitude = $request->longitude;
        $data_ganda->latitude = $request->latitude;
        $data_ganda->save();


        return redirect()->route('kanvasing_wisata.create')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    public function toggleHadir(Request $request)
    {
        try {
            $timId = auth()->user()->tim_id;

            // Pemilihan model berdasarkan tim_id
            if ($timId == 1) {
                $wisata = kanvasing_ds::findOrFail($request->id);
            } elseif ($timId == 2) {
                $wisata = kanvasing_pkh::findOrFail($request->id);
            } elseif ($timId == 3) {
                $wisata = kanvasing_mm::findOrFail($request->id);
            } elseif ($timId == 4) {
                $wisata = kanvasing_aisyiah::findOrFail($request->id);
            } else {
                $wisata = KanvasingWisata::findOrFail($request->id);
            }

            $wisata->{$request->nama_responden} = $request->hadir;
            $wisata->save();

            return response(['status' => 'success', 'message' => __('admin.Updated successfully!')]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $kanvasingWisata = KanvasingWisata::findOrFail($id);
        return response()->json($kanvasingWisata);
    }

    public function edit($id)
    {
        $kanvasingWisata = KanvasingWisata::findOrFail($id);
        return view('kanvasing_wisata.edit', compact('kanvasingWisata'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kecematan_id' => 'required',
            'kelurahan_id' => 'required',
            'no_kk' => 'required|string|max:16',
            'no_hp' => 'required|string|max:13',
            'nama_responden' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'pekerjaan_id' => 'required',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'brosur' => 'required|boolean',
            // 'stiker' => 'required|boolean',
            // 'kartu_coblos' => 'required|boolean',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $timId = auth()->user()->tim_id;

        // Pemilihan model berdasarkan tim_id
        if ($timId == 1) {
            $kanvasingWisata = kanvasing_ds::findOrFail($id);
        } elseif ($timId == 2) {
            $kanvasingWisata = kanvasing_pkh::findOrFail($id);
        } elseif ($timId == 3) {
            $kanvasingWisata = kanvasing_mm::findOrFail($id);
        } elseif ($timId == 4) {
            $kanvasingWisata = kanvasing_aisyiah::findOrFail($id);
        } else {
            $kanvasingWisata = KanvasingWisata::findOrFail($id);
        }

        // Upload foto kegiatan jika ada file baru
        $imagePath = $this->handleFileUpload($request, 'foto_kegiatan');

        // Update data
        $kanvasingWisata->update(array_merge($request->all(), [
            'foto_kegiatan' => $imagePath ?? $kanvasingWisata->foto_kegiatan,
        ]));

        return response()->json([
            'message' => 'Data berhasil diperbarui!',
            'kanvasingWisata' => $kanvasingWisata,
        ]);
    }

    public function destroy($id)
    {
        $kanvasingWisata = KanvasingWisata::findOrFail($id);
        $kanvasingWisata->delete();

        return response()->json(['message' => 'Data berhasil dihapus!']);
    }



    public function getKelurahans(Request $request)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $request->kecamatan_id)->get();
        return response()->json($kelurahans);
    }
}
