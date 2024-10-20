@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Tambah Penggunaan Anggaran</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.keuangan.penggunaan_anggaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Penggunaan Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="periode_id">Nama Periode</label>
                    <select class="form-control" name="periode_id" required>
                        @foreach ($periodes as $periode)
                            <option value="{{ $periode->id }}">
                                {{ $periode->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="detail_pembiayaan_id">Nama Rincian Pembiayaan</label>
                    <select class="form-control" name="detail_pembiayaan_id" required>
                        @foreach ($detailPembiayaans as $detail)
                            <option value="{{ $detail->id }}">{{ $detail->nama_rincian }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah_digunakan">Jumlah Anggaran</label>
                    <input type="number" class="form-control" name="jumlah_digunakan" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" name="keterangan"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
@endsection
