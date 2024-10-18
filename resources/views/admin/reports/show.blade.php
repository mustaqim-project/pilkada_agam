@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card card-primary">

            <div class="section-header">
                <h1>{{ __('admin.Detail Laporan') }}</h1>
            </div>

            <div class="section-header">
                <h1>{{ __('admin.Periode') }} : {{ $report->period }}</h1>
            </div>

            <div class="section-header">
                <h1>{{ __('admin.Dari: ') }} {{ $report->creator->name }}</h1>
            </div>

            <div class="section-header">
                <h1>{{ __('admin.Dikirim ke: ') }} {{ $report->assignee->name }}</h1>
            </div>

            @if ($report->attachment)
                <div class="section-header">
                    <h1>{{ __('admin.Lampiran') }} </h1>
                </div>
                <div>{!! $report->attachment !!}</div>
            @endif

            <div class="section-header">
                <h1>{{ __('admin.Isi Laporan') }}</h1>
            </div>
            <div>{!! $report->report_content !!}</div>

        </div>
    </section>
@endsection
