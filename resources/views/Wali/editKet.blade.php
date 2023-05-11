@extends('Layouts.app')

@section('content')
<script>
    document.title = "Edit Keterangan Sholat"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Keterangan Sholat</h1>
            @if(Auth::user() -> level == 'admin')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('sholat.showKelas') }}">Absen Sholat</a>
                </div>
                <div class="breadcrumb-item active"><a href="{{ route('desc.getDataSiswa', ['id_kelas' => $id_kelas]) }}">Data Murid
                        {{$kelas}}</a></div>
                <div class="breadcrumb-item"><a>Edit Keterangan Sholat</a></div>
            </div>
            @elseif(Auth::user() -> level == 'tu')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('tu.sholat.showKelas') }}">Absen Sholat</a>
                </div>
                <div class="breadcrumb-item active"><a href="{{ route('tu.desc.getDataSiswa', ['id_kelas' => $id_kelas]) }}">Data Murid
                        {{$kelas}}</a></div>
                <div class="breadcrumb-item"><a>Edit Keterangan Sholat</a></div>
            </div>
            @elseif(Auth::user() -> level == 'wali')
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('wali.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('wali.sholat.showKelas') }}">Absen Sholat</a>
                </div>
                <div class="breadcrumb-item active"><a href="{{ route('wali.desc.getDataSiswa', ['id_kelas' => $id_kelas]) }}">Data Murid
                        {{$kelas}}</a></div>
                <div class="breadcrumb-item"><a>Edit Keterangan Sholat</a></div>
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
                <form method="POST" action="{{ route('wali.desc.updateKeterangan', ['id_murid' => $id_murid, 'id_kelas' => $id_kelas]) }}" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>{{$nama}}</h4>
                        <div class="card-header-form">
                            <input type="date" class="form-control" id="tgl" name="tgl" value="{{ $tgl }}">
                        </div>
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
                            <label class="col-sm-3 col-form-label">Keterangan Sholat</label>
                            <div class="col-sm-9">
                                @if($data != null)
                                <input type="text" class="form-control" id="ket" name="ket" placeholder="Isi Keterangan Sholat" value="{{$ket}}">
                                @endif
                                @if($data == null)
                                <input type="text" class="form-control" id="ket" name="ket" placeholder="Data Absen Sholat Tidak Ada" readonly>
                                @endif
                                @error('ket')
                                <div class="invalid-feedback">
                                    Terdapat Kesalahan Pada Kolom Nama
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if($data != null)
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" id="submitButton" name="submitButton">Submit</button>
                    </div>
                    @else
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" id="submitButton" name="submitButton" disabled>Submit</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tgl').on('change', function() {
            var date = $(this).val();

            $.ajax({
                url: '{{ route("wali.desc.getKeterangan") }}',
                data: {
                    id_kelas: '{{ $id_kelas }}',
                    id_murid: '{{ $id_murid }}',
                    date: date
                },
                type: "POST",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.keterangan) {
                        $('#ket').val(response.keterangan.description);
                        $('#ket').removeAttr('readonly');
                        $('#submitButton').attr('disabled', false);
                    } else {
                        $('#ket').val('Data Absen Sholat Tidak Ada');
                        $('#ket').attr('readonly', true);
                        $('#submitButton').attr('disabled', true);
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });
    });
</script>
@endpush