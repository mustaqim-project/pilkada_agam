<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Penggajian;

use App\Models\tim;
use App\Models\jabatan;
use App\Models\Bank;




class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gaji' => 'required',
            'no_rekening' => 'required',
            'tanggal_masuk' => 'required|date',
        ]);

        $data = $request->all();
        $data['tim_id'] = $data['tim_id'] ?? 0;
        $data['jabatan_id'] = $data['jabatan_id'] ?? 0;

        Employee::create($data);
        return redirect()->route('admin.keuangan.gaji.index')->with('toast_success', 'Employee created successfully.');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nama' => 'required',
            'gaji' => 'required',
            'no_rekening' => 'required',
            'tanggal_masuk' => 'required|date',
        ]);

        $data = $request->all();
        $data['tim_id'] = $data['tim_id'] ?? 0;
        $data['jabatan_id'] = $data['jabatan_id'] ?? 0;

        $employee->update($data);
        return redirect()->route('admin.keuangan.gaji.index')->with('toast_success', 'Employee updated successfully.');
    }


    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus!'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Cek jika error disebabkan oleh foreign key constraint violation
            if ($e->getCode() == 23000) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak dapat dihapus karena sudah digunakan dalam penggajian!'
                ]);
            }

            // Jika error lain, lempar error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data.'
            ]);
        }
    }


    public function getEmployeeDetails(Request $request)
    {
        $employee = Employee::findOrFail($request->employee_id);
        $histori_penggajian = Penggajian::where('employee_id', $request->employee_id)->get();
        $bank = Bank::find($employee->bank_id);

        return response()->json([
            'tanggal_masuk' => $employee->tanggal_masuk,
            'no_rekening' => $employee->no_rekening,
            'nama_bank' => $bank ? $bank->nama : 'Tidak ada bank terdaftar',
            'histori_penggajian' => $histori_penggajian
        ]);
    }



    public function getEmployeesByTimAndJabatan(Request $request)
    {
        $employees = Employee::where('tim_id', $request->tim_id)
            ->where('jabatan_id', $request->jabatan_id)
            ->get();

        return response()->json($employees);
    }
}
