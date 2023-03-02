@extends('Layouts.app')

@section('content')
<script>
    document.title = "Tambah User"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a>Tambah User</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form method="POST" action="{{ route('admin.store') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="card-header">
                        <h4>Tambah User</h4>
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
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Your Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama User" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    What's your name?
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email User" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">
                                    What's your name?
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection