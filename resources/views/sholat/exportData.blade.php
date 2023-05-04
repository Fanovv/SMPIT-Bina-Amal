@extends('Layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.css" />
@endpush

@section('content')
<script>
    document.title = "Export Data"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Export Data</h1>
            @if(Auth::user() -> level == 'admin')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('student.showKelas') }}">Management Murid</a>
                </div>
                <div class="breadcrumb-item">Export Data</div>
            </div>
            @elseif(Auth::user() -> level == 'tu')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('tu.student.showKelas') }}">Management Murid</a>
                </div>
                <div class="breadcrumb-item">Export Data</div>
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
                    <h4>Export Data</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table" id="table-1">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->month_year }} / {{ $item->month_year + 1 }}</td>
                                    <td>
                                        @if(Auth::user() -> level == 'admin')
                                        <form action="{{ route('sholat.exportAllData', ['tahun' => $item->month_year]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-icon icon-left btn-success export-btn" onclick="return confirm('Data yang di download akan terhapus dalam 2 tahun lagi')"><i></i>Export
                                                Data</a></button>
                                        </form>
                                        @elseif(Auth::user() -> level == 'tu')
                                        <form action="{{ route('tu.sholat.exportAllData', ['tahun' => $item->month_year]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-icon icon-left btn-success export-btn" onclick="return confirm('Data yang di download akan terhapus dalam 2 tahun lagi')"><i></i>Export
                                                Data</a></button>
                                        </form>
                                        @endif
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