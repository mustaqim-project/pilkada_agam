@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Daftar Detail Pembiayaan</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.keuangan.detail_pembiayaan.create') }}" class="btn btn-primary mb-3">Tambah Detail Pembiayaan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jenis Pembiayaan ID</th>
                <th>Nama Rincian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detailPembiayaan as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->jenis_pembiayaan_id }}</td>
                <td>{{ $item->nama_rincian }}</td>
                <td>
                    <a href="{{ route('admin.keuangan.detail_pembiayaan.show', $item->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('admin.keuangan.detail_pembiayaan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.keuangan.detail_pembiayaan.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
