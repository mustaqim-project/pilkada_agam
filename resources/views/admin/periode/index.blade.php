@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Periode Anggaran') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                        Tambah Periode
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablePeriode">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periodes->groupBy('anggaran.tim.name') as $timName => $timPeriods)
                                <tr>
                                    <td colspan="2">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapse{{ $loop->index }}" aria-expanded="false"
                                            aria-controls="collapse{{ $loop->index }}">
                                            {{ $timName }}
                                        </button>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#editTimModal" data-tim="{{ $timName }}">
                                                Edit Tim
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="collapse{{ $loop->index }}" class="collapse">
                                    <td colspan="3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Periode</th>
                                                    <th>Tanggal Mulai</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Anggaran Periode</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($timPeriods as $periode)
                                                    <tr>
                                                        <td>{{ $periode->nama_periode }}</td>
                                                        <td>{{ $periode->tanggal_mulai }}</td>
                                                        <td>{{ $periode->tanggal_selesai }}</td>
                                                        <td>Rp {{ number_format($periode->anggaran_periode, 0, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-warning"
                                                                data-toggle="modal" data-target="#editPeriodeModal"
                                                                data-id="{{ $periode->id }}">
                                                                Edit
                                                            </button>
                                                            <form
                                                                action="{{ route('admin.periode.destroy', $periode->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
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

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createPeriodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="createPeriodeForm" method="POST" action="{{ route('admin.periode.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPeriodeModalLabel">Tambah Periode</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="anggaran_id">Anggaran ID</label>
                            <select class="form-control" name="anggaran_id" id="anggaran_id" required>
                                <option value="">Pilih Anggaran</option>
                                @foreach ($anggarans as $anggaran)
                                    <option value="{{ $anggaran->id }}">
                                        {{ $anggaran->tim ? $anggaran->tim->name : 'Tim tidak ditemukan' }} -
                                        Rp {{ number_format($anggaran->total_anggaran, 0, ',', '.') }}
                                    </option>
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
                            <input type="number" class="form-control" name="anggaran_periode" id="anggaran_periode"
                                required>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="editPeriodeModal" tabindex="-1" role="dialog" aria-labelledby="editPeriodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editPeriodeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPeriodeModalLabel">Edit Periode</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="periodeId">
                        <div class="form-group">
                            <label for="edit_anggaran_id">Anggaran ID</label>
                            <select class="form-control" name="anggaran_id" id="edit_anggaran_id" required>
                                <option value="">Pilih Anggaran</option>
                                @foreach ($anggarans as $anggaran)
                                    <option value="{{ $anggaran->id }}">
                                        {{ $anggaran->tim ? $anggaran->tim->name : 'Tim tidak ditemukan' }} -
                                        Rp {{ number_format($anggaran->total_anggaran, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_nama_periode">Nama Periode</label>
                            <input type="text" class="form-control" name="nama_periode" id="edit_nama_periode"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="tanggal_mulai" id="edit_tanggal_mulai"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="tanggal_selesai" id="edit_tanggal_selesai"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_anggaran_periode">Anggaran Periode</label>
                            <input type="number" class="form-control" name="anggaran_periode"
                                id="edit_anggaran_periode" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Update Periode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $("#tablePeriode").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }],
                "order": [
                    [0, 'desc']
                ]
            });

            $('#editPeriodeModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var id = button.data('id'); // Ambil ID dari tombol

                // Fetch data periode berdasarkan ID
                $.get(`/admin/periode/${id}/edit`, function(data) {
                    $('#periodeId').val(data.id); // Set ID ke input hidden
                    $('#edit_anggaran_id').val(data.anggaran_id); // Set anggaran_id ke select
                    $('#edit_nama_periode').val(data.nama_periode); // Set nama_periode ke input
                    $('#edit_tanggal_mulai').val(data.tanggal_mulai); // Set tanggal_mulai ke input
                    $('#edit_tanggal_selesai').val(data.tanggal_selesai); // Set tanggal_selesai ke input
                    $('#edit_anggaran_periode').val(data.anggaran_periode); // Set anggaran_periode ke input

                    // Ubah action form untuk update
                    $('#editPeriodeForm').attr('action', `/admin/periode/${data.id}`);
                });
            });
        </script>
    @endpush
@endsection
