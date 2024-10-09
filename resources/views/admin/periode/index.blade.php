@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Periode Anggaran') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-header-actions">
                <button class="btn btn-primary" id="createPeriodeBtn" data-toggle="modal" data-target="#periodeModal">
                    <i class="fas fa-plus"></i> {{ __('admin.Tambah Periode') }}
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table">
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
                        @foreach ($periodes as $periode)
                            <tr>
                                <td>{{ $periode->id }}</td>
                                <td>{{ $periode->nama_periode }}</td>
                                <td>{{ $periode->tanggal_mulai }}</td>
                                <td>{{ $periode->tanggal_selesai }}</td>
                                <td>Rp {{ number_format($periode->anggaran_periode, 2, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-warning editPeriodeBtn" data-id="{{ $periode->id }}">Edit</button>
                                    <form action="{{ route('admin.periode.destroy', $periode->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus periode ini?')">Hapus</button>
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

<!-- Modal -->
<div class="modal fade" id="periodeModal" tabindex="-1" aria-labelledby="periodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="periodeModalLabel">{{ __('admin.Form Periode') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form id="periodeForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="formMethod">
                    <div class="form-group">
                        <label for="nama_periode">{{ __('admin.Nama Periode') }}</label>
                        <input type="text" class="form-control" name="nama_periode" id="nama_periode" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai">{{ __('admin.Tanggal Mulai') }}</label>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai">{{ __('admin.Tanggal Selesai') }}</label>
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="anggaran_periode">{{ __('admin.Anggaran Periode') }}</label>
                        <input type="number" class="form-control" name="anggaran_periode" id="anggaran_periode" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Simpan') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#createPeriodeBtn').on('click', function() {
        $('#periodeModal').modal('show');
        $('#periodeForm')[0].reset();
        $('#formMethod').val('POST');
        $('#periodeForm').attr('action', '{{ route('admin.periode.store') }}');
    });

    $('.editPeriodeBtn').on('click', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/admin/periode/${id}/edit`,
            method: 'GET',
            success: function(response) {
                console.log(response); // Debugging
                $('#periodeModal').modal('show');
                $('#nama_periode').val(response.nama_periode);
                $('#tanggal_mulai').val(response.tanggal_mulai);
                $('#tanggal_selesai').val(response.tanggal_selesai);
                $('#anggaran_periode').val(response.anggaran_periode);
                $('#formMethod').val('PUT');
                $('#periodeForm').attr('action', `/admin/periode/${id}`);
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr.responseText);
            }
        });
    });



    $('#periodeForm').on('submit', function(e) {
        e.preventDefault();
        const actionUrl = $(this).attr('action');
        const method = $('#formMethod').val();
        $.ajax({
            url: actionUrl,
            method: method,
            data: $(this).serialize(),
            success: function(response) {
                $('#periodeModal').modal('hide');
                location.reload(); // Refresh halaman setelah sukses
            },
            error: function(xhr) {
                console.error('Error saving data:', xhr.responseText);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
});
</script>
@endsection
