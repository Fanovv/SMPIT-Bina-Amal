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
                <th>{{ $nama }}</th>
            </tr>
            <tr>
                <th>No</th>
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
                <td>{{ date('d-F-Y', strtotime($data->date)) }}</td>
                <td>{{ $data->subuh }}</td>
                <td>{{ $data->zuhur }}</td>
                <td>{{ $data->ashar }}</td>
                <td>{{ $data->maghrib }}</td>
                <td>{{ $data->isya }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>