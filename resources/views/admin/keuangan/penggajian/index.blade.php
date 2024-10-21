@extends('admin.layouts.master')


@section('content')
<div class="container">
    <h1>Data Penggajian</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tim</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penggajians as $index => $penggajian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penggajian->nama_tim }}</td>
                    <td>
                        <button class="btn btn-primary" onclick="toggleJabatanDropdown({{ $penggajian->id_employee }})">Lihat Jabatan</button>
                        <div id="jabatanDropdown{{ $penggajian->id_employee }}" style="display:none;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penggajians->where('id_employee', $penggajian->id_employee) as $jabatanIndex => $jabatan)
                                        <tr>
                                            <td>{{ $jabatanIndex + 1 }}</td>
                                            <td>{{ $jabatan->nama_jabatan }}</td>
                                            <td>
                                                <button class="btn btn-primary" onclick="toggleEmployeeDropdown({{ $jabatan->id_employee }})">Lihat Nama Employee</button>
                                                <div id="employeeDropdown{{ $jabatan->id_employee }}" style="display:none;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Nama</th>
                                                                <th>Aksi</th>
                                                                <th>Detail</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>{{ $jabatan->nama_employee }}</td>
                                                                <td>
                                                                    {{-- <a href="{{ route('employee.edit', $jabatan->id_employee) }}" class="btn btn-warning">Edit</a>
                                                                    <form action="{{ route('employee.destroy', $jabatan->id_employee) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </form> --}}
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-info" onclick="toggleGajiDropdown({{ $jabatan->id_employee }})">Lihat Gaji</button>
                                                                    <div id="gajiDropdown{{ $jabatan->id_employee }}" style="display:none;">
                                                                        <p>Tanggal Penggajian: {{ $penggajian->tanggal_penggajian }}</p>
                                                                        <p>Jumlah: {{ number_format($penggajian->nominal, 0, ',', '.') }}</p>
                                                                        <p>Bukti Pembayaran: <img src="{{ asset('storage/' . $penggajian->bukti_pembayaran) }}" alt="Bukti Pembayaran" width="100"></p>
                                                                        <button class="btn btn-warning" onclick="toggleEditDelete({{ $penggajian->id_penggajian }})">Aksi</button>
                                                                        <div id="editDeleteDropdown{{ $penggajian->id_penggajian }}" style="display:none;">
                                                                            {{-- <a href="{{ route('penggajian.edit', $penggajian->id_penggajian) }}" class="btn btn-warning">Edit</a>
                                                                            <form action="{{ route('penggajian.destroy', $penggajian->id_penggajian) }}" method="POST" style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                                            </form> --}}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
<script>
    function toggleJabatanDropdown(id) {
        var dropdown = document.getElementById('jabatanDropdown' + id);
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    function toggleEmployeeDropdown(id) {
        var dropdown = document.getElementById('employeeDropdown' + id);
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    function toggleGajiDropdown(id) {
        var dropdown = document.getElementById('gajiDropdown' + id);
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    function toggleEditDelete(id) {
        var dropdown = document.getElementById('editDeleteDropdown' + id);
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection
@endsection
