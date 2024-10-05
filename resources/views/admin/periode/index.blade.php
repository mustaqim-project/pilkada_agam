@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Daftar Periode</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#periodeModal">
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

<!-- Modal -->
<div class="modal fade" id="periodeModal" tabindex="-1" role="dialog" aria-labelledby="periodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="periodeForm" method="POST" action="{{ route('admin.periode.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="periodeModalLabel">Tambah/Edit Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="periodeId">

                    <div class="form-group">
                        <label for="anggaran_id">Anggaran ID</label>
                        <input type="text" class="form-control" name="anggaran_id" id="anggaran_id" required>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Periode</button>
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
                $('#periodeId').val(data.id);
                $('#anggaran_id').val(data.anggaran_id);
                $('#nama_periode').val(data.nama_periode);
                $('#tanggal_mulai').val(data.tanggal_mulai);
                $('#tanggal_selesai').val(data.tanggal_selesai);
                $('#anggaran_periode').val(data.anggaran_periode);
                $('#periodeModalLabel').text('Edit Periode');
                $('#periodeForm').attr('action', '/admin/periode/' + data.id);
                $('#periodeModal').modal('show');
            });
        });

        $('#periodeForm').on('submit', function(e) {
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
