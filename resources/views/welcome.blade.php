@php use App\Http\Controllers\SchoolHolidayController; @endphp
    <!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description"
          content="Sind heute Ferien? Finde heraus, in welchen deutschen Bundesländern heute Schulferien sind. Einfach, aktuell und übersichtlich."/>
    <meta name="keywords"
          content="Ferien heute, Schulferien, Bundesländer, Deutschland, Ferienkalender, Ferienübersicht"/>
    <meta name="author" content="SindHeuteFerien.de"/>
    <title>Sind heute Ferien?</title>
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
        }

        .info p {
            font-size: 1.1rem;
            color: #333;
        }

        .state-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .state {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .state h3 {
            margin: 0.5rem 0;
        }

        .holiday-yes {
            color: #16a34a;
            font-weight: bold;
        }

        .holiday-no {
            color: #dc2626;
            font-weight: bold;
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
    </style>
</head>
<body>
<header>
    <h1>Sind heute Ferien?</h1>
    <p>Hier findest du auf einen Blick, in welchen Bundesländern heute Schulferien sind.</p>
</header>
<main>

    <section class="info">
        <p>Heute ist der {{ date('d.m.Y') }}.</p>
        <p>Hier siehst du, in welchen Bundesländern heute Schulferien sind:</p>
    </section>

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
        @foreach($bundeslaender as $kuerzel => $land)
            <div class="state">
                <h3>
                    <a href="{{ route('bundesland', $land['route']) }}">
                        {{ $land['name'] }}
                    </a>
                </h3>
                @if(SchoolHolidayController::areTodayHolidays($kuerzel))
                    @php $holidayEnd = SchoolHolidayController::holidaysEndInDays($kuerzel); @endphp
                    <p class="holiday-yes">Ja, heute sind Ferien!
                        @if($holidayEnd)
                            <br><br>Die {{$holidayEnd['holiday_name']}}
                            {{ $holidayEnd['days'] == 0 ? 'enden heute' :
           ($holidayEnd['days'] == 1 ? 'enden morgen' :
           'enden in ' . $holidayEnd['days'] . ' Tagen') }}
                            ({{ $holidayEnd['start_date'] }} - {{ $holidayEnd['end_date'] }})
                        @endif
                    </p>
                @else
                    @php $nextHoliday = SchoolHolidayController::getDaysToNextHolidays($kuerzel); @endphp
                    <p class="holiday-no">Nein, heute sind keine Ferien.
                        @if($nextHoliday)
                            <br><br>Aber
                            in {{$nextHoliday['days']}} {{ $nextHoliday['days'] === 1 ? 'Tag beginnen' : 'Tagen beginnen' }}
                            die {{$nextHoliday['holiday_name']}}
                            ({{$nextHoliday['start_date']}} - {{$nextHoliday['end_date']}})
                        @else
                            <br>Wir laden gerade die nächsten Ferientermine...
                        @endif
                    </p>
                @endif
            </div>
        @endforeach
    </div>
    <section title="Schulferien heute – hat mein Bundesland heute frei?">
        <h2>Schulferien heute – hat mein Bundesland heute frei?</h2>
        <p>Auf sindheuteferien.de findest du schnell und unkompliziert heraus, ob heute in deinem Bundesland Schulferien
            sind. Perfekt für Eltern, Schüler/innen und Lehrer/innen, die wissen möchten, ob heute schulfrei ist oder
            wie weit die nächsten Ferien noch entfernt sind.</p>
    </section>

    <section title="Wie erkennt sindheuteferien.de, ob heute Ferien sind?">
        <h2>Wie erkennt sindheuteferien.de, ob heute Ferien sind?</h2>
        <p>Wir erhalten die Schulferienpläne aller Bundesländer aus einer zuverlässigen Quelle und stellen sie dir hier
            übersichtlich dar. So kannst du auf einen Blick sehen, ob heute Ferien sind oder nicht.</p>
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
