<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Employee;
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

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }


    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nama' => 'required',
            'gaji' => 'required',
            'no_rekening' => 'required',
            'tanggal_masuk' => 'required|date',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
