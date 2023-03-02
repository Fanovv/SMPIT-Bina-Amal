@extends('Layouts.app')

@section('content')
<script>
document.title = "Edit User"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.manageUser') }}">Management User</a></div>
                <div class="breadcrumb-item"><a>Edit User</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form method="POST" action="/admin/manageUser/{{ $id }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Edit User</h4>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @foreach ($data as $p)
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Your Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama User"
                                    value="{{ $p -> name }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    Terdapat Kesalahan Pada Kolom Nama
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email User" value="{{ $p -> email }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    Terdapat Kesalahan Pada Kolom Email
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password">
                                @error('password')
                                <div class="invalid-feedback">
                                    Terdapat Kesalahan Pada Kolom Password
                                </div>
                                @enderror
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Tidak Harus Diisi
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                    @endforeach
                </form>
            </div>
        </div>
    </section>
</div>

@endsection