@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h2>Daftar Penggajian</h2>

    <div class="accordion" id="accordionExample">
        @foreach($penggajians->groupBy('employee.tim.nama_tim') as $tim => $penggajianByTim)
            <div class="card">
                <div class="card-header" id="heading-{{ Str::slug($tim) }}">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ Str::slug($tim) }}" aria-expanded="true" aria-controls="collapse-{{ Str::slug($tim) }}">
                            TIM: {{ $tim }}
                        </button>
                    </h5>
                </div>

                <div id="collapse-{{ Str::slug($tim) }}" class="collapse" aria-labelledby="heading-{{ Str::slug($tim) }}" data-parent="#accordionExample">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penggajianByTim->groupBy('employee.jabatan.nama_jabatan') as $jabatan => $penggajianByJabatan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jabatan }}</td>
                                        <td>
                                            <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse-jabatan-{{ Str::slug($tim . '-' . $jabatan) }}" aria-expanded="false" aria-controls="collapse-jabatan-{{ Str::slug($tim . '-' . $jabatan) }}">
                                                Lihat Karyawan
                                            </button>
                                        </td>
                                    </tr>

                                    <tr id="collapse-jabatan-{{ Str::slug($tim . '-' . $jabatan) }}" class="collapse">
                                        <td colspan="3">
                                            <table class="table table-bordered mt-2">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama</th>
                                                        <th>Aksi</th>
                                                        <th>Detail</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($penggajianByJabatan->groupBy('employee.nama') as $nama => $penggajians)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $nama }}</td>
                                                            <td>
                                                                <a href="{{ route('penggajian.edit', $penggajians->first()->id) }}" class="btn btn-warning">Edit</a>
                                                                <form action="{{ route('penggajian.destroy', $penggajians->first()->id) }}" method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus penggajian ini?')">Delete</button>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapse-gaji-{{ Str::slug($tim . '-' . $jabatan . '-' . $nama) }}" aria-expanded="false" aria-controls="collapse-gaji-{{ Str::slug($tim . '-' . $jabatan . '-' . $nama) }}">
                                                                    Lihat Detail Gaji
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        <tr id="collapse-gaji-{{ Str::slug($tim . '-' . $jabatan . '-' . $nama) }}" class="collapse">
                                                            <td colspan="4">
                                                                <table class="table table-bordered mt-2">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Tanggal Penggajian</th>
                                                                            <th>Jumlah</th>
                                                                            <th>Bukti Pembayaran</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($penggajians as $penggajian)
                                                                            <tr>
                                                                                <td>{{ $penggajian->tanggal_penggajian }}</td>
                                                                                <td>{{ number_format($penggajian->jumlah, 2) }}</td>
                                                                                <td>
                                                                                    @if($penggajian->bukti_pembayaran)
                                                                                        <a href="{{ asset('storage/' . $penggajian->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a>
                                                                                    @else
                                                                                        Tidak ada bukti
                                                                                    @endif
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
        @endforeach
    </div>
</div>
@endsection
