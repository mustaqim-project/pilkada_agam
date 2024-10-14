@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Edit Penggunaan Anggaran</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.keuangan.penggunaan_anggaran.update', $penggunaanAnggaran->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="periode_id">Periode ID</label>
            <input type="number" name="periode_id" class="form-control" value="{{ $penggunaanAnggaran->periode_id }}" required>
        </div>
        <div class="form-group">
            <label for="detail_pembiayaan_id">Detail Pembiayaan ID</label>
            <input type="number" name="detail_pembiayaan_id" class="form-control" value="{{ $penggunaanAnggaran->detail_pembiayaan_id }}" required>
        </div>
        <div class="form-group">
            <label for="jumlah_digunakan">Jumlah Digunakan</label>
            <input type="text" name="jumlah_digunakan" class="form-control" value="{{ $penggunaanAnggaran->jumlah_digunakan }}" required>
        </div>
        <div class="form-group">
            <label for="status_pembayaran">Status Pembayaran</label>
            <input type="text" name="status_pembayaran" class="form-control" value="{{ $penggunaanAnggaran->status_pembayaran }}">
        </div>
        <div class="form-group">
            <label for="bukti_pembayaran">Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" class="form-control-file">
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ $penggunaanAnggaran->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
