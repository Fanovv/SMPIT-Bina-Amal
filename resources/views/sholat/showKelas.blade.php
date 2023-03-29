@extends('Layouts.app')

@section('content')
<script>
    document.title = "Absen Sholat"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Absen Sholat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a>Absen Sholat</a></div>
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
                    <h4>Absen Sholat</h4>
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
                                <a href="{{ route('sholat.absenSholat',['id_kelas' => $data->id]) }}" class="btn btn-primary btn-lg btn-round">
                                    LIHAT KELAS
                                </a>
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