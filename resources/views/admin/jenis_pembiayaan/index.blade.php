@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Jenis Pembiayaan') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <button class="btn btn-primary" id="createAgamaBtn" data-toggle="modal" data-target="#createModal">
                        <i class="fas fa-plus"></i> {{ __('admin.Create new') }}
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablePembiayaan">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pembiayaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenisPembiayaan as $pembiayaan)
                                <tr>
                                    <td>{{ $pembiayaan->id }}</td>
                                    <td>{{ $pembiayaan->nama_pembiayaan }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditPembiayaan" data-id="{{ $pembiayaan->id }}">
                                            Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.jenis-pembiayaan.destroy', $pembiayaan->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus?')">
                                                Hapus
                                            </button>
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

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Jenis Pembiayaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.jenis-pembiayaan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_pembiayaan">Nama Pembiayaan</label>
                            <input type="text" name="nama_pembiayaan" class="form-control" required>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="modalEditPembiayaan" tabindex="-1" aria-labelledby="modalEditPembiayaanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPembiayaanLabel">Edit Jenis Pembiayaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditPembiayaan" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_nama_pembiayaan">Nama Pembiayaan</label>
                            <input type="text" id="edit_nama_pembiayaan" name="nama_pembiayaan" class="form-control"
                                required>
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

    @push('scripts')
        <script>
            $("#tablePembiayaan").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }],
                "order": [
                    [0, 'desc']
                ]
            });

            $('#modalEditPembiayaan').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');

                // Fetch data pembiayaan
                $.get(`/admin/jenis-pembiayaan/${id}/edit`, function(data) {
                    $('#edit_nama_pembiayaan').val(data.nama_pembiayaan);

                    // Update form action
                    $('#formEditPembiayaan').attr('action', `/admin/jenis-pembiayaan/${id}`);
                });
            });
        </script>
    @endpush
@endsection
