<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\anggaran;
use App\Models\tim;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Anggaran index,admin'])->only(['index']);
        $this->middleware(['permission:Anggaran create,admin'])->only(['store']);
        $this->middleware(['permission:Anggaran update,admin'])->only(['update']);
        $this->middleware(['permission:Anggaran delete,admin'])->only('destroy');
    }

    public function index()
    {
        $anggarans = anggaran::with('tim')->get();
        $tims = tim::all(); // Ambil semua data tim
        return view('admin.anggaran.index', compact('anggarans', 'tims'));
    }

    public function create()
    {
        return response()->json(['status' => 'success']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tim_id' => 'required|exists:tims,id',
            'total_anggaran' => 'required|numeric',
        ]);

        anggaran::create($request->all());
        return redirect()->route('admin.anggaran.index')->with('success', 'Anggaran berhasil dibuat.');
    }

    public function edit($id)
    {
        $anggaran = anggaran::findOrFail($id);
        return response()->json($anggaran);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tim_id' => 'required|exists:tims,id',
            'total_anggaran' => 'required|numeric',
        ]);

        $anggaran = anggaran::findOrFail($id);
        $anggaran->update($request->all());
        return redirect()->route('admin.anggaran.index')->with('success', 'Anggaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggaran = anggaran::findOrFail($id);
        $anggaran->delete();
        return redirect()->route('admin.anggaran.index')->with('success', 'Anggaran berhasil dihapus.');
    }
}
