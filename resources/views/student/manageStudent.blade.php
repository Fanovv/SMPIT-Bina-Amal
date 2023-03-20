@extends('Layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.css" />
@endpush

@section('content')
<script>
    document.title = "Management Students"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Management Students</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Management Students</div>
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
                <div class="card-header">
                    <h4>Management Students</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.addStudents') }}" class="btn btn btn-success">Tambah Siswa</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($data as $data)
                <div class="col-lg-2 col-md-9 col-9 col-sm-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center pt-1 pb-1">
                                <h4>{{ $data->class_name }}</h4>
                                <br></br>
                                <a href="/admin/class/{{ $data->id }}/edit" class="btn btn-primary btn-lg btn-round">
                                    EDIT
                                </a>
                                <br></br>
                                <form action="/admin/class/delete/{{ $data -> id }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-lg btn-round" onclick="return confirm('Apakah Anda Benar Ingin Menghapus Data')"><i></i>DELETE</a></button>
                                </form>
                                <!-- <a href="#" class="btn btn-danger btn-lg btn-round">
                                    DELETE
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

@endsection