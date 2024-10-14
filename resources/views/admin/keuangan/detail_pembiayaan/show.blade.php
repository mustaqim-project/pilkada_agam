@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Detail Pembiayaan</h1>

    <div class="form-group">
        <label>ID:</label>
        <p>{{ $detailPembiayaan->id }}</p>
    </div>

    <div class="form-group">
        <label>Jenis Pembiayaan ID:</label>
        <p>{{ $detailPembiayaan->jenis_pembiayaan_id }}</p>
    </div>

    <div class="form-group">
        <label>Nama Rincian:</label>
        <p>{{ $detailPembiayaan->nama_rincian }}</p>
    </div>

    <a href="{{ route('admin.keuangan.detail_pembiayaan.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
