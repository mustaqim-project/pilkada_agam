@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Daftar Penggunaan Anggaran</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.keuangan.penggunaan_anggaran.create') }}" class="btn btn-primary mb-3">Tambah Penggunaan Anggaran</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Periode ID</th>
                <th>Detail Pembiayaan ID</th>
                <th>Jumlah Digunakan</th>
                <th>Status Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penggunaanAnggaran as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->periode_id }}</td>
                <td>{{ $item->detail_pembiayaan_id }}</td>
                <td>{{ $item->jumlah_digunakan }}</td>
                <td>{{ $item->status_pembayaran }}</td>
                <td><img src="{{ $item->bukti_pembayaran }}" alt="Bukti" width="100"></td>
                <td>{{ $item->keterangan }}</td>
                <td>
                    <a href="{{ route('admin.keuangan.penggunaan_anggaran.show', $item->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('admin.keuangan.penggunaan_anggaran.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.keuangan.penggunaan_anggaran.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
