<?php

namespace App\Http\Controllers\Admin\Keuangan;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penggajian;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

use App\Models\tim;
use App\Models\jabatan;
use App\Models\Bank;
use App\Traits\FileUploadTrait;



class PenggajianController extends Controller
{
    public function index()
    {

        // Fetch data from models
        $employee = Employee::all();
        $timList = tim::all();
        $jabatanList = jabatan::all();
        $bankList = Bank::all();


        $penggajians = DB::table('penggajians as pg')
            ->join('employees as e', 'pg.employee_id', '=', 'e.id')
            ->join('tims as t', 'e.tim_id', '=', 't.id')
            ->join('jabatans as j', 'e.jabatan_id', '=', 'j.id')
            ->join('bank as b', 'e.bank_id', '=', 'b.id')
            ->select(
                'pg.id AS id_penggajian',
                'pg.employee_id AS id_employee',
                'pg.tanggal_penggajian',
                'pg.jumlah AS nominal',
                'pg.bukti_pembayaran',
                't.name AS nama_tim',
                'j.name AS nama_jabatan',
                'e.nama AS nama_employee',
                'b.nama_bank AS nama_bank',
                'e.gaji AS gaji',
                'e.no_rekening AS no_rekening',
                'e.tanggal_masuk AS tanggal_masuk',
                'e.tim_id AS tim_id',
                'e.jabatan_id AS jabatan_id',
                'e.bank_id AS bank_id'
            )
            ->get();

        return view('admin.keuangan.penggajian.index', compact('penggajians', 'employee', 'timList', 'jabatanList', 'bankList'));
    }

    use FileUploadTrait;

    // Menyimpan penggajian baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal_penggajian' => 'required|date',
            'jumlah' => 'required|string|max:255',
            'bukti_pembayaran' => 'nullable|mimes:jpg,png,jpeg|max:5012', // Memastikan format dan ukuran file
        ]);

        // Menghandle pengunggahan file dan mendapatkan jalur file
        $imagePath = $this->handleFileUpload($request, 'bukti_pembayaran');

        // Membuat entri penggajian baru dengan data yang relevan
        Penggajian::create(array_merge($request->all(), ['bukti_pembayaran' => $imagePath]));

        return redirect()->route('admin.keuangan.gaji.index')->with('toast_success', 'Penggajian berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal_penggajian' => 'required|date',
            'jumlah' => 'required|string|max:255',
            'bukti_pembayaran' => 'nullable|mimes:jpg,png,jpeg|max:5012', // Memastikan format dan ukuran file
        ]);

        $penggajian = Penggajian::findOrFail($id);

        // Menangani pengunggahan file jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $imagePath = $this->handleFileUpload($request, 'bukti_pembayaran');
            // Mengupdate hanya jika file baru diunggah
            $penggajian->bukti_pembayaran = $imagePath;
        }

        // Mengupdate data penggajian dengan data yang relevan
        $penggajian->update($request->except('bukti_pembayaran')); // Menghindari duplikasi
        $penggajian->save(); // Menyimpan perubahan

        return redirect()->route('admin.keuangan.gaji.index')->with('toast_success', 'Penggajian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $penggajian->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
