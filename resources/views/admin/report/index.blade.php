@extends('admin.layouts.master')

@section('content')
    <h1>Dashboard Laporan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Pengirim</th>
                <th>Isi Laporan</th>
                <th>Periode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->creator->name }}</td>
                    <td>{{ $report->report_content }}</td>
                    <td>{{ $report->period }}</td>
                    <td><a href="#">Lihat Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
