@php use App\Http\Controllers\SchoolHolidayController; @endphp
    <!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    @php
        $routeToKuerzel = [
            'baden-wuerttemberg' => 'bw',
            'bayern' => 'by',
            'berlin' => 'be',
            'brandenburg' => 'bb',
            'bremen' => 'hb',
            'hamburg' => 'hh',
            'hessen' => 'he',
            'mecklenburg-vorpommern' => 'mv',
            'niedersachsen' => 'ni',
            'nordrhein-westfalen' => 'nw',
            'rheinland-pfalz' => 'rp',
            'saarland' => 'sl',
            'sachsen' => 'sn',
            'sachsen-anhalt' => 'st',
            'schleswig-holstein' => 'sh',
            'thueringen' => 'th'
        ];

        $kuerzelToName = [
            'bw' => 'Baden-Württemberg',
            'by' => 'Bayern',
            'be' => 'Berlin',
            'bb' => 'Brandenburg',
            'hb' => 'Bremen',
            'hh' => 'Hamburg',
            'he' => 'Hessen',
            'mv' => 'Mecklenburg-Vorpommern',
            'ni' => 'Niedersachsen',
            'nw' => 'Nordrhein-Westfalen',
            'rp' => 'Rheinland-Pfalz',
            'sl' => 'Saarland',
            'sn' => 'Sachsen',
            'st' => 'Sachsen-Anhalt',
            'sh' => 'Schleswig-Holstein',
            'th' => 'Thüringen'
        ];

        $kuerzel = $bundesland;
        $bundeslandName = $kuerzelToName[$kuerzel] ?? 'Deutschland';
        $ferienStatus = SchoolHolidayController::areTodayHolidays($kuerzel) ? 'Ja' : 'Nein';
    @endphp

    <title>Sind heute Ferien in {{ $bundeslandName }}? {{ $ferienStatus }} - aktuelle Schulferien {{ date('Y') }}</title>
    <meta name="description"
          content="Sind heute Ferien in {{ $bundeslandName }}? {{ $ferienStatus }}! Erfahre, wann die nächsten Schulferien in {{ $bundeslandName }} beginnen oder enden. Aktuelle und zuverlässige Ferieninfos {{ date('Y') }}."/>
    <meta name="keywords"
          content="Ferien {{ $bundeslandName }}, Schulferien {{ $bundeslandName }}, {{ date('Y') }}, {{ date('Y')+1 }}, Ferienkalender, Ferienübersicht"/>
    <meta name="author" content="SindHeuteFerien.de"/>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            color: #111;
        }

        header {
            background-color: #1e40af;
            color: white;
            padding: 2rem 1rem;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        header p {
            font-size: 1.25rem;
        }

        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .info {
            text-align: center;
            margin-bottom: 2rem;
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .info p {
            font-size: 1.1rem;
            color: #333;
        }

        .info-result {
            font-size: 1.8rem !important;
            font-weight: bold;
            margin: 1.5rem 0;
        }

        .holiday-yes {
            color: #16a34a;
        }

        .holiday-no {
            color: #dc2626;
        }

        .holiday-details {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .other-states {
            margin-top: 3rem;
        }

        .state-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .state {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .state h3 {
            margin: 0.5rem 0;
        }

        footer {
            text-align: center;
            padding: 2rem 1rem;
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 600px) {
            header h1 {
                font-size: 2rem;
            }

            .info p {
                font-size: 1rem;
            }
        }

        .state a {
            color: #1a202c;
            text-decoration: none;
            transition: color 0.2s;
        }

        .state a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .state:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: #1e40af;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .holiday-calendar {
            margin: 2rem 0;
        }
    </style>
</head>
<body>
<header>
    <h1>Sind heute Ferien in {{ $bundeslandName }}?</h1>
    <p>Aktuelle Schulferien und Ferienzeiten für {{ $bundeslandName }}</p>
</header>
<main>
    <a href="/" class="back-link">← Zurück zur Übersicht</a>

    <section class="info">
        <p>Heute ist der {{ date('d.m.Y') }}</p>

        @if(SchoolHolidayController::areTodayHolidays($kuerzel))
            @php $holidayEnd = SchoolHolidayController::holidaysEndInDays($kuerzel); @endphp
            <p class="info-result holiday-yes">Ja, heute sind Ferien in {{ $bundeslandName }}!</p>

            @if($holidayEnd)
                <div class="holiday-details">
                    <h2>{{ $holidayEnd['holiday_name'] }}</h2>
                    <p>Zeitraum: <strong>{{ $holidayEnd['start_date'] }} bis {{ $holidayEnd['end_date'] }}</strong></p>
                    <p>
                        {{ $holidayEnd['days'] == 0 ? 'enden heute' :
      ($holidayEnd['days'] == 1 ? 'enden morgen' :
      'enden in ' . $holidayEnd['days'] . ' Tagen') }}
                        ({{ $holidayEnd['start_date'] }} - {{ $holidayEnd['end_date'] }})
                    </p>
                </div>
            @endif
        @else
            @php $nextHoliday = SchoolHolidayController::getDaysToNextHolidays($kuerzel); @endphp
            <p class="info-result holiday-no">Nein, heute sind keine Ferien in {{ $bundeslandName }}.</p>

            @if($nextHoliday)
                <div class="holiday-details">
                    <h2>Nächste Ferien: {{ $nextHoliday['holiday_name'] }}</h2>
                    <p>Zeitraum: <strong>{{ $nextHoliday['start_date'] }} bis {{ $nextHoliday['end_date'] }}</strong></p>
                    <p>
                        Die Ferien beginnen in {{ $nextHoliday['days'] }} {{ $nextHoliday['days'] === 1 ? 'Tag' : 'Tagen' }}
                        und dauern {{ $nextHoliday['duration'] }} Tage.
                    </p>
                </div>
            @else
                <p>Wir laden gerade die nächsten Ferientermine...</p>
            @endif
        @endif
    </section>

    <section>
        <h2>Schulferien {{ date('Y') }} in {{ $bundeslandName }}</h2>
        <p>Hier findest du alle Informationen zu den aktuellen und kommenden Schulferien in {{ $bundeslandName }}.
            Unsere Daten werden regelmäßig aktualisiert, damit du immer zuverlässige Informationen erhältst.</p>

        <p>In {{ $bundeslandName }} gibt es verschiedene Ferienarten:</p>
        <ul>
            <li>Winterferien (falls vorhanden)</li>
            <li>Osterferien / Frühlingsferien</li>
            <li>Pfingstferien (in manchen Bundesländern)</li>
            <li>Sommerferien</li>
            <li>Herbstferien</li>
            <li>Weihnachtsferien</li>
        </ul>

        <p>Die genauen Termine werden von der Kultusministerkonferenz festgelegt und können sich von Jahr zu Jahr leicht verschieben.</p>
    </section>

    <section class="other-states">
        <h2>Ferienzeiten in anderen Bundesländern</h2>
        <p>Schulferien unterscheiden sich je nach Bundesland. Hier kannst du die aktuellen Ferienzeiten für andere Bundesländer prüfen:</p>

        @php
            $bundeslaender = [
                'bw' => ['name' => 'Baden-Württemberg', 'route' => 'baden-wuerttemberg'],
                'by' => ['name' => 'Bayern', 'route' => 'bayern'],
                'be' => ['name' => 'Berlin', 'route' => 'berlin'],
                'bb' => ['name' => 'Brandenburg', 'route' => 'brandenburg'],
                'hb' => ['name' => 'Bremen', 'route' => 'bremen'],
                'hh' => ['name' => 'Hamburg', 'route' => 'hamburg'],
                'he' => ['name' => 'Hessen', 'route' => 'hessen'],
                'mv' => ['name' => 'Mecklenburg-Vorpommern', 'route' => 'mecklenburg-vorpommern'],
                'ni' => ['name' => 'Niedersachsen', 'route' => 'niedersachsen'],
                'nw' => ['name' => 'Nordrhein-Westfalen', 'route' => 'nordrhein-westfalen'],
                'rp' => ['name' => 'Rheinland-Pfalz', 'route' => 'rheinland-pfalz'],
                'sl' => ['name' => 'Saarland', 'route' => 'saarland'],
                'sn' => ['name' => 'Sachsen', 'route' => 'sachsen'],
                'st' => ['name' => 'Sachsen-Anhalt', 'route' => 'sachsen-anhalt'],
                'sh' => ['name' => 'Schleswig-Holstein', 'route' => 'schleswig-holstein'],
                'th' => ['name' => 'Thüringen', 'route' => 'thueringen']
            ];
        @endphp

        <div class="state-list">
            @foreach($bundeslaender as $k => $land)
                @if($k !== $kuerzel)
                    <div class="state">
                        <h3>
                            <a href="{{ route('bundesland', $land['route']) }}" title="Ferien in {{ $land['name'] }}">
                                {{ $land['name'] }}
                            </a>
                        </h3>
                        <p>
                            @if(SchoolHolidayController::areTodayHolidays($k))
                                <span class="holiday-yes">Heute Ferien</span>
                            @else
                                <span class="holiday-no">Keine Ferien</span>
                            @endif
                        </p>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <section>
        <h2>Häufige Fragen zu Schulferien in {{ $bundeslandName }}</h2>

        <h3>Wann beginnen die nächsten Ferien in {{ $bundeslandName }}?</h3>
        @php $nextHoliday = SchoolHolidayController::getDaysToNextHolidays($kuerzel);
 @endphp
        @if($nextHoliday)
            <p>Die nächsten Ferien in {{ $bundeslandName }} sind die {{ $nextHoliday['holiday_name'] }}.
                Sie beginnen am {{ $nextHoliday['start_date'] }} und enden am {{ $nextHoliday['end_date'] }}.</p>
        @else
            <p>Zur Zeit sind Ferien in {{ $bundeslandName }}!</p>
        @endif

        <h3>Wie lange dauern die Sommerferien in {{ $bundeslandName }}?</h3>
        <p>Die Sommerferien dauern in der Regel 6 Wochen. Die genauen Termine können von Jahr zu Jahr variieren.</p>

        <h3>Werden Feiertage zu den Schulferien gezählt?</h3>
        <p>Nein, Feiertage sind gesetzlich festgelegte freie Tage und werden separat von den Schulferien betrachtet,
            können aber in Ferienzeiten fallen.</p>
    </section>
</main>
<footer>
    &copy; 2025 SindHeuteFerien.de – Alle Angaben ohne Gewähr. Datenquelle: <a href="https://www.schulferien.org"
                                                                               target="_blank"
                                                                               rel="noopener noreferrer">schulferien.org</a>

    <a href="{{ route('impressum') }}">Impressum</a>
</footer>
</body>
</html>
