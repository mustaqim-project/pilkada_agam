@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Tambah Detail Pembiayaan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.keuangan.detail_pembiayaan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="jenis_pembiayaan_id">Jenis Pembiayaan ID</label>
            <input type="number" name="jenis_pembiayaan_id" class="form-control" value="{{ old('jenis_pembiayaan_id') }}" required>
        </div>
        <div class="form-group">
            <label for="nama_rincian">Nama Rincian</label>
            <input type="text" name="nama_rincian" class="form-control" value="{{ old('nama_rincian') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
