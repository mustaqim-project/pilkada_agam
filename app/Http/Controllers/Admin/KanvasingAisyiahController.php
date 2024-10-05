<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kanvasing_aisyiah;
use App\Models\agamas;
use App\Models\pekerjaan;

class KanvasingAisyiahController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:KanvasingAisyiah index,admin'])->only(['indexAdmin']);
        $this->middleware(['permission:KanvasingAisyiah create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:KanvasingAisyiah update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:KanvasingAisyiah delete,admin'])->only('destroy');
    }

    // Menampilkan halaman index untuk user (mobile)
    public function index()
    {
        $userId = auth()->id(); // Mengambil ID user yang sedang login
        $kanvasing = kanvasing_aisyiah::with('agama', 'pekerjaan')
                        ->where('user_id', $userId)
                        ->get();

        $agamas = agamas::all();
        $pekerjaans = pekerjaan::all();

        return view('mobile.kanvasing_aisyiah.index', compact('kanvasing', 'agamas', 'pekerjaans'));
    }

    // Menampilkan halaman index untuk admin
    public function indexAdmin()
    {
        $kanvasing = kanvasing_aisyiah::with('agama', 'pekerjaan')->get();
        $agamas = agamas::all();
        $pekerjaans = pekerjaan::all();

        return view('admin.kanvasing_aisyiah.index', compact('kanvasing', 'agamas', 'pekerjaans'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_responden' => 'required|string|max:255',
            'no_kk' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        kanvasing_aisyiah::create($request->all());

        return redirect()->route('kanvasing-aisyiah.indexAdmin')->with('success', 'Data berhasil ditambahkan.');
    }

    // Mengupdate data yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_responden' => 'required|string|max:255',
            'no_kk' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        $kanvasing = kanvasing_aisyiah::findOrFail($id);
        $kanvasing->update($request->all());

        return redirect()->route('kanvasing-aisyiah.indexAdmin')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus data
    public function destroy($id)
    {
        $kanvasing = kanvasing_aisyiah::findOrFail($id);
        $kanvasing->delete();

        return redirect()->route('kanvasing-aisyiah.indexAdmin')->with('success', 'Data berhasil dihapus.');
    }
}
