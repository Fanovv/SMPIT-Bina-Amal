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
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            </div>
            @endif
            @if(session()->has('fail'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('fail') }}
                </div>
            </div>
            @endif
            <div class="card">
                <form method="POST" action="/admin/manage/user/{{ $id }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                            <div class="input-group col-sm-9">
                                <input type="password" id="pwd" class="form-control" name="password"
                                    placeholder="Password (Boleh Tidak Di isi)">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fa fa-eye" style="cursor:pointer"></span>
                                    </div>
                                </div>
                                @error('password')
                                <div class="invalid-feedback">
                                    Terdapat Kesalahan Pada Kolom Password
                                </div>
                                @enderror
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

@push('scripts')
<script>
$(document).ready(function() {
    $(".fa").bind("click", function() {

        if ($('#pwd').attr('type') == 'password') {
            $('#pwd').attr('type', 'text');
            $('.fa').removeClass('fa-eye');
            $('.fa').addClass('fa-eye-slash');
        } else if ($('#pwd').attr('type') == 'text') {
            $('#pwd').attr('type', 'password');
            $('.fa').removeClass('fa-eye-slash');
            $('.fa').addClass('fa-eye');
        }
    })
});
</script>
@endpush