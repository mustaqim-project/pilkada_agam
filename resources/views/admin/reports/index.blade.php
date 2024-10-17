@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Laporan yang Dikirim') }}</h1>
        </div>
@php
    use Illuminate\Support\Str;

@endphp
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <a href="{{ route('admin.reports.create') }}" class="btn btn-primary">+ Tambah Laporan</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($sentReports->isEmpty())
                        <p>Tidak ada laporan yang dikirim.</p>
                    @else
                        <table class="table table-striped" id="tableSentReports">
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
                                        <td>{!! Str::limit(strip_tags($report->report_content), 50) !!}</td>
                                        <td>{{ $report->assignee->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-info">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="section-header">
            <h1>{{ __('admin.Laporan yang Diterima') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                {{-- <div class="card-header-actions">
                    <a href="{{ route('admin.reports.create') }}" class="btn btn-primary">+ Tambah Laporan</a>
                </div> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($receivedReports->isEmpty())
                        <p>Tidak ada laporan yang diterima.</p>
                    @else
                        <table class="table table-striped" id="tableReceivedReports">
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
                                        <td>{!! Str::limit(strip_tags($report->report_content), 50) !!}</td>
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
            </div>
        </div>
    </section>
@endsection
