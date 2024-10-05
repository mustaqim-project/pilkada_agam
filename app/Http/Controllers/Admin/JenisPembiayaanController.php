<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\jenis_pembiayaan;

class JenisPembiayaanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:JenisPembiayaan index,admin'])->only('index');
        $this->middleware(['permission:JenisPembiayaan create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:JenisPembiayaan update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:JenisPembiayaan delete,admin'])->only('destroy');
    }

    // Menampilkan halaman index
    public function index()
    {
        $jenisPembiayaan = jenis_pembiayaan::all();
        return view('admin.jenis_pembiayaan.index', compact('jenisPembiayaan'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pembiayaan' => 'required|string|max:255',
        ]);

        jenis_pembiayaan::create($request->all());

        return redirect()->route('admin.jenis-pembiayaan.index')->with('success', 'Jenis Pembiayaan berhasil ditambahkan.');
    }

    // Mengupdate data yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembiayaan' => 'required|string|max:255',
        ]);

        $jenisPembiayaan = jenis_pembiayaan::findOrFail($id);
        $jenisPembiayaan->update($request->all());

        return redirect()->route('admin.jenis-pembiayaan.index')->with('success', 'Jenis Pembiayaan berhasil diperbarui.');
    }

    // Menghapus data
    public function destroy($id)
    {
        $jenisPembiayaan = jenis_pembiayaan::findOrFail($id);
        $jenisPembiayaan->delete();

        return redirect()->route('admin.jenis-pembiayaan.index')->with('success', 'Jenis Pembiayaan berhasil dihapus.');
    }
}
