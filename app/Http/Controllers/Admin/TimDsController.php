<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Admin;

class TimDsController extends Controller
{

    public function __construct()
    {
        // Middleware untuk Ketua
        $this->middleware(['permission:view ketua dashboard,admin'])->only('ketuaDashboard');
        $this->middleware(['permission:view ketua laporan,admin'])->only('ketuaLaporan');

        // Middleware untuk Koordinator Wilayah
        $this->middleware(['permission:view koordinator wilayah dashboard,admin'])->only('koordinatorWilayahDashboard');
        $this->middleware(['permission:view koordinator wilayah laporan,admin'])->only('koordinatorWilayahLaporan');

        // Middleware untuk Koordinator Kecamatan
        $this->middleware(['permission:view koordinator kecamatan dashboard,admin'])->only('koordinatorKecamatanDashboard');
        $this->middleware(['permission:view koordinator kecamatan laporan,admin'])->only('koordinatorKecamatanLaporan');

        // Middleware untuk Koordinator Nagari
        $this->middleware(['permission:view koordinator nagari dashboard,admin'])->only('koordinatorNagariDashboard');
        $this->middleware(['permission:view koordinator nagari laporan,admin'])->only('koordinatorNagariLaporan');
    }
    public function ketuaDashboard()
    {

        return view('admin.timds.ketua.dashboard');
    }

    public function ketuaLaporan()
    {

        $admin = Auth::guard('admin')->user();
        $sentReports = $admin->reports()->with('assignee')->get();
        $receivedReports = $admin->assignedReports()->with('creator')->get();

        return view('admin.reports.index', compact('sentReports', 'receivedReports'));
    }

    // Koordinator Wilayah
    public function koordinatorWilayahDashboard()
    {
        return view('admin.timds.koordinator_wilayah.dashboard');
    }

    public function koordinatorWilayahLaporan()
    {
        $admin = Auth::guard('admin')->user();
        $sentReports = $admin->reports()->with('assignee')->get();
        $receivedReports = $admin->assignedReports()->with('creator')->get();

        return view('admin.reports.index', compact('sentReports', 'receivedReports'));
    }

    // Koordinator Kecamatan
    public function koordinatorKecamatanDashboard()
    {
        return view('admin.timds.koordinator_kecamatan.dashboard');
    }

    public function koordinatorKecamatanLaporan()
    {
        $admin = Auth::guard('admin')->user();
        $sentReports = $admin->reports()->with('assignee')->get();
        $receivedReports = $admin->assignedReports()->with('creator')->get();

        return view('admin.reports.index', compact('sentReports', 'receivedReports'));
    }

    // Koordinator Nagari
    public function koordinatorNagariDashboard()
    {
        return view('admin.timds.koordinator_nagari.dashboard');
    }

    public function koordinatorNagariLaporan()
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


