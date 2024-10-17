<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller

{

    // public function __construct()
    // {
    //     $this->middleware(['permission:Laporan index,admin'])->only( ['index']);
    //     $this->middleware(['permission:Laporan create,admin'])->only(['store']);
    //     $this->middleware(['permission:Laporan update,admin'])->only(['update']);
    //     $this->middleware(['permission:Laporan delete,admin'])->only('destroy');
    // }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $sentReports = $admin->reports()->with('assignee')->get();
        $receivedReports = $admin->assignedReports()->with('creator')->get();

        return view('admin.reports.index', compact('sentReports', 'receivedReports'));
    }

    public function create()
    {
        $admin = Auth::guard('admin')->user();
        // Ambil hanya admin atasan yang valid
        $assignees = Admin::where('id', $admin->atasan_id)->get();

        return view('admin.reports.create', compact('assignees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'assigned_to' => 'required|exists:admins,id',
            'period' => 'required|string|max:255',
            'report_content' => 'required|string',
        ]);

        $admin = Auth::guard('admin')->user();

        // Pastikan hanya bisa mengirim laporan ke atasan yang benar
        if ($admin->atasan_id !== (int)$request->assigned_to) {
            return redirect()->back()->withErrors(['assigned_to' => 'You can only send reports to your superior.']);
        }

        Report::create([
            'created_by' => $admin->id,
            'assigned_to' => $request->assigned_to,
            'period' => $request->period,
            'report_content' => $request->report_content,
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil dikirim.');
    }

    public function show($id)
    {
        // Pastikan report yang ditemukan atau gagal
        $report = Report::with(['creator', 'assignee'])->findOrFail($id);

        return view('admin.reports.show', compact('report'));
    }
}
