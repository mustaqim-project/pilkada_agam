<?php

namespace App\Http\Controllers\Admin\Keuangan;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penggajian;
use App\Models\Employee;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajians = Penggajian::with(['employee.tim', 'employee.jabatan', 'employee.bank'])->get();
        return view('admin.keuangan.penggajian.index', compact('penggajians'));
    }



    // Menyimpan penggajian baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal_penggajian' => 'required|date',
            'jumlah' => 'required|string|max:255',
            'bukti_pembayaran' => 'nullable|string|max:255',
        ]);

        Penggajian::create($request->all());

        return redirect()->route('penggajians.index')->with('success', 'Penggajian berhasil dibuat.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal_penggajian' => 'required|date',
            'jumlah' => 'required|string|max:255',
            'bukti_pembayaran' => 'nullable|string|max:255',
        ]);

        $penggajian = Penggajian::findOrFail($id);
        $penggajian->update($request->all());

        return redirect()->route('penggajians.index')->with('success', 'Penggajian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $penggajian->delete();

        return redirect()->route('penggajians.index')->with('success', 'Penggajian berhasil dihapus.');
    }
}
