<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:jabatan index,admin'])->only('index');
        $this->middleware(['permission:jabatan create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:jabatan update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:jabatan delete,admin'])->only('destroy');
    }

    public function index()
    {
        $jabatans = jabatan::all();
        return view('admin.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return response()->json(['success' => true, 'data' => view('admin.jabatan.form', ['jabatan' => new Jabatan()])->render()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        jabatan::create($request->all());

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan created successfully.');
    }

    public function edit(jabatan $jabatan)
    {
        return response()->json(['success' => true, 'data' => view('admin.jabatan.form', compact('jabatan'))->render()]);
    }

    public function update(Request $request, jabatan $jabatan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jabatan->update($request->all());

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan updated successfully.');
    }

    public function destroy(jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan deleted successfully.');
    }
}
