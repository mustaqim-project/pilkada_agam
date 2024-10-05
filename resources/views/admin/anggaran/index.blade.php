@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Anggaran</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#anggaranModal" id="createAnggaran">Tambah Anggaran</button>

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
                <td>{{ number_format($anggaran->total_anggaran, 2) }}</td>
                <td>{{ $anggaran->jumlah_periode }}</td>
                <td>
                    <button class="btn btn-warning editAnggaran" data-id="{{ $anggaran->id }}" data-bs-toggle="modal" data-bs-target="#anggaranModal">Edit</button>
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
<div class="modal fade" id="anggaranModal" tabindex="-1" aria-labelledby="anggaranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="anggaranModalLabel">Anggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="anggaranForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="id" id="anggaranId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tim_id">Tim</label>
                        <select name="tim_id" id="tim_id" class="form-control" required>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Untuk form create
    document.getElementById('createAnggaran').addEventListener('click', function () {
        document.getElementById('anggaranForm').reset();
        document.getElementById('methodField').value = 'POST';
        document.getElementById('anggaranId').value = '';
    });

    // Untuk form edit
    document.querySelectorAll('.editAnggaran').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            fetch(`/admin/anggaran/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('anggaranId').value = data.id;
                    document.getElementById('tim_id').value = data.tim_id;
                    document.getElementById('total_anggaran').value = data.total_anggaran;
                    document.getElementById('jumlah_periode').value = data.jumlah_periode;
                    document.getElementById('methodField').value = 'PUT';
                });
        });
    });
</script>

@endsection
