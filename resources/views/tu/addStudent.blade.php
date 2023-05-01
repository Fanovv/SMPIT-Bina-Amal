@extends('Layouts.app')

@section('content')
<script>
document.title = "Tambah Murid"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Murid</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('tu.student.showKelas') }}">Management Murid</a>
                </div>
                <div class="breadcrumb-item"><a>Tambah Murid</a></div>
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
                <form method="POST" action="{{ route('tu.student.AddStudent') }}" class="needs-validation"
                    novalidate="">
                    @csrf
                    <div class="card-header">
                        <h4>Tambah Murid</h4>
                        <div class="card-header-action">
                            @if(Auth::user() -> level == 'admin')
                            <a href="{{ route('student.showImport') }}" class="btn btn-success">
                                Import Data
                            </a>
                            @elseif(Auth::user() -> level == 'tu')
                            <a href="{{ route('tu.student.showImport') }}" class="btn btn-success">
                                Import Data
                            </a>
                            @endif
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
                            <label class="col-sm-3 col-form-label">Nama Murid</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Murid"
                                    required>
                                @error('nama')
                                <div class="invalid-feedback">
                                    What's your name?
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nomor Induk Siswa</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nis" name="nis"
                                    placeholder="Nomor Induk Siswa" required>
                                <div id="error_nis">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Kelas</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Nama Kelas"
                                    required>
                                @error('kelas')
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" style="text-align: center; display:none;" id="plus">
                            <label class="col-sm-12 col-form-label" style="font-size: 20px;">Tambah
                                Wali</label>
                            <div class="col-sm-12">
                                <span class="fa fa-plus" id="plus-icon" style="font-size:35px; cursor:pointer;"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="minus" style="display:none">
                            <label class="col-sm-3 col-form-label">Nama Wali 1</label>
                            <div class="input-group col-sm-9">
                                <input type="text" class="form-control" id="wali_1" name="wali_1"
                                    placeholder="Nama Wali 1">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fa fa-minus" id="minus-icon"
                                            style="cursor:pointer"></span>
                                    </div>
                                </div>
                                @error('wali_1')
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" style="text-align: center; display:none;" id="plus-2">
                            <label class="col-sm-12 col-form-label" style="font-size: 20px;">Tambah
                                Wali 2</label>
                            <div class="col-sm-12">
                                <span class="fa fa-plus" id="plus-icon-2"
                                    style="font-size:35px; cursor:pointer;"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="minus_2" style="display:none">
                            <label class="col-sm-3 col-form-label">Nama Wali 2</label>
                            <div class="input-group col-sm-9">
                                <input type="text" class="form-control" id="wali_2" name="wali_2"
                                    placeholder="Nama Wali 2">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fa fa-minus" id="minus-icon-2"
                                            style="cursor:pointer"></span>
                                    </div>
                                </div>
                                @error('wali_2')
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" id="tambah-button">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function() {

    $('#nis').mask("00.00.00.00.00000");
    $('#nis').blur(function() {
        var nis = $('#nis').val();
        if (nis === '') {
            $('#error_nis').html('').removeClass('invalid-feedback valid-feedback');
            $('#nis').removeClass('is-invalid is-valid');
            $('#tambah-button').attr('disabled', false);
        } else {
            $.ajax({
                url: "{{ route('tu.student.checkNIS') }}",
                method: "POST",
                data: {
                    nis: nis,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.exists) {
                        $('#error_nis').html('Nomor Induk Siswa Sudah Terpakai').addClass(
                            'invalid-feedback').removeClass('valid-feedback');
                        $('#nis').addClass('is-invalid').removeClass('is-valid');
                        $('#tambah-button').attr('disabled', 'disabled');
                    } else {
                        $('#error_nis').html('Nomor Induk Siswa Belum Terpakai').addClass(
                            'valid-feedback').removeClass('invalid-feedback');
                        $('#nis').addClass('is-valid').removeClass('is-invalid');
                        $('#tambah-button').attr('disabled', false);
                    }
                }
            });
        }
    });

    $('#kelas').on('input', function() {
        var kelas = $(this).val();
        $.ajax({
            url: '{{ route("tu.student.checkKelas") }}',
            method: 'POST',
            data: {
                kelas: kelas,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.exists) {
                    $('#plus').hide();
                    $("#minus").attr('style', 'display:none');
                    $("#minus_2").attr('style', 'display:none');
                } else {
                    $('#plus').show();
                }

            }
        });
    });

    $("#plus-icon").click(function() {
        $("#plus").hide();
        $("#plus-2").show();
        $("#minus").attr('style', '');
    });

    $("#plus-icon-2").click(function() {
        $("#plus-2").hide();
        $("#minus_2").attr('style', '');
    });

    $("#minus-icon").click(function() {
        $("#plus").show();
        $("#plus-2").hide();
        $("#minus").attr('style', 'display:none');
        $("#minus_2").attr('style', 'display:none');
        var getValue = document.getElementById("wali_2");
        if (getValue.value != "") {
            getValue.value = "";
        }
    });

    $("#minus-icon-2").click(function() {
        $("#plus-2").show();
        $("#minus_2").attr('style', 'display:none');
        var getValue = document.getElementById("wali_2");
        if (getValue.value != "") {
            getValue.value = "";
        }
    });
});
</script>
@endpush