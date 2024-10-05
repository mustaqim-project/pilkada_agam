<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\agamas;

class AgamaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:agama index,admin'])->only('index');
        $this->middleware(['permission:agama create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:agama update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:agama delete,admin'])->only('destroy');
    }

    public function index()
    {
        $agamas = agamas::all();
        return view('admin.agamas.index', compact('agamas'));
    }

    public function create()
    {
        return response()->json(['success' => true, 'data' => view('admin.agamas.form', ['agama' => new agamas()])->render()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        agamas::create($request->all());
        return redirect()->route('admin.agamas.index')->with('success', 'Agama created successfully.');
    }

    public function edit(agamas $agama)
    {
        return response()->json(['success' => true, 'data' => view('admin.agamas.form', compact('agama'))->render()]);
    }

    public function update(Request $request, agamas $agama)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $agama->update($request->all());
        return redirect()->route('admin.agamas.index')->with('success', 'Agama updated successfully.');
    }

    public function destroy(agamas $agama)
    {
        $agama->delete();
        return redirect()->route('admin.agamas.index')->with('success', 'Agama deleted successfully.');
    }
}
