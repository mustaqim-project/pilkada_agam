<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index()
    {
        $gajis = Gaji::all();
        return view('gaji.index', compact('gajis'));
    }

    public function create()
    {
        return view('gaji.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'gaji' => 'required|string',
            'periode' => 'required|date',
            'bukti_pembayaran' => 'nullable|string',
        ]);

        Gaji::create($validated);

        return redirect()->route('gaji.index')->with('success', 'Data Gaji berhasil ditambahkan.');
    }

    public function show(Gaji $gaji)
    {
        return view('gaji.show', compact('gaji'));
    }

    public function edit(Gaji $gaji)
    {
        return view('gaji.edit', compact('gaji'));
    }

    public function update(Request $request, Gaji $gaji)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'gaji' => 'required|string',
            'periode' => 'required|date',
            'bukti_pembayaran' => 'nullable|string',
        ]);

        $gaji->update($validated);

        return redirect()->route('gaji.index')->with('success', 'Data Gaji berhasil diperbarui.');
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();
        return redirect()->route('gaji.index')->with('success', 'Data Gaji berhasil dihapus.');
    }
}
