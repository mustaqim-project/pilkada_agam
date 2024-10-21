@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Data Penggajian') }}</h1>
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
                            <th>No.</th>
                            <th>Tim</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedPenggajians as $tim => $items)
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
                                    <!-- Aksi jika diperlukan, misalnya edit atau delete tim -->
                                </td>
                            </tr>

                            <tr id="collapseTim{{ $loop->iteration }}" class="collapse">
                                <td colspan="3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Jabatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $jabatanIndex => $item)
                                                <tr>
                                                    <td>
                                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                            data-target="#collapseJabatan{{ $jabatanIndex }}{{ $loop->iteration }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapseJabatan{{ $jabatanIndex }}{{ $loop->iteration }}">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </button>
                                                    </td>
                                                    <td>{{ $item->nama_jabatan }}</td>
                                                    <td>
                                                        <!-- Aksi jika diperlukan, misalnya edit atau delete jabatan -->
                                                    </td>
                                                </tr>

                                                <tr id="collapseJabatan{{ $jabatanIndex }}{{ $loop->iteration }}" class="collapse">
                                                    <td colspan="3">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Nama</th>
                                                                    <th>Aksi</th>
                                                                    <th>Detail</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($item->employees as $employeeIndex => $employee)
                                                                    <tr>
                                                                        <td>{{ $employeeIndex + 1 }}</td>
                                                                        <td>{{ $employee->nama }}</td>
                                                                        <td>
                                                                            <a href="#" data-toggle="modal"
                                                                                data-target="#editModal{{ $employee->id }}"
                                                                                class="btn btn-warning">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            {{-- <a href="{{ route('penggajian.destroy', $employee->id) }}"
                                                                                class="btn btn-danger delete-item">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </a> --}}
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn btn-info" type="button" data-toggle="collapse"
                                                                                data-target="#collapseDetail{{ $employee->id }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapseDetail{{ $employee->id }}">
                                                                                Lihat Gaji
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="collapseDetail{{ $employee->id }}" class="collapse">
                                                                        <td colspan="4">
                                                                            <p>Tanggal Penggajian: {{ $employee->tanggal_penggajian }}</p>
                                                                            <p>Jumlah: Rp {{ number_format($employee->nominal, 0, ',', '.') }}</p>
                                                                            <p>Bukti Pembayaran: <img src="{{ asset('storage/' . $employee->bukti_pembayaran) }}" alt="Bukti Pembayaran" width="100"></p>
                                                                            <div>
                                                                                <a href="#" data-toggle="modal"
                                                                                    data-target="#editGajiModal{{ $employee->id }}"
                                                                                    class="btn btn-warning">Edit</a>
                                                                                {{-- <a href="{{ route('penggajian.destroy', $employee->id) }}"
                                                                                    class="btn btn-danger delete-item">Delete</a> --}}
                                                                            </div>
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
