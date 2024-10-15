@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Detail Pembiayaan') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createEditModal">
                        + Detail Pembiayaan
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablePembiayaan">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pembiayaan</th> <!-- Ubah judul kolom -->
                                <th>Nama Rincian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailPembiayaan as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->jenisPembiayaan->nama_pembiayaan }}</td>
                                    <td>{{ $item->nama_rincian }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm edit-button" data-id="{{ $item->id }}"
                                            data-nama_rincian="{{ $item->nama_rincian }}"
                                            data-jenis_pembiayaan_id="{{ $item->jenis_pembiayaan_id }}"
                                            data-toggle="modal" data-target="#createEditModal">Edit</button>
                                        <form action="{{ route('admin.keuangan.detail_pembiayaan.destroy', $item->id) }}"
                                            method="POST" style="display:inline;">
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

    {{-- Add/Edit Modal --}}
    <div class="modal fade" id="createEditModal" tabindex="-1" role="dialog" aria-labelledby="createEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="createEditForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createEditModalLabel">Tambah/Edit Detail Pembiayaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="form-method" name="_method" value="POST">
                        <div class="form-group">
                            <label for="jenis_pembiayaan_id">Jenis Pembiayaan</label>
                            <input type="number" id="jenis_pembiayaan_id" name="jenis_pembiayaan_id" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="nama_rincian">Nama Rincian</label>
                            <input type="text" id="nama_rincian" name="nama_rincian" class="form-control" required>
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

@section('script')
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const successMessage = '{{ session('success') }}';
            const errorMessage = '{{ session('error') }}';

            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: successMessage,
                });
            }

            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                });
            }
        });

        // Script for Edit Modal
        $(document).on('click', '.edit-button', function() {
            const id = $(this).data('id');
            const namaRincian = $(this).data('nama_rincian');
            const jenisPembiayaanId = $(this).data('jenis_pembiayaan_id');

            // Set form action for update
            $('#createEditForm').attr('action', `/admin/keuangan/detail-pembiayaan/${id}`);
            $('#form-method').val('PUT');  // Change method to PUT

            // Set data into input fields
            $('#nama_rincian').val(namaRincian);
            $('#jenis_pembiayaan_id').val(jenisPembiayaanId);

            // Change modal title
            $('#createEditModalLabel').text('Edit Detail Pembiayaan');
        });

        // Reset form when modal is closed
        $('#createEditModal').on('hidden.bs.modal', function() {
            $('#createEditForm').trigger('reset');
            $('#createEditForm').attr('action', '{{ route('admin.keuangan.detail_pembiayaan.store') }}');  // Set back to store route
            $('#form-method').val('POST');  // Reset method to POST
            $('#createEditModalLabel').text('Tambah Detail Pembiayaan');  // Reset modal title
        });

        // DataTable
        $(document).ready(function() {
            $("#tablePembiayaan").dataTable({
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
