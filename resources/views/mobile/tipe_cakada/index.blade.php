@extends('mobile.frontend.layout.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    {{-- BREADCRUMBS --}}
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    SIKADSIS
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Calon Kepala Daerah</li>
                </ul>
            </div>
        </div>
    </div>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!-- SweetAlert Success -->
            @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
            @endif

            <!-- Cek validasi error -->
            @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ implode(', ', $errors->all()) }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
            @endif

            <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalCakada">
                Tambah Tipe Cakada
            </button>

            <!-- Modal Tambah/Edit Tipe Cakada -->
            <div class="modal fade" id="modalCakada" tabindex="-1" aria-labelledby="modalCakadaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCakadaLabel">Tambah / Edit Tipe Cakada</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formCakada" method="POST">
                                @csrf
                                <input type="hidden" id="method" name="_method" value="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Tipe Cakada</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="submitButton">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Tipe Cakada -->
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tipeCakada as $tipe)
                    <tr>
                        <td>{{ $tipe->id }}</td>
                        <td>{{ $tipe->name }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Tipe Cakada actions">
                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalCakada"
                                    data-id="{{ $tipe->id }}"
                                    data-name="{{ $tipe->name }}">
                                    Edit
                                </button>
                                <form action="{{ route('tipe_cakada.destroy', $tipe->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus tipe ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('modalCakada');
        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');

            var modalTitle = modal.querySelector('.modal-title');
            var inputName = modal.querySelector('#name');
            var form = modal.querySelector('#formCakada');
            var methodInput = modal.querySelector('#method');
            var submitButton = modal.querySelector('#submitButton');

            if (id) {
                modalTitle.textContent = 'Edit Tipe Cakada';
                inputName.value = name;
                form.action = '/tipe-cakada/' + id;
                methodInput.value = 'PUT';
                submitButton.textContent = 'Update';
            } else {
                modalTitle.textContent = 'Tambah Tipe Cakada';
                inputName.value = '';
                form.action = '{{ route('tipe_cakada.store') }}';
                methodInput.value = 'POST';
                submitButton.textContent = 'Tambah';
            }
        });
    });
</script>
@endsection
