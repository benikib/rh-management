<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $reportData['title'] ?? 'Rapport RH' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; margin: 0; padding: 0; }
        .page { padding: 24px; }
        .header { margin-bottom: 18px; }
        .title { font-size: 24px; font-weight: 700; margin-bottom: 8px; }
        .subtitle { color: #4b5563; font-size: 12px; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 14px; font-weight: 700; margin-bottom: 10px; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #e5e7eb; padding: 8px 10px; text-align: left; font-size: 11px; }
        th { background: #f8fafc; }
        .small { font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div class="title">{{ $reportData['title'] ?? 'Rapport RH' }}</div>
        <div class="subtitle">Période : {{ $filters['start_date'] ?? '' }} à {{ $filters['end_date'] ?? '' }}</div>
        <div class="subtitle">Type : {{ ucfirst($filters['report_type'] ?? 'présence') }}</div>
    </div>

    <div class="section">
        <div class="section-title">Résumé</div>
        <table>
            <tbody>
                @foreach($reportData['meta'] as $key => $value)
                    <tr>
                        <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                        <td>{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(! empty($reportData['details']))
        <div class="section">
            <div class="section-title">Détails</div>
            <table>
                <thead>
                    <tr>
                        @foreach(array_keys((array) $reportData['details'][0]) as $column)
                            <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData['details'] as $detail)
                        <tr>
                            @foreach((array) $detail as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(! empty($reportData['criteria']))
        <div class="section">
            <div class="section-title">Scores par critère</div>
            <table>
                <thead>
                    <tr>
                        @foreach(array_keys((array) $reportData['criteria'][0]) as $column)
                            <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData['criteria'] as $item)
                        <tr>
                            @foreach((array) $item as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(! empty($reportData['ranking']))
        <div class="section">
            <div class="section-title">Classement des employés</div>
            <table>
                <thead>
                    <tr>
                        @foreach(array_keys((array) $reportData['ranking'][0]) as $column)
                            <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData['ranking'] as $item)
                        <tr>
                            @foreach((array) $item as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
</body>
</html>
