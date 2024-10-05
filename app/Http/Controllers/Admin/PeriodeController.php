<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\periode;
use App\Models\anggaran;

class PeriodeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Periode index,admin'])->only(['index']);
        $this->middleware(['permission:Periode create,admin'])->only(['store']);
        $this->middleware(['permission:Periode update,admin'])->only(['update']);
        $this->middleware(['permission:Periode delete,admin'])->only('destroy');
    }

    public function index()
    {
        $periodes = Periode::with('anggaran.tim')->get(); // Eager load 'anggaran' dan 'tim'
        $anggarans = Anggaran::with('tim')->get(); // Eager load 'tim' pada anggaran

        dd($periodes,$anggaran);
        return view('admin.periode.index', compact('periodes', 'anggarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggaran_id' => 'required|exists:anggaran,id',
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'anggaran_periode' => 'required|numeric',
        ]);

        periode::create($request->all());
        return redirect()->back()->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $periode = periode::findOrFail($id);
        return response()->json($periode);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'anggaran_id' => 'required|exists:anggaran,id',
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'anggaran_periode' => 'required|numeric',
        ]);

        $periode = periode::findOrFail($id);
        $periode->update($request->all());
        return redirect()->back()->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periode = periode::findOrFail($id);
        $periode->delete();
        return redirect()->back()->with('success', 'Periode berhasil dihapus.');
    }
}
