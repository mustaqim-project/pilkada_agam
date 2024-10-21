@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Data Penggajian</h1>

        <!-- Table untuk Tim -->
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tim</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penggajians->groupBy('employee.tim.name') as $timName => $penggajianGroup)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $timName }}</td>
                        <td>
                            <button class="btn btn-info" data-toggle="collapse"
                                data-target="#jabatan-{{ $loop->index }}">Tampilkan Jabatan</button>
                        </td>
                    </tr>
                    <tr id="jabatan-{{ $loop->index }}" class="collapse">
                        <td colspan="3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penggajianGroup->groupBy('employee.jabatan.name') as $jabatanName => $jabatanGroup)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jabatanName }}</td>
                                            <td>
                                                <button class="btn btn-info" data-toggle="collapse"
                                                    data-target="#employee-{{ $loop->index }}">Tampilkan Employee</button>
                                            </td>
                                        </tr>
                                        <tr id="employee-{{ $loop->index }}" class="collapse">
                                            <td colspan="3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Nama</th>
                                                            <th>Aksi</th>
                                                            <th>Detail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($jabatanGroup as $employee)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $employee->employee->nama }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning">Edit</button>
                                                                    <button class="btn btn-danger">Delete</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-info" data-toggle="collapse"
                                                                        data-target="#gaji-{{ $loop->index }}">Detail
                                                                        Gaji</button>
                                                                </td>
                                                            </tr>
                                                            <tr id="gaji-{{ $loop->index }}" class="collapse">
                                                                <td colspan="4">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Tanggal Penggajian</th>
                                                                                <th>Jumlah</th>
                                                                                <th>Bukti Pembayaran</th>
                                                                                <th>Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($employee->employee->penggajians as $gaji)
                                                                                <tr>
                                                                                    <td>{{ $gaji->tanggal_penggajian }}
                                                                                    </td>
                                                                                    <td>{{ number_format($gaji->jumlah, 2, ',', '.') }}
                                                                                    </td>
                                                                                    <td>{{ $gaji->bukti_pembayaran }}</td>
                                                                                    <td>
                                                                                        <button
                                                                                            class="btn btn-warning">Edit</button>
                                                                                        <button
                                                                                            class="btn btn-danger">Delete</button>
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
@endsection
