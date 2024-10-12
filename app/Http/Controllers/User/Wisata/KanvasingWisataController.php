<?php

namespace App\Http\Controllers\User\Wisata;

use App\Http\Controllers\Controller;
use App\Models\KanvasingWisata;
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

        // dd($request);
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
        ]);


        $imagePath = $this->handleFileUpload($request, 'foto_kegiatan');

        // Membuat instance KanvasingWisata baru
        $kanvasingWisata = new KanvasingWisata();
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
        $kanvasingWisata->status = $request->status == 0 ;
        $kanvasingWisata->hadir = $request->hadir == 0 ;

        // $kanvasingWisata->foto_kegiatan = !empty($imagePath) ? $imagePath : null;
        // $kanvasingWisata->brosur = $request->brosur;
        // $kanvasingWisata->stiker = $request->stiker;
        // $kanvasingWisata->kartu_coblos = $request->kartu_coblos;
        // $kanvasingWisata->longitude = $request->longitude;
        // $kanvasingWisata->latitude = $request->latitude;

        $kanvasingWisata->save();


        $data_ganda = new data_ganda();
        $data_ganda->kecematan = $request->kecematan_id;
        $data_ganda->nagari = $request->kelurahan_id;
        $data_ganda->no_ktp = $request->no_ktp;
        $data_ganda->nama_responden = $request->nama_responden;
        $data_ganda->alamat = $request->alamat;
        $data_ganda->save();


        return redirect()->route('kanvasing_wisata.create')->with('message', 'Data berhasil disimpan!');
    }




    public function toggleHadir(Request $request)
    {
        try {
            $wisata = KanvasingWisata::findOrFail($request->id);
            $wisata->{$request->nama_responden} = $request->hadir;
            $wisata->save();

            return response(['status' => 'success', 'message' => __('admin.Updated successfully!')]);
        } catch (\Throwable $th) {
            throw $th;
        }
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
        $kelurahans = Kelurahan::where('kecamatan_id', $request->kecamatan_id)->get();
        return response()->json($kelurahans);
    }
}
