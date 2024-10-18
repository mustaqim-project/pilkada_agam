@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">Kembali</a>
        </div>

        <div class="card card-primary">
            <div class="section-header">
                <h1>{{ __('admin.Detail Laporan') }}</h1>
            </div>

            <table class="table">
                <tr>
                    <th>{{ __('admin.Periode') }}</th>
                    <td>{{ $report->period }}</td>
                </tr>
                <tr>
                    <th>{{ __('admin.Dari') }}</th>
                    <td>{{ $report->creator->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('admin.Dikirim ke') }}</th>
                    <td>{{ $report->assignee->name }}</td>
                </tr>

                @if ($report->attachment)
                    <tr>
                        <th>{{ __('admin.Lampiran') }}</th>
                        <td>{!! $report->attachment !!}</td>
                    </tr>
                @endif
            </table>

            <div class="card mt-4">
                <div class="card-header">
                    <h3>{{ __('admin.Isi Laporan') }}</h3>
                </div>
                <div class="card-body">
                    {!! $report->report_content !!}
                </div>
            </div>
        </div>
    </section>
@endsection
