<?php

namespace App\Http\Controllers\User\Wisata;

use App\Http\Controllers\Controller;
use App\Models\KanvasingWisata;
use App\Models\Kecematan;
use App\Models\Kelurahan;
use App\Models\pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Traits\FileUploadTrait;


class KanvasingWisataController extends Controller
{

    use FileUploadTrait;

    // Method untuk menampilkan semua data
    public function index()
    {
        $kanvasingWisata = KanvasingWisata::all();
        return response()->json($kanvasingWisata);
    }

    // Method untuk menampilkan form pembuatan data baru
    public function create()
    {
        $kecamatans = Kecematan::all();
        $pekerjaans  = pekerjaan::all();

        return view('mobile.frontend.kanvasing_wisata.create', compact('kecamatans', 'pekerjaans'));
    }



    public function store(Request $request)
    {

        dd($request);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kecematan_id' => 'required',
            'kelurahan_id' => 'required',
            'no_kk' => 'required|string|max:16',
            'no_ktp' => 'required|string|max:16',
            'nama_responden' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'pekerjaan_id' => 'required',
            'alamat' => 'required|string|max:255',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'brosur' => 'required|boolean',
            'stiker' => 'required|boolean',
            'kartu_coblos' => 'required|boolean',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        // Menyimpan payload ke log
        Log::info('Incoming request payload:', $request->all());

        // Upload foto kegiatan
        $imagePath = $this->handleFileUpload($request, 'foto_kegiatan');

        // Membuat instance KanvasingWisata baru
        $kanvasingWisata = new KanvasingWisata();
        $kanvasingWisata->user_id = $request->user_id;
        $kanvasingWisata->kecematan_id = $request->kecematan_id;
        $kanvasingWisata->kelurahan_id = $request->kelurahan_id;
        $kanvasingWisata->no_kk = $request->no_kk;
        $kanvasingWisata->no_ktp = $request->no_ktp;
        $kanvasingWisata->nama_responden = $request->nama_responden;
        $kanvasingWisata->tgl_lahir = $request->tgl_lahir;
        $kanvasingWisata->jenis_kelamin = $request->jenis_kelamin;
        $kanvasingWisata->pekerjaan_id = $request->pekerjaan_id;
        $kanvasingWisata->alamat = $request->alamat;
        $kanvasingWisata->foto_kegiatan = !empty($imagePath) ? $imagePath : null; // Menyimpan foto_kegiatan jika ada
        $kanvasingWisata->brosur = $request->brosur;
        $kanvasingWisata->stiker = $request->stiker;
        $kanvasingWisata->kartu_coblos = $request->kartu_coblos;
        $kanvasingWisata->longitude = $request->longitude;
        $kanvasingWisata->latitude = $request->latitude;

        // Menyimpan data ke database
        $kanvasingWisata->save();


        // Menyimpan data ke model data_ganda
        $dataGanda = new \App\Models\data_ganda();
        $dataGanda->kecamatan = $request->kecematan_id; // Sesuaikan dengan data kecamatan
        $dataGanda->nagari = $request->kelurahan_id; // Sesuaikan dengan data kelurahan
        $dataGanda->no_ktp = $request->no_ktp;
        $dataGanda->no_kk = $request->no_kk;
        $dataGanda->nama_responden = $request->nama_responden;
        $dataGanda->alamat = $request->alamat;
        $dataGanda->longitude = $request->longitude;
        $dataGanda->latitude = $request->latitude;

        // Menyimpan data ke database
        $dataGanda->save();
        // Log status penyimpanan data
        Log::info('Data stored successfully:', [
            'kanvasing_wisata_id' => $kanvasingWisata->id,
            'payload' => $kanvasingWisata
        ]);

        // Mengalihkan ke rute kanvasing_wisata.create
        return redirect()->route('kanvasing_wisata.create')->with('message', 'Data berhasil disimpan!');
    }


    // Method untuk menampilkan detail data berdasarkan ID
    public function show($id)
    {
        $kanvasingWisata = KanvasingWisata::findOrFail($id);
        return response()->json($kanvasingWisata);
    }

    // Method untuk menampilkan form edit data
    public function edit($id)
    {
        $kanvasingWisata = KanvasingWisata::findOrFail($id);
        return view('kanvasing_wisata.edit', compact('kanvasingWisata'));
    }

    // Method untuk memperbarui data berdasarkan ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kecematan_id' => 'required',
            'kelurahan_id' => 'required',
            'no_kk' => 'required|string|max:16',
            'no_ktp' => 'required|string|max:16',
            'nama_responden' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'pekerjaan_id' => 'required',
            'alamat' => 'required|string|max:255',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'brosur' => 'required|boolean',
            'stiker' => 'required|boolean',
            'kartu_coblos' => 'required|boolean',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $kanvasingWisata = KanvasingWisata::findOrFail($id);

        // Upload foto kegiatan jika ada file baru
        $imagePath = $this->handleFileUpload($request, 'foto_kegiatan');

        // Update data
        $kanvasingWisata->update(array_merge($request->all(), [
            'foto_kegiatan' => $imagePath ?? $kanvasingWisata->foto_kegiatan, // Tetap gunakan file lama jika tidak ada yang baru
        ]));

        return response()->json([
            'message' => 'Data berhasil diperbarui!',
            'data' => $kanvasingWisata
        ], 200);
    }

    // Method untuk menghapus data berdasarkan ID
    public function destroy($id)
    {
        $kanvasingWisata = KanvasingWisata::findOrFail($id);
        $kanvasingWisata->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ], 200);
    }


    public function getKelurahans(Request $request)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $request->kecamatan_id)->get(); // Ambil kelurahan berdasarkan kecamatan_id
        return response()->json($kelurahans);
    }
}
