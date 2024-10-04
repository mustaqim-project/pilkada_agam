<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role & Permission Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Manajemen Role dan Permission</h1>

        <!-- Menampilkan pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form untuk menambah Role -->
        <div class="card mt-4">
            <div class="card-header">Tambah Role</div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="role_name" class="form-label">Nama Role</label>
                        <input type="text" class="form-control" id="role_name" name="role_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Role</button>
                </form>
            </div>
        </div>

        <!-- Form untuk menambah Permission -->
        <div class="card mt-4">
            <div class="card-header">Tambah Permission</div>
            <div class="card-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="permission_name" class="form-label">Nama Permission</label>
                        <input type="text" class="form-control" id="permission_name" name="permission_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Permission</button>
                </form>
            </div>
        </div>

        <!-- Form untuk menghubungkan Permission ke Role -->
        <div class="card mt-4">
            <div class="card-header">Hubungkan Permission ke Role</div>
            <div class="card-body">
                <form action="{{ route('roles.assign-permissions') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Pilih Role</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Pilih Permissions</label>
                        <select class="form-control" id="permissions" name="permissions[]" multiple required>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Permission ke Role</button>
                </form>
            </div>
        </div>

        <!-- Menampilkan Roles dan Permissions -->
        <div class="card mt-4">
            <div class="card-header">Roles dan Permissions</div>
            <div class="card-body">
                @foreach($roles as $role)
                    <div class="mb-4">
                        <h5>{{ $role->name }}</h5>
                        <ul>
                            @foreach($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
