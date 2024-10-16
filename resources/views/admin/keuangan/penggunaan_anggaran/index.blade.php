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
{{--
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablePenggunaanAnggaran">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Periode</th>
                                <th>Nama Rincian Pembiayaan</th>
                                <th>Jumlah Digunakan</th>
                                <th>Status Pembayaran</th>
                                <th>Bukti Pembayaran</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penggunaanAnggaran as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->periode->nama_periode }} - {{ $item->periode->anggaran->tim->name }}</td>
                                    <td>{{ $item->detailPembiayaan->nama_rincian }}</td>
                                    <td>{{ 'Rp' . number_format($item->jumlah_digunakan, 0, ',', '.') }}</td>
                                    <td>{{ $item->status_pembayaran == 1 ? 'Lunas' : 'Belum Lunas' }}</td>
                                    <td><img src="{{ asset($item->bukti_pembayaran) }}" alt="Bukti" width="100"></td>
                                    <td>{{ $item->keterangan }}</td>

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                            <!-- Tombol Detail -->
                                            <a href="#" data-toggle="modal"
                                                data-target="#detailModal{{ $item->id }}" class="btn btn-primary"
                                                aria-label="Lihat Detail {{ $item->name }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <!-- Tombol Edit -->
                                            <a href="#" data-toggle="modal"
                                                data-target="#editModal{{ $item->id }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <a href="{{ route('admin.keuangan.penggunaan_anggaran.destroy', $item->id) }}"
                                                class="btn btn-danger delete-item">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}

            <div class="row mb-4">
                <!-- Laporan Pembayaran Lengkap dalam Bentuk Tabel -->
                <div class="col-md-12">
                    <h3>Laporan Pembayaran Lengkap</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Tim</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanPembayaran as $tim => $periodes)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tim }}</td>
                                    <td>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTim{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapseTim{{ $loop->iteration }}">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Subtabel Periode dan Detail untuk Tim -->
                                <tr id="collapseTim{{ $loop->iteration }}" class="collapse">
                                    <td colspan="3">
                                        <table class="table table-bordered">
                                            @foreach ($periodes as $periode)
                                                <thead>
                                                    <tr>
                                                        <th colspan="4">Periode: {{ $periode->periode->nama_periode }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Rincian</th>
                                                        <th>Jumlah Digunakan</th>
                                                        <th>Status Pembayaran</th>
                                                        <th>Bukti Pembayaran</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detailPembiayaan as $laporan)
                                                            <tr>
                                                                <td>{{ $laporan->nama_rincian }}</td>
                                                                <td>Rp {{ number_format($laporan->jumlah_digunakan, 0, ',', '.') }}</td>
                                                                <td>
                                                                    @if ($laporan->status_pembayaran == 1)
                                                                        Lunas
                                                                    @elseif($laporan->status_pembayaran == 0)
                                                                        Belum Dibayar
                                                                    @else
                                                                        Status Tidak Diketahui
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($laporan->bukti_pembayaran)
                                                                        <a href="{{ asset($laporan->bukti_pembayaran) }}" target="_blank">Download</a>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <!-- Jika $laporan tidak valid, Anda bisa menampilkan baris kosong atau pesan -->
                                                            <tr>
                                                                <td colspan="4">Tidak ada rincian untuk periode ini.</td>
                                                            </tr>
                                                        @endif
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

    <!-- Modal Detail -->
    {{-- @foreach ($penggunaanAnggaran as $item)
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Penggunaan Anggaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $item->id }}</p>
                        <p><strong>Nama Periode:</strong> {{ $item->periode->nama_periode }} -
                            {{ $item->periode->anggaran->tim->name }}</p>
                        <p><strong>Nama Rincian Pembiayaan:</strong> {{ $item->detailPembiayaan->nama_rincian }}</p>
                        <p><strong>Jumlah Digunakan:</strong>
                            {{ 'Rp' . number_format($item->jumlah_digunakan, 0, ',', '.') }}</p>
                        <p><strong>Status Pembayaran:</strong>
                            {{ $item->status_pembayaran == 1 ? 'Lunas' : 'Belum Lunas' }}</p>
                        <p><strong>Bukti Pembayaran:</strong></p>
                        <img src="{{ asset($item->bukti_pembayaran) }}" alt="Bukti" width="100">
                        <p><strong>Keterangan:</strong> {{ $item->keterangan }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}

    <!-- Modal Tambah -->
    {{-- <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
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
                                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }} -
                                        {{ $periode->anggaran->tim->name }}</option>
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
                            <label for="jumlah_digunakan">Jumlah Digunakan</label>
                            <input type="number" class="form-control" name="jumlah_digunakan" required>
                        </div>
                        <div class="form-group">
                            <label for="status_pembayaran">Status Pembayaran</label>
                            <select class="form-control" name="status_pembayaran">
                                <option value="1">Lunas</option>
                                <option value="0">Belum Lunas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bukti_pembayaran">Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran">
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
    </div> --}}


    {{-- @foreach ($penggunaanAnggaran as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.keuangan.penggunaan_anggaran.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Penggunaan Anggaran</h5>
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
                                <label for="status_pembayaran">Status Pembayaran</label>
                                <select class="form-control" name="status_pembayaran">
                                    <option value="1" {{ $item->status_pembayaran == 1 ? 'selected' : '' }}>Lunas
                                    </option>
                                    <option value="0" {{ $item->status_pembayaran == 0 ? 'selected' : '' }}>Belum
                                        Lunas</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="bukti_pembayaran">Bukti Pembayaran</label>
                                <input type="file" class="form-control" name="bukti_pembayaran">
                                @if ($item->bukti_pembayaran)
                                    <img src="{{ asset($item->bukti_pembayaran) }}" alt="Bukti" width="100">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" name="keterangan">{{ $item->keterangan }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
            $("#tablePenggunaanAnggaran").dataTable({
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
