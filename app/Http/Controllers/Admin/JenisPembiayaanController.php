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

    public function index()
    {
        $jenisPembiayaan = jenis_pembiayaan::all();
        return view('admin.jenis_pembiayaan.index', compact('jenisPembiayaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembiayaan' => 'required|string|max:255',
        ]);

        jenis_pembiayaan::create($request->all());

        return redirect()->route('admin.jenis-pembiayaan.index')->with('success', 'Jenis Pembiayaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenisPembiayaan = jenis_pembiayaan::findOrFail($id);
        return response()->json($jenisPembiayaan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembiayaan' => 'required|string|max:255',
        ]);

        $jenisPembiayaan = jenis_pembiayaan::findOrFail($id);
        $jenisPembiayaan->update($request->all());

        return redirect()->route('admin.jenis-pembiayaan.index')->with('success', 'Jenis Pembiayaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisPembiayaan = jenis_pembiayaan::findOrFail($id);
        $jenisPembiayaan->delete();

        return redirect()->route('admin.jenis-pembiayaan.index')->with('success', 'Jenis Pembiayaan berhasil dihapus.');
    }
}
