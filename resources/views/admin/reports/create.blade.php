@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Tambah Laporan') }}</h1>
        </div>

        <div class="card card-primary">
            <form action="{{ route('admin.reports.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="atasan_id">Dikirim ke Atasan</label>
                    <select name="atasan_id" id="atasan_id" class="form-control" required>
                        @foreach ($atasans as $atasan)
                            <option value="{{ $atasan->id }}">{{ $atasan->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="period">Periode</label>
                    <input type="text" name="period" id="period" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="report_content">Isi Laporan</label>
                    <textarea name="report_content" id="report_content" class="form-control summernote" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Laporan</button>
            </form>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
            });
        });
    </script>
@endsection
