@extends('admin.layouts.master')
@section('content')
<div class="container">
    <h1>Create Permission</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="guard_name">Guard Name</label>
            <input type="text" name="guard_name" class="form-control" value="{{ old('guard_name') }}" required>
        </div>

        <div class="form-group">
            <label for="group_name">Group Name</label>
            <input type="text" name="group_name" class="form-control" value="{{ old('group_name') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Permission</button>
    </form>
</div>
@endsection
