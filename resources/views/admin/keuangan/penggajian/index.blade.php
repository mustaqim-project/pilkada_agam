@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Daftar Penggajian') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">

                <div class="card-header-actions">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModalGaji">
                        + Bayar Gaji
                    </button>
                </div>



                <div class="card-header-actions" style="margin-left: 3rem">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModalKaryawan">
                        + Tambah Karyawan
                    </button>
                </div>


            </div>

            {{-- <div class="row mb-4">
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
                                                                        <th>id_employee</th>
                                                                        <th>Detail Gaji</th>
                                                                        <th>Nama Karyawan</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($jabatanGroup->unique('id_employee') as $penggajian)
                                                                        <tr>
                                                                            <td>{{ $penggajian->id_employee }}</td>
                                                                            <td>
                                                                                <button class="btn btn-link" type="button"
                                                                                    data-toggle="collapse"
                                                                                    data-target="#collapseGaji{{ $penggajian->id_employee }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseGaji{{ $penggajian->id_employee }}">
                                                                                    <i class="fas fa-chevron-down"></i>
                                                                                </button>
                                                                            </td>
                                                                            <td>{{ $penggajian->nama_employee }}</td>

                                                                            <td>
                                                                                <a href="#" data-toggle="modal"
                                                                                    data-target="#editModalEmployee{{ $penggajian->id_employee }}"
                                                                                    class="btn btn-warning">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </a>
                                                                                <a href="{{ route('admin.keuangan.employee.destroy', $penggajian->id_employee) }}"
                                                                                    class="btn btn-danger delete-item">
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>

                                                                        <tr id="collapseGaji{{ $penggajian->id_employee }}"
                                                                            class="collapse">
                                                                            <td colspan="3">
                                                                                <table class="table table-bordered">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>ID Penggajian</th>
                                                                                            <th>ID Employee</th>
                                                                                            <th>Tanggal Penggajian</th>
                                                                                            <th>Jumlah</th>
                                                                                            <th>Bukti Pembayaran</th>
                                                                                            <th>Aksi</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($jabatanGroup->unique('id_penggajian') as $detailPenggajian)
                                                                                            <tr>
                                                                                                <td>{{ $detailPenggajian->id_penggajian }}
                                                                                                <td>{{ $detailPenggajian->id_employee }}
                                                                                                <td>{{ $detailPenggajian->tanggal_penggajian }}
                                                                                                </td>
                                                                                                <td>Rp
                                                                                                    {{ number_format($detailPenggajian->nominal, 0, ',', '.') }}
                                                                                                </td>
                                                                                                <td>{{ $detailPenggajian->bukti_pembayaran }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    <a href="#"
                                                                                                        data-toggle="modal"
                                                                                                        data-target="#editModalGaji{{ $detailPenggajian->id_penggajian }}"
                                                                                                        class="btn btn-warning">
                                                                                                        <i
                                                                                                            class="fas fa-edit"></i>
                                                                                                    </a>
                                                                                                    <a href="{{ route('admin.keuangan.gaji.destroy', $detailPenggajian->id_penggajian) }}"
                                                                                                        class="btn btn-danger delete-item">
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
            </div> --}}
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
                                                        <td>{{ $jabatan }}</td>
                                                    </tr>

                                                    <tr id="collapseJabatan{{ $loop->parent->iteration }}{{ $loop->iteration }}" class="collapse">
                                                        <td colspan="2">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Karyawan</th>
                                                                        <th>Detail Gaji</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($jabatanGroup->groupBy('id_employee') as $employeeGroup)
                                                                        @php
                                                                            $employee = $employeeGroup->first();
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{ $employee->nama_employee }}</td>
                                                                            <td>
                                                                                <button class="btn btn-link" type="button"
                                                                                    data-toggle="collapse"
                                                                                    data-target="#collapseGaji{{ $employee->id_employee }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseGaji{{ $employee->id_employee }}">
                                                                                    <i class="fas fa-chevron-down"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>

                                                                        <tr id="collapseGaji{{ $employee->id_employee }}" class="collapse">
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
                                                                                                <td>{{ $detailPenggajian->tanggal_penggajian }}</td>
                                                                                                <td>Rp {{ number_format($detailPenggajian->nominal, 0, ',', '.') }}</td>

                                                                                                <td>
                                                                                                    <a href="{{ asset($detailPenggajian->bukti_pembayaran) }}" target="_blank">
                                                                                                    <img src="{{ asset($detailPenggajian->bukti_pembayaran) }}"
                                                                                                        style="width: 100px; height: auto; cursor: pointer;">

                                                                                                    </a>
                                                                                                </td>


                                                                                                <td>
                                                                                                     <a href="#"
                                                                                                        data-toggle="modal"
                                                                                                        data-target="#editModalGaji{{ $detailPenggajian->id_penggajian }}"
                                                                                                        class="btn btn-warning">
                                                                                                        <i
                                                                                                            class="fas fa-edit"></i>
                                                                                                    </a>
                                                                                                    <a href="{{ route('admin.keuangan.gaji.destroy', $detailPenggajian->id_penggajian) }}"
                                                                                                        class="btn btn-danger delete-item">
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

    <!-- The Modal -->
    <div class="modal fade" id="tambahModalGaji" tabindex="-1" aria-labelledby="tambahModalGajiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalGajiLabel">Bayar Gaji</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body (Form) -->
                <div class="modal-body">
                    <form action="{{ route('admin.keuangan.gaji.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="tim_id">{{ __('admin.Tim') }}</label>
                            <select name="tim_id" class="select2 form-control" id="tim_id">
                                <option value="">{{ __('admin.--Select--') }}</option>
                                @foreach ($timList as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('tim_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jabatan_id">{{ __('admin.Jabatan') }}</label>
                            <select name="jabatan_id" class="select2 form-control" id="jabatan_id">
                                <option value="">{{ __('admin.--Select--') }}</option>
                                @foreach ($jabatanList as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                            @error('jabatan_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="employee_id">Nama Karyawan</label>
                            <select name="employee_id" class="form-control" id="employee_id" required>
                                <option value="">-- Pilih Karyawan --</option>
                                <!-- Options will be loaded dynamically using JavaScript -->
                            </select>
                            @error('employee_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Tanggal Masuk (Readonly) -->
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="text" id="tanggal_masuk" class="form-control" readonly>
                        </div>

                        <!-- No Rekening (Readonly) -->
                        <div class="form-group">
                            <label for="no_rekening">No Rekening</label>
                            <input type="text" id="no_rekening" class="form-control" readonly>
                        </div>

                        <!-- Nama Bank (Readonly) -->
                        <div class="form-group">
                            <label for="nama_bank">Nama Bank</label>
                            <input type="text" id="nama_bank" class="form-control" readonly>
                        </div>

                        <!-- Riwayat Penggajian -->
                        <div class="form-group">
                            <label for="histori_penggajian">Riwayat Penggajian</label>
                            <div id="histori_penggajian" class="form-control" style="height: auto;" readonly>
                                <!-- Riwayat penggajian akan dimuat di sini menggunakan JavaScript -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_penggajian">Tanggal Penggajian</label>
                            <input type="date" name="tanggal_penggajian" class="form-control" id="tanggal_penggajian" required>
                        </div>

                        <!-- Jumlah Penggajian -->
                        <div class="form-group">
                            <label for="jumlah">Jumlah Penggajian</label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" required>
                        </div>

                        <!-- Bukti Pembayaran -->
                        <div class="form-group">
                            <label for="">{{ __('admin.Bukti Pembayaran') }}</label>
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">{{ __('admin.Choose File') }}</label>
                                <input type="file" name="image" id="image-upload">
                            </div>
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>



                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Employee -->
    @foreach ($penggajians->unique('id_employee') as $penggajian)
        <div class="modal fade" id="editModalEmployee{{ $penggajian->id_employee }}" tabindex="-1"
            aria-labelledby="editModalEmployeeLabel{{ $penggajian->id_employee }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalEmployeeLabel{{ $penggajian->id_employee }}">Edit Karyawan:
                            {{ $penggajian->nama_employee }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body (Form) -->
                    <div class="modal-body">
                        <form action="{{ route('admin.keuangan.employee.update', $penggajian->id_employee) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Nama Karyawan -->
                            <div class="form-group">
                                <label for="nama">Nama Karyawan</label>
                                <input type="text" name="nama" class="form-control" id="nama"
                                    value="{{ $penggajian->nama_employee }}" required>
                            </div>

                            <!-- Gaji -->
                            <div class="form-group">
                                <label for="gaji">Gaji</label>
                                <input type="number" name="gaji" class="form-control" id="gaji"
                                    value="{{ $penggajian->gaji }}" required>
                            </div>

                            <!-- No Rekening -->
                            <div class="form-group">
                                <label for="no_rekening">No Rekening</label>
                                <input type="text" name="no_rekening" class="form-control" id="no_rekening"
                                    value="{{ $penggajian->no_rekening }}" required>
                            </div>

                            <!-- Tanggal Masuk -->
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" class="form-control" id="tanggal_masuk"
                                    value="{{ $penggajian->tanggal_masuk }}" required>
                            </div>

                            <!-- Tim Select Option -->
                            <div class="form-group">
                                <label for="tim_id">Tim</label>
                                <select name="tim_id" class="form-control" id="tim_id" required>
                                    <option value="">-- Pilih Tim --</option>
                                    @foreach ($timList as $tim)
                                        <option value="{{ $tim->id }}"
                                            {{ $tim->id == $penggajian->tim_id ? 'selected' : '' }}>{{ $tim->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jabatan Select Option -->
                            <div class="form-group">
                                <label for="jabatan_id">Jabatan</label>
                                <select name="jabatan_id" class="form-control" id="jabatan_id" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($jabatanList as $jabatan)
                                        <option value="{{ $jabatan->id }}"
                                            {{ $jabatan->id == $penggajian->jabatan_id ? 'selected' : '' }}>
                                            {{ $jabatan->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Bank Select Option -->
                            <div class="form-group">
                                <label for="bank_id">Bank</label>
                                <select name="bank_id" class="form-control" id="bank_id" required>
                                    <option value="">-- Pilih Bank --</option>
                                    @foreach ($bankList as $bank)
                                        <option value="{{ $bank->id }}"
                                            {{ $bank->id == $penggajian->bank_id ? 'selected' : '' }}>
                                            {{ $bank->nama_bank }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- The Modal -->
    <div class="modal fade" id="tambahModalKaryawan" tabindex="-1" aria-labelledby="tambahModalKaryawanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalKaryawanLabel">Tambah Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body (Form) -->
                <div class="modal-body">
                    <form action="{{ route('admin.keuangan.employee.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Karyawan -->
                        <div class="form-group">
                            <label for="nama">Nama Karyawan</label>
                            <input type="text" name="nama" class="form-control" id="nama" required>
                        </div>

                        <!-- Gaji -->
                        <div class="form-group">
                            <label for="gaji">Gaji</label>
                            <input type="number" name="gaji" class="form-control" id="gaji" required>
                        </div>

                        <!-- No Rekening -->
                        <div class="form-group">
                            <label for="no_rekening">No Rekening</label>
                            <input type="text" name="no_rekening" class="form-control" id="no_rekening" required>
                        </div>

                        <!-- Tanggal Masuk -->
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control" id="tanggal_masuk" required>
                        </div>

                        <!-- Tim Select Option -->
                        <div class="form-group">
                            <label for="tim_id">Tim</label>
                            <select name="tim_id" class="form-control" id="tim_id" required>
                                <option value="">-- Pilih Tim --</option>
                                @foreach ($timList as $tim)
                                    <option value="{{ $tim->id }}">{{ $tim->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jabatan Select Option -->
                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select name="jabatan_id" class="form-control" id="jabatan_id" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach ($jabatanList as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bank Select Option -->
                        <div class="form-group">
                            <label for="bank_id">Bank</label>
                            <select name="bank_id" class="form-control" id="bank_id" required>
                                <option value="">-- Pilih Bank --</option>
                                @foreach ($bankList as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->nama_bank }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



    @foreach ($penggajians as $detailPenggajian)
        <!-- The Edit Modal -->
        <div class="modal fade" id="editModalGaji{{ $detailPenggajian->id_penggajian }}" tabindex="-1"
            aria-labelledby="editModalGajiLabel{{ $detailPenggajian->id_penggajian }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalGajiLabel{{ $detailPenggajian->id_penggajian }}">Edit Gaji -
                            {{ $detailPenggajian->nama_employee }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body (Form) -->
                    <div class="modal-body">
                        <form action="{{ route('admin.keuangan.gaji.update', $detailPenggajian->id_penggajian) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="tanggal_penggajian">Tanggal Penggajian</label>
                                <input type="date" name="tanggal_penggajian" class="form-control"
                                    id="tanggal_penggajian" value="{{ $detailPenggajian->tanggal_penggajian }}" required>
                            </div>

                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" id="jumlah"
                                    value="{{ $detailPenggajian->nominal }}" required>
                            </div>

                            <div class="form-group">
                                <label for="bukti_pembayaran">Bukti Pembayaran</label>
                                <input type="file" name="bukti_pembayaran" class="form-control" id="bukti_pembayaran"
                                    accept="image/*">
                                <small class="form-text text-muted">Jika Anda tidak ingin mengganti bukti pembayaran, cukup
                                    kosongkan field ini.</small>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '#tim_id, #jabatan_id', function() {
                const timId = $('#tim_id').val();
                const jabatanId = $('#jabatan_id').val();

                if (timId && jabatanId) {
                    $.ajax({
                        url: '{{ route('admin.getEmployeesByTimAndJabatan') }}',
                        type: 'GET',
                        data: {
                            tim_id: timId,
                            jabatan_id: jabatanId
                        },
                        success: function(response) {
                            $('#employee_id').empty();
                            $('#employee_id').append(
                                '<option value="">-- Pilih Karyawan --</option>');
                            $.each(response, function(key, employee) {
                                $('#employee_id').append('<option value="' + employee
                                    .id + '">' + employee.nama + '</option>');
                            });
                        }
                    });
                } else {
                    $('#employee_id').empty().append('<option value="">--Select--</option>');
                }
            });

            $(document).on('change', '#employee_id', function() {
                var employee_id = $(this).val();

                if (employee_id) {
                    $.ajax({
                        url: '{{ route('admin.getEmployeeDetails') }}',
                        type: "GET",
                        data: {
                            employee_id: employee_id
                        },
                        success: function(response) {


                            // Tampilkan tanggal masuk
                            $('#tanggal_masuk').val(response.tanggal_masuk);

                            // Tampilkan no rekening
                            $('#no_rekening').val(response.no_rekening);

                            // Tampilkan nama bank
                            $('#nama_bank').val(response.nama_bank);

                            // Tampilkan histori penggajian
                            var histori = response.histori_penggajian;
                            var historiHtml = '';
                            if (histori.length > 0) {
                                historiHtml += '<ul>';
                                $.each(histori, function(key, gaji) {
                                    historiHtml += '<li>' + gaji.tanggal_penggajian +
                                        ': Rp' + gaji.jumlah + '</li>';
                                });
                                historiHtml += '</ul>';
                            } else {
                                historiHtml = 'Belum ada histori penggajian.';
                            }
                            $('#histori_penggajian').html(historiHtml);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('toast_success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('toast_success') }}'
                });
            @endif

            @if (Session::has('toast_error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('toast_error') }}'
                });
            @endif
        });
    </script>
@endsection
