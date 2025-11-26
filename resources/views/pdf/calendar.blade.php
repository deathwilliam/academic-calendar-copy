<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Académico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h1 {
            color: #4F46E5;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 10px;
        }

        .event {
            margin-bottom: 20px;
            padding: 15px;
            border-left: 4px solid #4F46E5;
            background-color: #f9fafb;
        }

        .event-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .event-type {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .type-general {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .type-exam {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .type-holiday {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .type-meeting {
            background-color: #E9D5FF;
            color: #6B21A8;
        }

        .type-deadline {
            background-color: #FED7AA;
            color: #9A3412;
        }

        .event-description {
            color: #6B7280;
            margin-bottom: 8px;
        }

        .event-dates {
            font-size: 14px;
            color: #4B5563;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #9CA3AF;
        }
    </style>
</head>

<body>
    <h1>Calendario Académico</h1>
    <p>Eventos y fechas importantes</p>

    @if($events->count() === 0)
        <p>No hay eventos publicados.</p>
    @else
        @foreach($events as $event)
            <div class="event">
                <div class="event-title">{{ $event->title }}</div>
                <span class="event-type type-{{ $event->type }}">{{ ucfirst($event->type) }}</span>
                @if($event->description)
                    <div class="event-description">{{ $event->description }}</div>
                @endif
                <div class="event-dates">
                    <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}<br>
                    <strong>Fin:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}
                </div>
            </div>
        @endforeach
    @endif

    <div class="footer">
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>