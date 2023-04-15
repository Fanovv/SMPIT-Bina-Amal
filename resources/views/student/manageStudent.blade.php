@extends('Layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.css" />
@endpush

@section('content')
<script>
    document.title = "Data Murid {{ $kelas }}"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Management Murid</h1>
            @if(Auth::user() -> level == 'admin')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('student.showKelas') }}">Management Murid</a>
                </div>
                <div class="breadcrumb-item">Data Murid {{$kelas}}</div>
            </div>
            @elseif(Auth::user() -> level == 'tu')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('tu.student.showKelas') }}">Management Murid</a>
                </div>
                <div class="breadcrumb-item">Data Murid {{$kelas}}</div>
            </div>
            @endif
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
                    <h4>Management Murid</h4>
                    <form class="card-header-form">
                        <input type="date" class="form-control" id="tgl-selector" value="{{ $tgl }}">
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table" id="table-1">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Nomor Induk Siswa</th>
                                    <th>Kelas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $data)
                                <tr>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->nis }}</td>
                                    <td>{{ $kelas }}</td>
                                    @if(Auth::user() -> level == 'admin')
                                    <td><a href="{{ route('sholat.exportStudent', ['id' => $data->id, 'tanggal' => $tgl]) }}" class="btn btn-icon icon-left btn-success export-btn"><i class="far fa-file"></i>Export</a>
                                        <a href="{{ route('student.editStudent', ['id_kelas' => $data->kelas, 'id_murid' => $data->id]) }}" class="btn btn-icon icon-left btn-warning"><i class="far fa-edit"></i>Edit</a>
                                        <form action="{{ route('student.destroyStudent', ['id_murid' => $data->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-icon icon-left btn-danger" onclick="return confirm('Apakah Anda Benar Ingin Menghapus Data')"><i class="fas fa-times"></i>Hapus</a></button>
                                        </form>
                                    </td>
                                    @elseif(Auth::user() -> level == 'tu')
                                    <td><a href="{{ route('tu.sholat.exportStudent', ['id' => $data->id, 'tanggal' => $tgl]) }}" class="btn btn-icon icon-left btn-success export-btn"><i class="far fa-file"></i>Export</a>
                                        <a href="{{ route('tu.student.editStudent', ['id_kelas' => $data->kelas, 'id_murid' => $data->id]) }}" class="btn btn-icon icon-left btn-warning"><i class="far fa-edit"></i>Edit</a>
                                        <form action="{{ route('tu.student.destroyStudent', ['id_murid' => $data->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-icon icon-left btn-danger" onclick="return confirm('Apakah Anda Benar Ingin Menghapus Data')"><i class="fas fa-times"></i>Hapus</a></button>
                                        </form>
                                    </td>
                                    @endif
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
<script>
    $(document).ready(function() {
        $('.export-btn').on('click', function(e) {
            e.preventDefault();
            var tanggal = $('#tgl-selector').val();
            var exportUrl = $(this).attr('href').split('?')[0] + '?tanggal=' + tanggal;
            window.location.href = exportUrl;
        });

        $('#tgl-selector').on('change', function() {
            var selectedDate = new Date(this.value);
            selectedDate.setFullYear(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0);
            this.value = selectedDate.toISOString().slice(0, 10);
        });
    });
</script>
@endpush