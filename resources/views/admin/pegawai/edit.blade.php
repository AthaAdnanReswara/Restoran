@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
<div class="container mt-4">

<div class="card shadow-sm">
    <div class="card-header bg-warning">
        <h5>✏️ Edit Pegawai</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $pegawai->name }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ $pegawai->email }}" required>
            </div>

            <div class="mb-3">
                <label>Password (opsional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary">Kembali</a>
                <button class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>

</div>
@endsection
