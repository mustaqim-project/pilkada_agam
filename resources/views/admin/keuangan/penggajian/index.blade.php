@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h2>Daftar Penggajian</h2>

    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama TIM</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penggajians->groupBy('employee.tim.nama_tim') as $tim => $penggajianByTim)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ Str::slug($tim) }}" aria-expanded="true" aria-controls="collapse-{{ Str::slug($tim) }}">
                            {{ $tim }}
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse-jabatan-{{ Str::slug($tim) }}" aria-expanded="false" aria-controls="collapse-jabatan-{{ Str::slug($tim) }}">
                            Lihat Jabatan
                        </button>
                    </td>
                </tr>

                <tr id="collapse-{{ Str::slug($tim) }}" class="collapse">
                    <td colspan="3">
                        <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Posisi Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penggajianByTim->groupBy('employee.jabatan.nama_jabatan') as $jabatan => $penggajianByJabatan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jabatan }}</td>
                                        <td>
                                            <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse-karyawan-{{ Str::slug($tim . '-' . $jabatan) }}" aria-expanded="false" aria-controls="collapse-karyawan-{{ Str::slug($tim . '-' . $jabatan) }}">
                                                Lihat Karyawan
                                            </button>
                                        </td>
                                    </tr>

                                    <tr id="collapse-karyawan-{{ Str::slug($tim . '-' . $jabatan) }}" class="collapse">
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
                                                                {{-- <a href="{{ route('admin.penggajian.edit', $penggajians->first()->id) }}" class="btn btn-warning">Edit</a> --}}
                                                                <form action="{{ route('admin.keuangan.gaji.destroy', $penggajians->first()->id) }}" method="POST" style="display:inline-block;">
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
