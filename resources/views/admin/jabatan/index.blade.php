@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Jabatan Management') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <button class="btn btn-primary" id="createJabatanBtn" data-toggle="modal" data-target="#jabatanModal">
                        <i class="fas fa-plus"></i> {{ __('admin.Create new') }}
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableJabatan">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jabatans as $jabatan)
                                <tr>
                                    <td>{{ $jabatan->id }}</td>
                                    <td>{{ $jabatan->name }}</td>
                                    <td>
                                        {{-- <button class="btn btn-warning editJabatanBtn"
                                            data-id="{{ $jabatan->id }}">Edit</button> --}}


                                        <a href="#" data-toggle="modal"
                                            data-target="#editJabatanBtn{{ $jabatan->id }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>


                                        <a href="{{ route('admin.jabatan.destroy', $jabatan->id) }}"
                                            class="btn btn-danger delete-item">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>


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
    <div class="modal fade" id="jabatanModal" tabindex="-1" role="dialog" aria-labelledby="jabatanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jabatanModalLabel">{{ __('admin.Jabatan Form') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="jabatanForm" action="" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="POST" id="formMethod">
                        <div class="form-group">
                            <label for="name" class="form-label">{{ __('admin.Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
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
            $("#tableJabatan").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2]
                }],
                "order": [
                    [0, 'desc']
                ]
            });

            $('#createJabatanBtn').on('click', function() {
                $('#jabatanModal').modal('show');
                $('#jabatanForm')[0].reset();
                $('#formMethod').val('POST');
                $('#jabatanForm').attr('action', '{{ route('admin.jabatan.store') }}');
            });

            $('.editJabatanBtn').on('click', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/admin/jabatan/${id}/edit`,
                    method: 'GET',
                    success: function(response) {
                        $('#jabatanModal').modal('show');
                        $('#name').val(response.data.name);
                        $('#formMethod').val('PUT');
                        $('#jabatanForm').attr('action', `/admin/jabatan/${id}`);
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                    }
                });
            });

            $('#jabatanForm').on('submit', function(e) {
                e.preventDefault();
                const actionUrl = $(this).attr('action');
                const method = $('#formMethod').val();
                $.ajax({
                    url: actionUrl,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#jabatanModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error saving data:', xhr.responseText);
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('toast_success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('toast_success') }}'
                });
            @endif

            @if (Session::has('toast_error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('toast_error') }}'
                });
            @endif
        });
    </script>
@endsection
