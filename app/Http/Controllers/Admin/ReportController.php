<?php

namespace App\Http\Controllers\admin;

use App\Models\Report;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        // Mendapatkan semua laporan yang ditugaskan kepada admin ini
        $reports = $admin->assignedReports()->with('creator')->get();

        return view('admin.reports.index', compact('reports'));
    }

    public function create()
    {
        // Ambil admin yang menjadi atasan
        $assignees = Admin::where('id', '<>', Auth::id())->get();

        return view('admin.reports.create', compact('assignees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'assigned_to' => 'required|exists:admins,id',
            'report_content' => 'required|string',
            'period' => 'required|string'
        ]);

        Report::create([
            'created_by' => Auth::id(),
            'assigned_to' => $request->input('assigned_to'),
            'report_content' => $request->input('report_content'),
            'period' => $request->input('period')
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil dikirim.');
    }
}
