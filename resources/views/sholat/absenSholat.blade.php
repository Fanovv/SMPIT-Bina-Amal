@extends('Layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.css" />
@endpush

@section('content')
<script>
    document.title = "Absen Sholat {{ $kelas }}"
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Absen Sholat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('sholat.showKelas') }}">Absen Sholat</a>
                </div>
                <div class="breadcrumb-item">Absen Murid {{$kelas}}</div>
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
                    <h4>Absen Sholat</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table" id="table-1">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Subuh</th>
                                    <th>Dzuhur</th>
                                    <th>Ashar</th>
                                    <th>Maghrib</th>
                                    <th>Isya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $nama[$index] }}</td>
                                    <td>{{ $kelas }}</td>
                                    <td><a id="subuh" href="#" class="btn {{ $item->subuh ? 'btn-success' : 'btn-danger' }} prayer-button" data-id="{{ $item->id }}" data-value="{{ $item->subuh ? 1 : 0 }}">{{ $item->subuh ? 'Absen' : 'Belum Absen' }}</a>
                                    </td>
                                    <td><a id="zuhur" href="#" class="btn {{ $item->zuhur ? 'btn-success' : 'btn-danger' }} prayer-button" data-id="{{ $item->id }}" data-value="{{ $item->zuhur ? 1 : 0 }}">{{ $item->zuhur ? 'Absen' : 'Belum Absen' }}</a>
                                    </td>
                                    <td><a id="ashar" href="#" class="btn {{ $item->ashar ? 'btn-success' : 'btn-danger' }} prayer-button" data-id="{{ $item->id }}" data-value="{{ $item->ashar ? 1 : 0 }}">{{ $item->ashar ? 'Absen' : 'Belum Absen' }}</a>
                                    </td>
                                    <td><a id="maghrib" href="#" class="btn {{ $item->maghrib ? 'btn-success' : 'btn-danger' }} prayer-button" data-id="{{ $item->id }}" data-value="{{ $item->maghrib ? 1 : 0 }}">{{ $item->maghrib ? 'Absen' : 'Belum Absen' }}</a>
                                    </td>
                                    <td><a id="isya" href="#" class="btn {{ $item->isya ? 'btn-success' : 'btn-danger' }} prayer-button" data-id="{{ $item->id }}" data-value="{{ $item->isya ? 1 : 0 }}">{{ $item->isya ? 'Absen' : 'Belum Absen' }}</a>
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
        // Define the AJAX function to update the database
        function updateDatabase(id, value, button) {
            $.ajax({
                url: '{{ route("sholat.updateSholat") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    value: value,
                    button: button.attr('id')
                },
                success: function(response) {
                    console.log();
                    if (response.success == true) {
                        if (value == 1) {
                            button.removeClass('btn-danger').addClass('btn-success').text('Absen');
                        } else {
                            button.removeClass('btn-success').addClass('btn-danger').text(
                                'Belum Absen');
                        }
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        }

        $('#table-1').dataTable();

        // Attach the click event handler to each button
        $('a.prayer-button').on('click', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            var value = $(this).data('value');
            var button = $(this);

            // Call the AJAX function to update the database
            updateDatabase(id, value, button);
        });

        // setTimeout(function() {
        //     $('#table-1').DataTable().ajax.reload(null, false);
        // }, 500);
    });
</script>
@endpush