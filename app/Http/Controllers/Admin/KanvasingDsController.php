<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\kanvasing_ds;
use App\Models\agamas;
use App\Models\pekerjaan;
use Illuminate\Http\Request;

class KanvasingDsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:KanvasingDs index,admin'])->only(['indexAdmin']);
        $this->middleware(['permission:KanvasingDs create,admin'])->only(['store']);
        $this->middleware(['permission:KanvasingDs update,admin'])->only(['update']);
        $this->middleware(['permission:KanvasingDs delete,admin'])->only('destroy');
    }


    public function index()
    {
        $userId = auth()->id();
        $kanvasing = kanvasing_ds::with('agama', 'pekerjaan')
                        ->where('user_id', $userId)
                        ->get();

        $agamas = agamas::all();
        $pekerjaans = pekerjaan::all();

        return view('mobile.kanvasing_ds.index', compact('kanvasing', 'agamas', 'pekerjaans'));
    }

    // Menampilkan halaman index untuk admin
    public function indexAdmin()
    {
        $kanvasing = kanvasing_ds::with('agama', 'pekerjaan')->get();
        $agamas = agamas::all();
        $pekerjaans = pekerjaan::all();

        return view('admin.kanvasing_aisyiah.index', compact('kanvasing', 'agamas', 'pekerjaans'));
    }
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nama_responden' => 'required|string|max:100',
            'agama_id' => 'required|exists:agamas,id',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|unique:kanvasing_ds,no_ktp',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'provinsi' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kelurahan' => 'nullable|string|max:100',
            'no_kk' => 'nullable|string|max:16',
            'foto_kegiatan' => 'nullable|string', // Sesuaikan jika menggunakan file upload
            'brosur' => 'boolean',
            'stiker' => 'boolean',
            'kartu_coblos' => 'boolean',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
        ]);

        // Simpan data kanvasing
        kanvasing_ds::create($request->all() + ['user_id' => auth()->id()]); // Menambahkan user_id saat menyimpan

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kanvasing = kanvasing_ds::findOrFail($id); // Ambil data berdasarkan ID

        // Validasi update form
        $request->validate([
            'nama_responden' => 'required|string|max:100',
            'agama_id' => 'required|exists:agamas,id',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|unique:kanvasing_ds,no_ktp,' . $kanvasing->id,
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'provinsi' => 'required|',
            'kabupaten' => 'required|',
            'kecamatan' => 'required|',
            'kelurahan' => 'required|',
            'no_kk' => 'nullable|string|max:16',
            'foto_kegiatan' => 'nullable|string',
            'brosur' => 'boolean',
            'stiker' => 'boolean',
            'kartu_coblos' => 'boolean',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
        ]);

        // Update data kanvasing
        $kanvasing->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $kanvasing = kanvasing_ds::findOrFail($id);
        $kanvasing->delete(); // Hapus data

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
