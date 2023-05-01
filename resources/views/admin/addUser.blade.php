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
                <div class="breadcrumb-item active"><a href="{{ route('admin.manageUser') }}">Management User</a></div>
                <div class="breadcrumb-item"><a>Tambah User</a></div>
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
                <form method="POST" action="{{ route('user.store') }}" class="needs-validation" novalidate="">
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
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama User"
                                    required>
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
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email User" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="input-group col-sm-9">
                                <input type="password" id="pwd" class="form-control" name="password"
                                    placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fa fa-eye" style="cursor:pointer"></span>
                                    </div>
                                </div>
                                @error('password')
                                <div class="invalid-feedback">
                                    What's your name?
                                </div>
                                @enderror
                            </div>
                        </div>
                        <fieldset class="form-group">
                            <div class="row">
                                <div class="col-form-label col-sm-3 pt-0">Jenis Akun</div>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="level" id="tu" value="tu">
                                        <label class="form-check-label" for="tu">
                                            Tata Usaha
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="level" id="wali"
                                            value="wali">
                                        <label class="form-check-label" for="wali">
                                            Wali Kelas/Wali Asrama
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
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