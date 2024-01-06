<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wyntale Analyse</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

<div class="container p-5">

    <div class="card rounded-0">
        <div class="card-body">

            <form action="{{ route('api.v1.file.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="yamlFiles">Télécharger les fichiers YAML</label>
                    <input type="file" class="form-control-file" id="yamlFiles" name="files[]" multiple>
                </div>
                <button type="submit" class="btn btn-primary btn-sm rounded-0">Analyser</button>
            </form>
        </div>
    </div>

    <div class="card rounded-0 mt-5">
        <div class="card-header d-flex flex-column">
            <span class="h4">Résultats de l'Analyse</span>
            <small>Nombre de fichiers: {{ $files ?? 0 }}</small>
        </div>
        <div class="card-body">
            @if (isset($analysis))
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 215px"></th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Moyenne</th>
                            <th>Médiane</th>
                            <th>Min</th>
                            <th>Max</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($analysis as $item => $data)
                            <tr>
                                <td>
                                    <img src="{{ asset("storage/images/wyntale/" . strtolower($data['info'][0]). ".png") }}"
                                         alt="img">
                                    <img src="{{ asset("storage/images/wyntale/" . strtolower($data['info'][1]). ".png") }}"
                                         alt="img">

                                </td>
                                <td>{!! $data['name'] !!}</td>
                                <td>{{ $data['total'] }}</td>
                                <td>{{ number_format($data['mean'], 2) }}</td>
                                <td>{{ number_format($data['median'], 2) ?? 'N/A' }}</td>
                                <td>{{ $data['min'] }}</td>
                                <td>{{ $data['max'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>


</body>
</html>
