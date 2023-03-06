@extends('Layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.css" />
@endpush

@section('content')
<script>
    document.title = "Management User"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Management User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Management User</div>
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
                    <h4>Management User</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.addUser') }}" class="btn btn btn-success">Tambah Akun</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table" id="table-1">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jenis User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $data)
                                <tr>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->email }}</td>
                                    @if ($data->level == 'admin')
                                    <td>
                                        Admin
                                    </td>
                                    @endif
                                    @if ($data->level == 'wali')
                                    <td>
                                        Wali Kelas/Wali Asrama
                                    </td>
                                    @endif
                                    <td><a href="/admin/manage/user/{{ $data->id }}/edit" class="btn btn-icon icon-left btn-warning"><i class="far fa-edit"></i>Edit</a>
                                        @if ($data->level == 'wali')
                                        <!-- <a href="/admin/manage/delete/{{ $data -> id }}"
                                            class="btn btn-icon icon-left btn-danger" onclick="return confirm('Apakah Anda Benar Ingin Menghapus Data')"><i
                                                class="far fa-edit"></i>Edit</a> -->
                                        <form action="/admin/manage/delete/{{ $data -> id }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-icon icon-left btn-danger" onclick="return confirm('Apakah Anda Benar Ingin Menghapus Data')"><i class="fas fa-times"></i>Hapus</a></button>
                                        </form>
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
@endpush