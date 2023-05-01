@extends('Layouts.app')

@section('content')
<script>
document.title = "Import Kelas"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Import Kelas</h1>
            <div class="section-header-breadcrumb">
                @if(Auth::user() -> level == 'admin')
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('classes.manageClass') }}">Management Kelas</a>
                </div>
                <div class="breadcrumb-item active"><a href="{{ route('classes.showAddClasses') }}">Tambah Kelas</a>
                </div>
                <div class="breadcrumb-item"><a>Import Kelas</a></div>
                @elseif(Auth::user() -> level == 'tu')
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('tu.classes.manageClass') }}">Management Kelas</a>
                </div>
                <div class="breadcrumb-item active"><a href="{{ route('tu.classes.showAddClasses') }}">Tambah Kelas</a>
                </div>
                <div class="breadcrumb-item"><a>Import Kelas</a></div>
                @endif
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
                <form method="POST"
                    action="@if(Auth::user() -> level == 'admin') {{ route('classes.importExcel') }} @elseif(Auth::user() -> level == 'tu') {{ route('tu.classes.importExcel') }} @endif"
                    class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Import Kelas</h4>
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
                            <label class="col-sm-3 col-form-label">Import File</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="file_kelas" name="file_kelas" required>
                                @error('file_kelas')
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