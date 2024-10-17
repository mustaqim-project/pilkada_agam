@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Detail Laporan</h1>

    <h2>Isi Laporan</h2>
    <div>{!! $report->report_content !!}</div>

    <h3>Periode: {{ $report->period }}</h3>
    <h4>Dari: {{ $report->creator->name }}</h4>
    <h4>Dikirim ke: {{ $report->assignee->name }}</h4>

    @if ($report->attachment)
        <h4>Lampiran:</h4>
        <div>{!! $report->attachment !!}</div>

    @endif

    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
