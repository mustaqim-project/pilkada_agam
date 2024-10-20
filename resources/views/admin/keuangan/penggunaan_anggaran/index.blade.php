@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Daftar Penggunaan Anggaran') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                        + Penggunaan Anggaran
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

                            @foreach ($laporanPembayaran as $tim => $periodes)
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
                                    <td colspan="2">
                                        <table class="table table-bordered">
                                            @foreach ($periodes as $periode => $details)
                                                <thead>
                                                    <tr>
                                                        <th colspan="5">Periode: {{ $periode }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Rincian</th>
                                                        <th>Jumlah Anggaran</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($details as $laporan)
                                                        <tr>
                                                            <td>{{ $laporan->nama_rincian }}</td>
                                                            <td>Rp
                                                                {{ number_format($laporan->jumlah_digunakan, 0, ',', '.') }}
                                                            </td>
                                                            <td>

                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#editModal{{ $laporan->penggunaan_anggaran_id }}"
                                                                    class="btn btn-warning">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <!-- Tombol Hapus -->
                                                                <a href="{{ route('admin.keuangan.penggunaan_anggaran.destroy', $laporan->penggunaan_anggaran_id) }}"
                                                                    class="btn btn-danger delete-item">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>


                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @endforeach
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.keuangan.penggunaan_anggaran.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Penggunaan Anggaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="periode_id">Nama Periode</label>
                            <select class="form-control" name="periode_id" required>

                                @foreach ($periodes as $periode)


                                    <option value="{{ $periode->id }}">
                                        {{ $periode->nama_periode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail_pembiayaan_id">Nama Rincian Pembiayaan</label>
                            <select class="form-control" name="detail_pembiayaan_id" required>
                                @foreach ($detailPembiayaans as $detail)
                                    <option value="{{ $detail->id }}">{{ $detail->nama_rincian }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_digunakan">Jumlah Anggaran</label>
                            <input type="number" class="form-control" name="jumlah_digunakan" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- @foreach ($laporanPembayaran as $item)
        <div class="modal fade" id="editModal{{ $item->laporan_id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $item->laporan_id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.keuangan.penggunaan_anggaran.update', $item->laporan_id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->laporan_id }}">Edit Penggunaan Anggaran
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="periode_id">Nama Periode</label>
                                <select class="form-control" name="periode_id" required>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode->id }}"
                                            {{ $periode->id == $item->periode_id ? 'selected' : '' }}>
                                            {{ $periode->nama_periode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="detail_pembiayaan_id">Nama Rincian Pembiayaan</label>
                                <select class="form-control" name="detail_pembiayaan_id" required>
                                    @foreach ($detailPembiayaans as $detail)
                                        <option value="{{ $detail->id }}"
                                            {{ $detail->id == $item->detail_pembiayaan_id ? 'selected' : '' }}>
                                            {{ $detail->nama_rincian }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jumlah_digunakan">Jumlah Digunakan</label>
                                <input type="number" class="form-control" name="jumlah_digunakan"
                                    value="{{ $item->jumlah_digunakan }}" required>
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" name="keterangan">{{ $item->keterangan }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach --}}



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('toast_success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('
                                                    toast_success ') }}'
                });
            @endif

            @if (Session::has('toast_error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('
                                                    toast_error ') }}'
                });
            @endif
        });


        $(document).ready(function() {
            $("#tablelaporanPembayaran").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }],
                "order": [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endsection
