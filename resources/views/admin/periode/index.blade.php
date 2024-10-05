@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Daftar Periode</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
        Tambah Periode
    </button>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Periode</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Anggaran Periode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodes as $periode)
            <tr>
                <td>{{ $periode->id }}</td>
                <td>{{ $periode->nama_periode }}</td>
                <td>{{ $periode->tanggal_mulai }}</td>
                <td>{{ $periode->tanggal_selesai }}</td>
                <td>{{ $periode->anggaran_periode }}</td>
                <td>
                    <button class="btn btn-warning edit-button" data-id="{{ $periode->id }}">Edit</button>
                    <form action="{{ route('admin.periode.destroy', $periode->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createPeriodeModal" tabindex="-1" role="dialog" aria-labelledby="createPeriodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="createPeriodeForm" method="POST" action="{{ route('admin.periode.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createPeriodeModalLabel">Tambah Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="anggaran_id">Anggaran ID</label>
                        <select class="form-control" name="anggaran_id" id="anggaran_id" required>
                            <option value="">Pilih Anggaran</option>
                            @foreach($anggarans as $anggaran)
                                <option value="{{ $anggaran->id }}">{{ $anggaran->nama_anggaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_periode">Nama Periode</label>
                        <input type="text" class="form-control" name="nama_periode" id="nama_periode" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="anggaran_periode">Anggaran Periode</label>
                        <input type="number" class="form-control" name="anggaran_periode" id="anggaran_periode" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editPeriodeModal" tabindex="-1" role="dialog" aria-labelledby="editPeriodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editPeriodeForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editPeriodeModalLabel">Edit Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="periodeId">
                    <div class="form-group">
                        <label for="edit_anggaran_id">Anggaran ID</label>
                        <select class="form-control" name="anggaran_id" id="edit_anggaran_id" required>
                            <option value="">Pilih Anggaran</option>
                            @foreach($anggarans as $anggaran)
                                <option value="{{ $anggaran->id }}">{{ $anggaran->nama_anggaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_periode">Nama Periode</label>
                        <input type="text" class="form-control" name="nama_periode" id="edit_nama_periode" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggal_mulai" id="edit_tanggal_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="tanggal_selesai" id="edit_tanggal_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_anggaran_periode">Anggaran Periode</label>
                        <input type="number" class="form-control" name="anggaran_periode" id="edit_anggaran_periode" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>


@section('scripts')
<script>
    $(document).ready(function() {
        $('.edit-button').on('click', function() {
            var id = $(this).data('id');
            $.get('/admin/periode/' + id + '/edit', function(data) {
                $('#editPeriodeId').val(data.id);
                $('#edit_anggaran_id').val(data.anggaran_id);
                $('#edit_nama_periode').val(data.nama_periode);
                $('#edit_tanggal_mulai').val(data.tanggal_mulai);
                $('#edit_tanggal_selesai').val(data.tanggal_selesai);
                $('#edit_anggaran_periode').val(data.anggaran_periode);
                $('#editForm').attr('action', '/admin/periode/' + data.id);
                $('#editModal').modal('show');
            });
        });

        // Handle create form submission
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    location.reload(); // Refresh page to see the changes
                },
                error: function(response) {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        // Handle edit form submission
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    location.reload(); // Refresh page to see the changes
                },
                error: function(response) {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
</script>
@endsection
@endsection
