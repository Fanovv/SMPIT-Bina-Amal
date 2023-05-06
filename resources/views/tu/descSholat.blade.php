@extends('Layouts.app')

@section('content')
<script>
document.title = "Keterangan Sholat"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Keterangan Sholat</h1>
            @if(Auth::user()->level == 'admin')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a>Keterangan Sholat</a></div>
            </div>
            @elseif(Auth::user()->level == 'tu')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a>Keterangan Sholat</a></div>
            </div>
            @elseif(Auth::user()->level == 'wali')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('wali.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a>Keterangan Sholat</a></div>
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
                <form method="POST" action="{{ route('tu.updateDesc') }}" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Tambah Keterangan Sholat</h4>
                        <div class="card-header-form">
                            <input type="date" class="form-control" id="tgl" value="{{ $tgl }}" name="tgl">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kelas</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" id="kelas" name="kelas" onchange="getMurid()">
                                    <option value="">- Pilih Kelas -</option>
                                    @foreach($data as $kls)
                                    <option value="{{ $kls->id }}">{{ $kls->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Siswa</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" id="murid" name="murid">
                                    <option value="">- Pilih Siswa -</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" id="ket" name="ket"></input>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
function getMurid() {
    var kelas = document.getElementById("kelas").value;

    if (kelas != "") {
        $.ajax({
            type: "GET",
            url: '{{ route("tu.getMurid") }}',
            data: {
                kelas: kelas
            },
            success: function(response) {
                var muridSelect = document.getElementById("murid");
                muridSelect.innerHTML = "<option value=''>- Pilih Siswa -</option>";
                muridSelect.innerHTML += response;
            }
        });
    }
}
</script>
@endpush