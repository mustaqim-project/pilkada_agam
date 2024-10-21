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

                                </tr>

                                <tr id="collapseTim{{ $loop->iteration }}" class="collapse">
                                    <td colspan="3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Jabatan</th>
                                                    <th>Nama Jabatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($penggajianGroup->groupBy('nama_jabatan') as $jabatan => $jabatanGroup)
                                                    <tr>
                                                        <td>
                                                            <button class="btn btn-link" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#collapseJabatan{{ $loop->parent->iteration }}{{ $loop->iteration }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapseJabatan{{ $loop->parent->iteration }}{{ $loop->iteration }}">
                                                                <i class="fas fa-chevron-down"></i>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {{ $jabatan }}
                                                        </td>
                                                    </tr>

                                                    <tr id="collapseJabatan{{ $loop->parent->iteration }}{{ $loop->iteration }}"
                                                        class="collapse">
                                                        <td colspan="2">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Detail Gaji</th>
                                                                        <th>Nama Karyawan</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($jabatanGroup->groupBy('id_employee') as $id_employee => $employeeGroup)
                                                                        @foreach ($employeeGroup as $penggajian)
                                                                            <tr>

                                                                                <td>
                                                                                    <button class="btn btn-link"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseGaji{{ $penggajian->id_employee }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapseGaji{{ $penggajian->id_employee }}">
                                                                                        Detail Gaji
                                                                                    </button>
                                                                                </td>
                                                                                <td>{{ $penggajian->nama_employee }}</td>

                                                                                <td>
                                                                                    <button
                                                                                        class="btn btn-warning">Edit</button>
                                                                                    <button
                                                                                        class="btn btn-danger delete-item">Delete</button>
                                                                                </td>


                                                                            </tr>

                                                                            <tr id="collapseGaji{{ $penggajian->id_employee }}"
                                                                                class="collapse">
                                                                                <td colspan="3">
                                                                                    <table class="table table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Tanggal Penggajian</th>
                                                                                                <th>Jumlah</th>
                                                                                                <th>Bukti Pembayaran</th>
                                                                                                <th>Aksi</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($employeeGroup as $detailPenggajian)
                                                                                                <tr>
                                                                                                    <td>{{ $detailPenggajian->tanggal_penggajian }}
                                                                                                    </td>
                                                                                                    <td>Rp
                                                                                                        {{ number_format($detailPenggajian->nominal, 0, ',', '.') }}
                                                                                                    </td>
                                                                                                    <td>{{ $detailPenggajian->bukti_pembayaran }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <a href="#"
                                                                                                            class="btn btn-warning"
                                                                                                            data-toggle="modal"
                                                                                                            data-target="#editModal{{ $detailPenggajian->id_penggajian }}">
                                                                                                            <i
                                                                                                                class="fas fa-edit"></i>
                                                                                                        </a>
                                                                                                        <a href="#"
                                                                                                            class="btn btn-danger delete-item"
                                                                                                            data-id="{{ $detailPenggajian->id_penggajian }}">
                                                                                                            <i
                                                                                                                class="fas fa-trash-alt"></i>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
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
