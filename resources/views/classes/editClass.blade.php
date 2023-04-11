@extends('Layouts.app')

@section('content')
<script>
document.title = "Edit Kelas"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Kelas</h1>
            <div class="section-header-breadcrumb">
                @if(Auth::user() -> level == 'admin')
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('classes.manageClass') }}">Management Kelas</a>
                </div>
                <div class="breadcrumb-item"><a>Edit Kelas</a></div>
                @elseif(Auth::user() -> level == 'tu')
                <div class="breadcrumb-item active"><a href="{{ route('tu.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('tu.classes.manageClass') }}">Management Kelas</a>
                </div>
                <div class="breadcrumb-item"><a>Edit Kelas</a></div>
                @endif
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form method="POST"
                    action="@if(Auth::user() -> level == 'admin') {{ route('classes.updateClasses', ['id' => $id]) }} @elseif(Auth::user() -> level == 'tu') {{ route('tu.classes.updateClasses', ['id' => $id]) }} @endif"
                    class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Edit Kelas</h4>
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
                            <label class="col-sm-3 col-form-label">Class Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="class_name" name="class_name"
                                    placeholder="Nama Kelas" value="{{ $data->class_name }}">
                                @error('class_name')
                                <div class="invalid-feedback">
                                    What's your name?
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Wali</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="wali_1" name="wali_1"
                                    placeholder="Nama Wali" value="{{ $wali_1 }}">
                                @error('wali_1')
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                                @enderror
                            </div>
                        </div>
                        @if($wali_2 == null)
                        <div class="form-group row" style="text-align: center;" id="plus">
                            <label class="col-sm-12 col-form-label" style="font-size: 20px;">Tambah
                                Wali 2</label>
                            <div class="col-sm-12">
                                <span class="fa fa-plus" id="plus-icon" style="font-size:35px; cursor:pointer;"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="minus" style="display:none">
                            <label class="col-sm-3 col-form-label">Nama Wali 2</label>
                            <div class="input-group col-sm-9">
                                <input type="text" class="form-control" id="wali_2" name="wali_2"
                                    placeholder="Nama Wali 2">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fa fa-minus" id="minus-icon"
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
                        @endif
                        @if($wali_2 != null)
                        <div class="form-group row" style="text-align: center; display:none;" id="plus">
                            <label class="col-sm-12 col-form-label" style="font-size: 20px;">Tambah
                                Wali 2</label>
                            <div class="col-sm-12">
                                <span class="fa fa-plus" id="plus-icon" style="font-size:35px; cursor:pointer;"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="minus">
                            <label class="col-sm-3 col-form-label">Nama Wali 2</label>
                            <div class="input-group col-sm-9">
                                <input type="text" class="form-control" id="wali_2" name="wali_2"
                                    placeholder="Nama Wali 2" value="{{ $wali_2 }}">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fa fa-minus" id="minus-icon"
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
                        @endif
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
    $("#plus-icon").click(function() {
        $("#plus").hide();
        $("#minus").attr('style', '');
    });

    $("#minus-icon").click(function() {
        $("#plus").show();
        $("#minus").attr('style', 'display:none');
        var getValue = document.getElementById("wali_2");
        if (getValue.value != "") {
            getValue.value = "";
        }
    });
});
</script>
@endpush