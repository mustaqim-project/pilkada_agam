@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Detail Penggunaan Anggaran</h1>

    <div class="form-group">
        <label>Periode ID:</label>
        <p>{{ $penggunaanAnggaran->periode_id }}</p>
    </div>

    <div class="form-group">
        <label>Detail Pembiayaan ID:</label>
        <p>{{ $penggunaanAnggaran->detail_pembiayaan_id }}</p>
    </div>

    <div class="form-group">
        <label>Jumlah Digunakan:</label>
        <p>{{ $penggunaanAnggaran->jumlah_digunakan }}</p>
    </div>

    <div class="form-group">
        <label>Status Pembayaran:</label>
        <p>{{ $penggunaanAnggaran->status_pembayaran }}</p>
    </div>

    <div class="form-group">
        <label>Bukti Pembayaran:</label>
        <img src="{{ $penggunaanAnggaran->bukti_pembayaran }}" alt="Bukti" width="100">
    </div>

    <div class="form-group">
        <label>Keterangan:</label>
        <p>{{ $penggunaanAnggaran->keterangan }}</p>
    </div>

    <a href="{{ route('admin.keuangan.penggunaan_anggaran.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
