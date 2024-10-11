<?php

namespace App\Http\Admin\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::all();
        return view('bank.index', compact('banks'));
    }

    public function create()
    {
        return view('bank.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:255',
            'kode_bank' => 'required|string|max:10',
        ]);

        Bank::create($validated);

        return redirect()->route('bank.index')->with('success', 'Data Bank berhasil ditambahkan.');
    }

    public function show(Bank $bank)
    {
        return view('bank.show', compact('bank'));
    }

    public function edit(Bank $bank)
    {
        return view('bank.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:255',
            'kode_bank' => 'required|string|max:10',
        ]);

        $bank->update($validated);

        return redirect()->route('bank.index')->with('success', 'Data Bank berhasil diperbarui.');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('bank.index')->with('success', 'Data Bank berhasil dihapus.');
    }
}
