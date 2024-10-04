@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Laporan Tim</h1>

    <!-- Tombol Tambah Laporan -->
    <div class="mb-3">
        <a href="{{ route('admin.reports.create') }}" class="btn btn-success">Tambah Laporan</a>
    </div>

    <h2>Laporan yang Dikirim</h2>
    @if ($sentReports->isEmpty())
        <p>Tidak ada laporan yang dikirim.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Isi Laporan</th>
                    <th>Dikirim ke</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sentReports as $report)
                    <tr>
                        <td>{{ $report->period }}</td>
                        <td>{{ $report->report_content }}</td>
                        <td>{{ $report->assignee->name }}</td>
                        <td>
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-info">Lihat Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Laporan yang Diterima</h2>
    @if ($receivedReports->isEmpty())
        <p>Tidak ada laporan yang diterima.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Isi Laporan</th>
                    <th>Dari</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receivedReports as $report)
                <tr>
                    <td>{{ $report->period }}</td>
                    <td>{{ $report->report_content }}</td>
                    <td>{{ $report->creator->name }}</td>
                    <td>
                        <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-info">Lihat Detail</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
