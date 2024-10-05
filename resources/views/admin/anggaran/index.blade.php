@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Anggaran</h1>
    <button class="btn btn-primary" id="createAnggaran">Tambah Anggaran</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tim</th>
                <th>Total Anggaran</th>
                <th>Jumlah Periode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggarans as $anggaran)
            <tr>
                <td>{{ $anggaran->id }}</td>
                <td>{{ $anggaran->tim->name }}</td>
                <td>{{ $anggaran->total_anggaran }}</td>
                <td>{{ $anggaran->jumlah_periode }}</td>
                <td>
                    <button class="btn btn-warning editAnggaran" data-id="{{ $anggaran->id }}">Edit</button>
                    <form action="{{ route('admin.anggaran.destroy', $anggaran->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="anggaranModal" tabindex="-1" role="dialog" aria-labelledby="anggaranModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="anggaranModalLabel">Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="anggaranForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="id" id="anggaranId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tim_id">Tim</label>
                        <select name="tim_id" id="tim_id" class="form-control" required>
                            <!-- Pastikan Anda mengisi opsi Tim di sini -->
                            @foreach ($tims as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_anggaran">Total Anggaran</label>
                        <input type="number" name="total_anggaran" id="total_anggaran" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_periode">Jumlah Periode</label>
                        <input type="number" name="jumlah_periode" id="jumlah_periode" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveAnggaran">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#createAnggaran').click(function() {
        $('#anggaranForm')[0].reset();
        $('#anggaranId').val('');
        $('#methodField').val('POST');
        $('#anggaranModalLabel').text('Tambah Anggaran');
        $('#anggaranModal').modal('show');
    });

    $('.editAnggaran').click(function() {
        const id = $(this).data('id');
        $.get('/admin/anggaran/' + id + '/edit', function(data) {
            $('#anggaranId').val(data.id);
            $('#tim_id').val(data.tim_id);
            $('#total_anggaran').val(data.total_anggaran);
            $('#jumlah_periode').val(data.jumlah_periode);
            $('#anggaranModalLabel').text('Edit Anggaran');
            $('#methodField').val('PUT');
            $('#anggaranModal').modal('show');
        });
    });

    $('#anggaranForm').on('submit', function(event) {
        event.preventDefault();
        const actionUrl = $('#anggaranId').val() ? '/admin/anggaran/' + $('#anggaranId').val() : '{{ route("admin.anggaran.store") }}';
        $.ajax({
            url: actionUrl,
            type: $(this).find('input[name="_method"]').val() || 'POST',
            data: $(this).serialize(),
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
});
</script>
@endsection
