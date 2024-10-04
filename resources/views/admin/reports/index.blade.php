@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Laporan Tim</h1>

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
                </tr>
            </thead>
            <tbody>
                @foreach ($sentReports as $report)
                    <tr>
                        <td>{{ $report->period }}</td>
                        <td>{{ $report->report_content }}</td>
                        <td>{{ $report->assignee->name }}</td>
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
                </tr>
            </thead>
            <tbody>
                @foreach ($receivedReports as $report)
                    <tr>
                        <td>{{ $report->period }}</td>
                        <td>{{ $report->report_content }}</td>
                        <td>{{ $report->creator->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
