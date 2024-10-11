<?php

namespace App\Http\Controllers\User\Wisata;

use App\Http\Controllers\Controller;
use App\Models\KanvasingWisata;
use Illuminate\Http\Request;

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
        return view('kanvasing_wisata.create');
    }

    // Method untuk menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kecematan_id' => 'required|exists:kecematan,id',
            'kelurahan_id' => 'required|exists:kelurahan,id',
            'no_kk' => 'required|string|max:16',
            'no_ktp' => 'required|string|max:16',
            'nama_responden' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'alamat' => 'required|string|max:255',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'brosur' => 'required|boolean',
            'stiker' => 'required|boolean',
            'kartu_coblos' => 'required|boolean',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        // Upload foto kegiatan
        $imagePath = $this->handleFileUpload($request, 'foto_kegiatan', 'uploads/foto_kegiatan');

        // Menyimpan data ke database
        $kanvasingWisata = KanvasingWisata::create(array_merge($request->all(), [
            'foto_kegiatan' => $imagePath,
        ]));

        return response()->json([
            'message' => 'Data berhasil disimpan!',
            'data' => $kanvasingWisata
        ], 201);
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
            'kecematan_id' => 'required|exists:kecematan,id',
            'kelurahan_id' => 'required|exists:kelurahan,id',
            'no_kk' => 'required|string|max:16',
            'no_ktp' => 'required|string|max:16',
            'nama_responden' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
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
        $imagePath = $this->handleFileUpload($request, 'foto_kegiatan', 'uploads/foto_kegiatan');

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
}
