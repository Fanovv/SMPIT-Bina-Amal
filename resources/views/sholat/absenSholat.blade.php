@extends('Layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.css" />
@endpush

@section('content')
<script>
document.title = "Absen Sholat {{ $kelas }}"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Absen Sholat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('sholat.showKelas') }}">Absen Sholat</a>
                </div>
                <div class="breadcrumb-item">Absen Murid {{$kelas}}</div>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table" id="table-1">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Subuh</th>
                                    <th>Dzuhur</th>
                                    <th>Ashar</th>
                                    <th>Maghrib</th>
                                    <th>Isya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $data)
                                <tr>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $kelas }}</td>
                                    <td><a href="" class="btn btn-icon icon-left btn-warning"><i
                                                class="far fa-edit"></i>Absen</a>
                                    </td>
                                    <td><a href="" class="btn btn-icon icon-left btn-warning"><i
                                                class="far fa-edit"></i>Absen</a>
                                    </td>
                                    <td><a href="" class="btn btn-icon icon-left btn-warning"><i
                                                class="far fa-edit"></i>Absen</a>
                                    </td>
                                    <td><a href="" class="btn btn-icon icon-left btn-warning"><i
                                                class="far fa-edit"></i>Absen</a>
                                    </td>
                                    <td><a href="" class="btn btn-icon icon-left btn-warning"><i
                                                class="far fa-edit"></i>Absen</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">

                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('js/page/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush