<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller

{

    public function __construct()
    {
        $this->middleware(['permission:Laporan index,admin'])->only(['index']);
        $this->middleware(['permission:Laporan create,admin'])->only(['store']);
        $this->middleware(['permission:Laporan update,admin'])->only(['update']);
        $this->middleware(['permission:Laporan delete,admin'])->only('destroy');
    }

        public function index()
        {
            $admin = Auth::guard('admin')->user();
            $sentReports = $admin->reports()->with('assignee')->get();
            $receivedReports = $admin->assignedReports()->with('creator')->get();

            return view('admin.reports.index', compact('sentReports', 'receivedReports'));
        }

        public function create()
        {
            $assignees = Admin::where('id', '<>', Auth::id())->get();

            return view('admin.reports.create', compact('assignees'));
        }

        public function store(Request $request)
        {
            $request->validate([
                'assigned_to' => 'required|exists:admins,id',
                'report_content' => 'required|string',
                'period' => 'required|string',
                'attachment' => 'nullable|string', // Validasi untuk lampiran
            ]);

            Report::create([
                'created_by' => Auth::id(),
                'assigned_to' => $request->input('assigned_to'),
                'report_content' => $request->input('report_content'),
                'period' => $request->input('period'),
                'attachment' => $request->input('attachment'), // Menyimpan lampiran
            ]);

            return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil dikirim.');
        }

        public function show($id)
        {
            $report = Report::with(['creator', 'assignee'])->findOrFail($id);
            return view('admin.reports.show', compact('report'));
        }
}

