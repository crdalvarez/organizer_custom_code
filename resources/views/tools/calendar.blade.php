@extends('adminlte::page')
@section('title', 'Calendar')
@section('plugins.')
@section('content_header')
@section('content')
    <div id="app">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="text-primary">Calendar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a class="btn btn-primary mr-2" href="/tools/calendar/listDay">Day View</a>
                            <a class="btn btn-primary mr-2" href="/tools/calendar/timeGridWeek">Week View</a>
                            <a class="btn btn-primary mr-2" href="/tools/calendar/dayGridMonth">Month View</a>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <div id='calendar'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@section('css')
    <style>
        .fc-daygrid-day {
            te background-color: #fefefe;
            border-color: gray;
        }

        .fc-daygrid-day a {
            text-decoration: none;
        }

        .fc-day-header {
            text-decoration: none;
        }

        .fc-col-header-cell-cushion,
        .fc-daygrid-day {
            background-color: #fff;
            color: #55588;
            text-decoration: none;
        }

        .fc-col-header-cell-cushion a {
            text-decoration: none;

        }
    </style>
@stop
 
@section('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'boostratp5',
                initialView: '{{ $display }}',
                eventMargin: 1,
                events: @json($event)

            });
            calendar.render();
        });
    </script>
@stop
@endsection
