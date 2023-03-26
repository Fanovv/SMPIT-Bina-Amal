@extends('Layouts.app')

@section('content')
<script>
document.title = "Edit Murid"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Murid</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.manageUser') }}">Management Murid</a></div>
                <div class="breadcrumb-item"><a>Edit Murid</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form method="POST"
                    action="{{ route('student.updateStudent', ['id_murid' => $id_murid, 'id_kelas' => $id_murid]) }}"
                    class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Edit Murid</h4>
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
                            <label class="col-sm-3 col-form-label">Nama Murid</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Murid"
                                    value="{{ $data -> nama }}">
                                @error('nama')
                                <div class="invalid-feedback">
                                    Terdapat Kesalahan Pada Kolom Nama
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nomor Induk Siswa</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nis" name="nis"
                                    placeholder="Nomor Induk Siswa" value="{{ $data -> nis }}">
                                @error('nis')
                                <div class="invalid-feedback">
                                    Terdapat Kesalahan Pada Kolom Email
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kelas</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Kelas">
                                @error('kelas')
                                <div class="invalid-feedback">
                                    Terdapat Kesalahan Pada Kolom Email
                                </div>
                                @enderror
                            </div>
                        </div> -->
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

@push('scripts')
<script>
</script>
@endpush