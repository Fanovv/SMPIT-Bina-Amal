@extends('Layouts.app')

@section('content')
<script>
document.title = "Edit Profile"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Profile</h1>
            <div class="section-header-breadcrumb">
                @if(Auth::user() -> level == 'admin')
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                @endif
                @if(Auth::user() -> level == 'tu')
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                @endif
                @if(Auth::user() -> level == 'wali')
                <div class="breadcrumb-item active"><a href="{{ route('wali.dashboard') }}">Dashboard</a></div>
                @endif
                <div class="breadcrumb-item"><a>Edit Profile</a></div>
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
                <form method="POST" action="
                @if(Auth::user() -> level == 'admin') {{ route('admin.updateProfile', ['id' => $data -> id]) }} 
                @elseif(Auth::user() -> level == 'tu') {{ route('tu.updateProfile', ['id' => $data -> id]) }} 
                @elseif(Auth::user() -> level == 'wali') {{ route('wali.updateProfile', ['id' => $data -> id]) }} 
                @endif" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Edit Profile</h4>
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
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama User"
                                    value="{{ $data -> name }}">
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
                                    placeholder="Email User" value="{{ $data -> email }}">
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