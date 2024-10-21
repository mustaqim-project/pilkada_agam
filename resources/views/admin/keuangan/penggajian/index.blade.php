@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Daftar Penggajian') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                        + Tambah Penggajian
                    </button>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Tim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penggajians->groupBy('nama_tim') as $tim => $penggajianGroup)
                                <tr>
                                    <td>
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseTim{{ $loop->iteration }}" aria-expanded="false"
                                            aria-controls="collapseTim{{ $loop->iteration }}">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </td>
                                    <td>{{ $tim }}</td>
                                    <td>
                                        <button class="btn btn-info">Detail Jabatan</button>
                                    </td>
                                </tr>

                                <tr id="collapseTim{{ $loop->iteration }}" class="collapse">
                                    <td colspan="3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Jabatan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($penggajianGroup->groupBy('nama_jabatan') as $jabatan => $jabatanGroup)
                                                    <tr>
                                                        <td>
                                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                                data-target="#collapseJabatan{{ $loop->parent->iteration }}{{ $loop->iteration }}" aria-expanded="false"
                                                                aria-controls="collapseJabatan{{ $loop->parent->iteration }}{{ $loop->iteration }}">
                                                                <i class="fas fa-chevron-down"></i>
                                                            </button>
                                                            {{ $jabatan }}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info">Detail Karyawan</button>
                                                        </td>
                                                    </tr>

                                                    <tr id="collapseJabatan{{ $loop->parent->iteration }}{{ $loop->iteration }}" class="collapse">
                                                        <td colspan="2">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Karyawan</th>
                                                                        <th>Aksi</th>
                                                                        <th>Detail Gaji</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($jabatanGroup as $penggajian)
                                                                        <tr>
                                                                            <td>{{ $penggajian->nama_employee }}</td>
                                                                            <td>
                                                                                <a href="#" class="btn btn-warning">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </a>
                                                                                <a href="#" class="btn btn-danger delete-item">
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                                                    data-target="#collapseGaji{{ $penggajian->id_employee }}" aria-expanded="false"
                                                                                    aria-controls="collapseGaji{{ $penggajian->id_employee }}">
                                                                                    Detail Gaji
                                                                                </button>
                                                                            </td>
                                                                        </tr>

                                                                        <tr id="collapseGaji{{ $penggajian->id_employee }}" class="collapse">
                                                                            <td colspan="3">
                                                                                <strong>Tanggal Penggajian:</strong> {{ $penggajian->tanggal_penggajian }} <br>
                                                                                <strong>Jumlah:</strong> Rp {{ number_format($penggajian->nominal, 0, ',', '.') }} <br>
                                                                                <strong>Bukti Pembayaran:</strong> {{ $penggajian->bukti_pembayaran }} <br>
                                                                                <a href="#" class="btn btn-warning">Edit</a>
                                                                                <a href="#" class="btn btn-danger">Delete</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
