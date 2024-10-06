@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Tambah Laporan</h1>
    <form action="{{ route('admin.reports.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="assigned_to">Dikirim ke</label>
            <select name="assigned_to" id="assigned_to" class="form-control" required>
                @foreach($assignees as $assignee)
                    <option value="{{ $assignee->id }}">{{ $assignee->name }}</option>
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

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300, // set editor height
        });
    });
</script>
@endsection
