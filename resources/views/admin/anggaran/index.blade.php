@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Anggaran') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-header-actions">
                <button class="btn btn-primary" id="createAgamaBtn" data-toggle="modal" data-target="#modalTambahAnggaran">
                    <i class="fas fa-plus"></i> {{ __('admin.Create new') }}
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tableAnggaran">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tim</th>
                            <th>Total Anggaran</th>
                            <th>Jumlah Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggarans as $anggaran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $anggaran->tim->name }}</td>
                                <td>Rp {{ number_format($anggaran->total_anggaran, 2) }}</td>
                                <td>{{ $anggaran->jumlah_periode }}</td>
                                <td>
                                    <!-- Tombol Edit Anggaran -->
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEditAnggaran" data-id="{{ $anggaran->id }}">
                                        Edit
                                    </button>
                                    <!-- Tombol Hapus Anggaran -->
                                    <form action="{{ route('admin.anggaran.destroy', $anggaran->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-item">Hapus</button>
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

<!-- Modal Tambah Anggaran -->
<div class="modal fade" id="modalTambahAnggaran" tabindex="-1" aria-labelledby="modalTambahAnggaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.anggaran.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAnggaranLabel">Tambah Anggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tim_id" class="form-label">Tim</label>
                        <select name="tim_id" id="tim_id" class="form-control" required>
                            <option value="">Pilih Tim</option>
                            @foreach($tims as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_anggaran" class="form-label">Total Anggaran</label>
                        <input type="number" name="total_anggaran" id="total_anggaran" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_periode" class="form-label">Jumlah Periode</label>
                        <input type="number" name="jumlah_periode" id="jumlah_periode" class="form-control" required>
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

<!-- Modal Edit Anggaran -->
<div class="modal fade" id="modalEditAnggaran" tabindex="-1" aria-labelledby="modalEditAnggaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditAnggaran" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditAnggaranLabel">Edit Anggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_tim_id" class="form-label">Tim</label>
                        <select name="tim_id" id="edit_tim_id" class="form-control" required>
                            <option value="">Pilih Tim</option>
                            @foreach($tims as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_total_anggaran" class="form-label">Total Anggaran</label>
                        <input type="number" name="total_anggaran" id="edit_total_anggaran" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah_periode" class="form-label">Jumlah Periode</label>
                        <input type="number" name="jumlah_periode" id="edit_jumlah_periode" class="form-control" required>
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

@endsection

@push('scripts')
<script>
        $("#tableAnggaran").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2]
            }],
            "order": [
                [0, 'asc']
            ]
        });


    $('#modalEditAnggaran').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        $.get(`/admin/anggaran/${id}/edit`, function (data) {
            $('#edit_tim_id').val(data.tim_id);
            $('#edit_total_anggaran').val(data.total_anggaran);
            $('#edit_jumlah_periode').val(data.jumlah_periode);

            $('#formEditAnggaran').attr('action', `/admin/anggaran/${id}`);
        });
    });
</script>
@endpush
