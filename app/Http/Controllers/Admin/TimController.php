<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\tim;
use Illuminate\Http\Request;

class TimController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tim index,admin'])->only('index');
        $this->middleware(['permission:tim create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:tim update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:tim delete,admin'])->only('destroy');
    }

    public function index()
    {
        $tims = tim::all();
        return view('admin.tims.index', compact('tims'));
    }

    public function create()
    {
        return response()->json(['success' => true, 'data' => view('admin.tims.form', ['tim' => new tim()])->render()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        tim::create($request->all());
        return redirect()->route('admin.tims.index')->with('success', 'tim created successfully.');
    }

    public function edit(tim $tim)
    {
        return response()->json(['success' => true, 'data' => view('admin.tims.form', compact('tim'))->render()]);
    }

    public function update(Request $request, tim $tim)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tim->update($request->all());
        return redirect()->route('admin.tims.index')->with('success', 'tim updated successfully.');
    }

    public function destroy(tim $tim)
    {
        $tim->delete();
        return redirect()->route('admin.tims.index')->with('success', 'tim deleted successfully.');
    }
}
