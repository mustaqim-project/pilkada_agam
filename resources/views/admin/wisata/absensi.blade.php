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
                                <td>{{ $wisata->status ? 'Booking' : 'Onsite' }}</td>
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
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">Pilih User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kecematan_id" class="form-label">Kecamatan</label>
                        <select name="kecematan_id" id="kecematan_id" class="form-control" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach($kecamatans as $kecematan)
                                <option value="{{ $kecematan->id }}">{{ $kecematan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelurahan_id" class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan_id" id="kelurahan_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="no_ktp" class="form-label">No KTP</label>
                        <input type="text" name="no_ktp" id="no_ktp" class="form-control" required maxlength="16">
                    </div>
                    <div class="form-group">
                        <label for="nama_responden" class="form-label">Nama Responden</label>
                        <input type="text" name="nama_responden" id="nama_responden" class="form-control" required>
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
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jadwal" class="form-label">Jadwal</label>
                        <input type="date" name="jadwal" id="jadwal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hadir" class="form-label">Hadir</label>
                        <select name="hadir" id="hadir" class="form-control" required>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="foto_kegiatan" class="form-label">Foto Kegiatan</label>
                        <input type="file" name="foto_kegiatan" id="foto_kegiatan" class="form-control">
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
        // Handle edit button click
        $('#modalEditWisata').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            // Set the action attribute in the form to the correct URL
            $('#formEditWisata').attr('action', '/admin/wisata/' + id);

            // Fetch and fill in the form with existing data
            $.get('/admin/wisata/' + id + '/edit', function (data) {
                var wisata = data.wisata;
                // Populate the form fields dynamically using jQuery
                $('#formEditWisata .modal-body').html(`
                    <div class="form-group">
                        <label for="edit_nama_responden" class="form-label">Nama Responden</label>
                        <input type="text" name="nama_responden" id="edit_nama_responden" class="form-control" value="${wisata.nama_responden}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_no_ktp" class="form-label">No KTP</label>
                        <input type="text" name="no_ktp" id="edit_no_ktp" class="form-control" value="${wisata.no_ktp}" required maxlength="16">
                    </div>
                    <!-- Add more fields as necessary -->
                `);
            });
        });
    });
</script>
@endpush
