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
                            Tim: {{ $tim }}
                        </button>
                    </h5>
                </div>

                <div id="collapse-{{ Str::slug($tim) }}" class="collapse" aria-labelledby="heading-{{ Str::slug($tim) }}" data-parent="#accordionExample">
                    <div class="card-body">
                        @foreach($penggajianByTim->groupBy('employee.jabatan.nama_jabatan') as $jabatan => $penggajianByJabatan)
                            <div class="mb-3">
                                <h5>Jabatan: {{ $jabatan }}</h5>
                                <ul>
                                    @foreach($penggajianByJabatan->groupBy('employee.nama') as $nama => $penggajians)
                                        <li>
                                            <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse-{{ Str::slug($tim . '-' . $jabatan . '-' . $nama) }}" aria-expanded="false" aria-controls="collapse-{{ Str::slug($tim . '-' . $jabatan . '-' . $nama) }}">
                                                {{ $nama }}
                                            </button>

                                            <div id="collapse-{{ Str::slug($tim . '-' . $jabatan . '-' . $nama) }}" class="collapse">
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
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
