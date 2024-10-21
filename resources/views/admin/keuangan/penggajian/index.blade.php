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
                                                                    @foreach ($jabatanGroup->unique('id_employee') as $penggajian)
                                                                        <tr>
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
                                                                                            <th>Tanggal Penggajian</th>
                                                                                            <th>Jumlah</th>
                                                                                            <th>Bukti Pembayaran</th>
                                                                                            <th>Aksi</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($jabatanGroup as $detailPenggajian)
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


    @php
        use App\Models\tim;
        use App\Models\jabatan;
        use App\Models\Bank;

        // Fetch data from models
        $timList = tim::all();
        $jabatanList = jabatan::all();
        $bankList = Bank::all();
    @endphp

    <!-- The Modal -->
    <div class="modal fade" id="tambahModalKaryawan" tabindex="-1" aria-labelledby="tambahModalKaryawanLabel" aria-hidden="true">
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
                    <form action="{{ route('admin.keuangan.employee.store') }}" method="POST">
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
                                @foreach($timList as $tim)
                                    <option value="{{ $tim->id }}">{{ $tim->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jabatan Select Option -->
                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select name="jabatan_id" class="form-control" id="jabatan_id" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach($jabatanList as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bank Select Option -->
                        <div class="form-group">
                            <label for="bank_id">Bank</label>
                            <select name="bank_id" class="form-control" id="bank_id" required>
                                <option value="">-- Pilih Bank --</option>
                                @foreach($bankList as $bank)
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
