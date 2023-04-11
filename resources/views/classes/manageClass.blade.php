@extends('Layouts.app')

@section('content')
<script>
    document.title = "Management Kelas"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Management Kelas</h1>
            <div class="section-header-breadcrumb">
                @if(Auth::user() -> level == 'admin')
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a>Management Kelas</a></div>
                @elseif(Auth::user() -> level == 'tu')
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a>Management Kelas</a></div>
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
                <div class="card-header">
                    <h4>Tambah Kelas</h4>
                    <div class="card-header-action">
                        @if(Auth::user() -> level == 'admin')
                        <a href="{{ route('classes.showAddClasses') }}" class="btn btn-success btn-lg btn-round">
                            Tambah Kelas
                        </a>
                        @elseif(Auth::user() -> level == 'tu')
                        <a href="{{ route('tu.classes.showAddClasses') }}" class="btn btn-success btn-lg btn-round">
                            Tambah Kelas
                        </a>
                        @endif
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
                                @if(Auth::user() -> level == 'admin')
                                <a href="{{ route('classes.editClasses', ['id' => $data -> id]) }}" class="btn btn-primary btn-lg btn-round">
                                    EDIT
                                </a>
                                <br></br>
                                <form action="{{ route('classes.destroyKelas', ['id' => $data -> id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-lg btn-round" onclick="return confirm('Apakah Anda Benar Ingin Menghapus Data')"><i></i>DELETE</a></button>
                                </form>
                                @elseif(Auth::user() -> level == 'tu')
                                <a href="{{ route('tu.classes.editClasses', ['id' => $data -> id]) }}" class="btn btn-primary btn-lg btn-round">
                                    EDIT
                                </a>
                                <br></br>
                                <form action="{{ route('tu.classes.destroyKelas', ['id' => $data -> id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-lg btn-round" onclick="return confirm('Apakah Anda Benar Ingin Menghapus Data')"><i></i>DELETE</a></button>
                                </form>
                                @endif
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