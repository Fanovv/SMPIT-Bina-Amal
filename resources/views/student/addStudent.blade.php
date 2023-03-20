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
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="">Management Murid</a>
                </div>
                <div class="breadcrumb-item"><a>Tambah Murid</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form method="POST" action="{{ route('student.store') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="card-header">
                        <h4>Tambah Murid</h4>
                        <div class="card-header-action">
                            <a href="{{ route('classes.showImport') }}" class="btn btn-success">
                                Import Data
                            </a>
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
                                @error('nis')
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                                @enderror
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
$(document).ready(function() {
    $('#kelas').on('input', function() {
        var kelas = $(this).val();
        $.ajax({
            url: '{{ route("student.checkKelas") }}',
            method: 'POST',
            data: {
                kelas: kelas,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.exists) {
                    $('#plus').hide();
                } else {
                    $('#plus').show();
                }
            }
        });
    });

    $("#plus-icon").click(function() {
        $("#plus").hide();
        $("#minus").attr('style', '');
        $("#minus_2").attr('style', '');
    });

    $("#minus-icon").click(function() {
        $("#plus").show();
        $("#minus").attr('style', 'display:none');
        $("#minus_2").attr('style', 'display:none');
        var getValue = document.getElementById("wali_2");
        if (getValue.value != "") {
            getValue.value = "";
        }
    });

    $("#minus-icon-2").click(function() {
        $("#plus").show();
        $("#minus").attr('style', 'display:none');
        $("#minus_2").attr('style', 'display:none');
        var getValue = document.getElementById("wali_2");
        if (getValue.value != "") {
            getValue.value = "";
        }
    });
});
</script>
@endpush