@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Kanvasing Wisata</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <button class="btn btn-primary" id="createWisataBtn" data-toggle="modal" data-target="#modalTambahWisata">
                <i class="fas fa-plus"></i> Tambah Wisata
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tableWisata">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Responden</th>
                            <th>No KTP</th>
                            <th>Kecamatan</th>
                            <th>Pekerjaan</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th>Hadir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wisatas as $wisata)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $wisata->nama_responden }}</td>
                                <td>{{ $wisata->no_ktp }}</td>
                                <td>{{ $wisata->kecematan->nama_kecamatan }}</td>
                                <td>{{ $wisata->pekerjaan->name }}</td>
                                <td>{{ $wisata->jadwal }}</td>
                                <td>{{ $wisata->status ? 'Onsite' : 'Booking' }}</td>
                                <td>{{ $wisata->hadir ? 'Ya' : 'Tidak' }}</td>
                                <td>
                                    <!-- Tombol Edit Wisata -->
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEditWisata" data-id="{{ $wisata->id }}">
                                        Edit
                                    </button>
                                    <!-- Tombol Hapus Wisata -->
                                    <form action="{{ route('admin.timwisata.admin.kecematan.deleteWisata', $wisata->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus wisata ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Wisata -->
<div class="modal fade" id="modalTambahWisata" tabindex="-1" aria-labelledby="modalTambahWisataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.timwisata.admin.kecematan.storeWisata') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahWisataLabel">Tambah Wisata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="kecematan_id" class="form-label">Kecamatan</label>
                        <select name="kecematan_id" id="kecematan_id" class="form-control" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach($kecamatans as $kecematan)
                                <option value="{{ $kecematan->id }}">{{ $kecematan->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelurahan_id" class="form-label">Kecamatan</label>
                        <select name="kelurahan_id" id="kelurahan_id" class="form-control" required>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_ktp" class="form-label">No KTP</label>
                        <input type="text" name="no_ktp" id="no_ktp" class="form-control" required maxlength="16">
                    </div>
                    <div class="form-group">
                        <label for="nama_responden" class="form-label">Nama Responden</label>
                        <input type="text" name="nama_responden" id="nama_responden" class="form-control" required maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan_id" class="form-label">Pekerjaan</label>
                        <select name="pekerjaan_id" id="pekerjaan_id" class="form-control" required>
                            <option value="">Pilih Pekerjaan</option>
                            @foreach($pekerjaans as $pekerjaan)
                                <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="jadwal" class="form-label">Jadwal</label>
                        <input type="date" name="jadwal" id="jadwal" class="form-control" required>
                    </div>

                    <!-- Hidden input for Status with default value 0 -->
                    <input type="hidden" name="status" value="0">

                    <!-- Hidden input for Hadir with default value 0 -->
                    <input type="hidden" name="hadir" value="0">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit Wisata -->
<div class="modal fade" id="modalEditWisata" tabindex="-1" aria-labelledby="modalEditWisataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditWisata" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditWisataLabel">Edit Wisata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Input fields for edit form will be filled dynamically using JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#kecematan_id').change(function() {
                var kecamatanId = $(this).val();
                $('#kelurahan_id').empty().append(
                    '<option value="">Pilih Kelurahan</option>');

                if (kecamatanId) {
                    $.ajax({
                        url: + kecamatanId,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan
                                    .id + '">' + kelurahan.nama_kelurahan +
                                    '</option>');
                            });
                        }
                    });
                }
            });
    });
</script>
@endpush
