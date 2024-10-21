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



    <!-- The Modal -->
    <div class="modal fade" id="tambahModalGaji" tabindex="-1" aria-labelledby="tambahModalGajiLabel"
        aria-hidden="true">
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
                    <form action="{{ route('admin.keuangan.gaji.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="">{{ __('admin.Tim') }}</label>
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
                            <label for="">{{ __('admin.Jabatan') }}</label>
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






                        <!-- Employee Select Option -->
                        <div class="form-group">
                            <label for="employee_id">Nama Karyawan</label>
                            <select name="employee_id" class="form-control" id="employee_id" required>
                                <option value="">-- Pilih Karyawan --</option>
                                <!-- Options will be loaded dynamically using JavaScript -->
                            </select>
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

                        <!-- Jumlah Penggajian -->
                        <div class="form-group">
                            <label for="jumlah">Jumlah Penggajian</label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" required>
                        </div>

                        <!-- Bukti Pembayaran -->
                        <div class="form-group">
                            <label for="bukti_pembayaran">Bukti Pembayaran</label>
                            <input type="text" name="bukti_pembayaran" class="form-control" id="bukti_pembayaran">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



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


        $(document).ready(function() {




            $('#tim_id, #jabatan_id').change(function() {
                var tim_id = $('#tim_id').val();
                var jabatan_id = $('#jabatan_id').val();
                console.log('Tim ID:', tim_id, 'Jabatan ID:', jabatan_id);

                if (tim_id && jabatan_id) {
                    $.ajax({
                        url: "{{ route('admin.getEmployeesByTimAndJabatan') }}", // Pastikan Anda membuat route dan controller untuk ini
                        type: "GET",
                        data: {
                            tim_id: tim_id,
                            jabatan_id: jabatan_id
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
                }
            });

            // Show employee details (tanggal masuk, no rekening, nama bank, and histori penggajian) when an employee is selected
            $('#employee_id').change(function() {
                var employee_id = $(this).val();

                if (employee_id) {
                    $.ajax({
                        url: "{{ route('admin.getEmployeeDetails') }}", // Pastikan Anda membuat route dan controller untuk ini
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
@endsection
