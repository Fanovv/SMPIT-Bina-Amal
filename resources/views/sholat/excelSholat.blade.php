<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                @if($nama_kelas != null)
                <th>{{ $nama }} ({{ $nama_kelas }})</th>
                @endif
                @if($nama_kelas == null)
                <th>{{ $nama }}</th>
                @endif
            </tr>
            <tr>
                <th>No</th>
                @if($siswa != null)
                <th>Nama Siswa</th>
                @endif
                @if($kelas != null)
                <th>Nama Kelas</th>
                @endif
                <th>Tanggal</th>
                <th>Subuh</th>
                <th>Dzuhur</th>
                <th>Ashar</th>
                <th>Maghrib</th>
                <th>Isya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                @if($siswa != null)
                <td>{{ $data -> nama }}</td>
                @endif
                @if($kelas != null)
                <td>{{ $data -> class_name }}</td>
                @endif
                <td>{{ date('d-F-Y', strtotime($data->date)) }}</td>
                @if($data->subuh == 1)
                <td>Tepat Waktu</td>
                @else
                <td>Masbuk/Telat</td>
                @endif
                @if($data->zuhur == 1)
                <td>Tepat Waktu</td>
                @else
                <td>Masbuk/Telat</td>
                @endif
                @if($data->ashar == 1)
                <td>Tepat Waktu</td>
                @else
                <td>Masbuk/Telat</td>
                @endif
                @if($data->maghrib == 1)
                <td>Tepat Waktu</td>
                @else
                <td>Masbuk/Telat</td>
                @endif
                @if($data->isya == 1)
                <td>Tepat Waktu</td>
                @else
                <td>Masbuk/Telat</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>