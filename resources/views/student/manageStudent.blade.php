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
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('student.showKelas') }}">Management Murid</a>
                </div>
                <div class="breadcrumb-item">Data Murid {{$kelas}}</div>
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
                                    <td><a href="/admin/export-student/{{ $data->id }}?tanggal="
                                            class="btn btn-icon icon-left btn-success" id="export-btn"><i
                                                class="far fa-file"></i>Export</a>
                                        <a href="/admin/student/manage/{{ $data->kelas }}/edit/{{ $data->id }}"
                                            class="btn btn-icon icon-left btn-warning"><i
                                                class="far fa-edit"></i>Edit</a>
                                        <form action="/admin/student/manage/delete/{{ $data->id }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button class="btn btn-icon icon-left btn-danger"
                                                onclick="return confirm('Apakah Anda Benar Ingin Menghapus Data')"><i
                                                    class="fas fa-times"></i>Hapus</a></button>
                                        </form>
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
<script>
$(document).ready(function() {
    $('#export-btn').on('click', function() {
        var tanggal = $('#tgl-selector').val();
        $(this).attr('href', $(this).attr('href') + tanggal);
    });
    $('#tgl-selector').on('change', function() {
        // get the selected date
        var selectedDate = new Date(this.value);

        // set the date to the last day of the month
        selectedDate.setFullYear(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0);

        // set the value of the input to the last day of the month
        this.value = selectedDate.toISOString().slice(0, 10);
    });
});
</script>
@endpush