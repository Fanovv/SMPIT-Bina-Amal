@extends('Layouts.app')

@section('content')
<script>
    document.title = "Import Murid"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Import Murid</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('student.showKelas') }}">Management Murid</a>
                </div>
                <div class="breadcrumb-item active"><a href="{{ route('student.showAddStudent') }}">Tambah Murid</a>
                </div>
                <div class="breadcrumb-item"><a>Import Murid</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form method="POST" action="{{ route('student.importExcel') }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Import Murid</h4>
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
                                <input type="file" class="form-control" id="file_murid" name="file_murid" required>
                                @error('file_murid')
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