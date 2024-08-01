@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Chartjs', true)
@section('content_header')
    <section class="mt-0">
    </section>
@stop

@section('content')
    <div class="container-fluid" id="app">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <div class="info-box-icon bg-success">
                        <h1 class="text-white">{{ $tasks_completed }}</h1>
                    </div>
                    <div class="info-box-content">
                        <h4 class="text-success pt-2 pl-3">Completed Tasks<h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <div class="info-box-icon bg-danger">
                        <h1 class="text-white">{{ $tasks_overdue }}</h1>
                    </div>
                    <div class="info-box-content">
                        <h4 class="text-danger pt-1 pl-3">Overdue Tasks</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <div class="info-box-icon bg-warning">
                        <h1 class="text-white">{{ $tasks_active }}</h1>
                    </div>
                    <div class="info-box-content">
                        <h4 class="info-box-text text-orange">Active tasks</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <div class="info-box-icon bg-info">
                        <h1 class="info-box-icon bg-info text-white">{{ $tasks_upcomming }}</h1>
                    </div>
                    <div class="info-box-content">
                        <h4 class="info-box-text text-info">Upcomming Tasks</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <section class="col-lg-7 connectedSortable ui-sortable">
                <to-do-general></to-do-general>
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            My Tasks
                        </h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Stage</th>
                                    <th>Task</th>
                                    <th>Progress</th>
                                    <th>Finish Date</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $taskCount => $task)
                                    <tr class="hover-bg" onclick="window.location='/task/{{ $task->id }}';"
                                        style="cursor: pointer;">
                                        <td>
                                            <a href="{{ route('project.show', ['project' => $task->stage->project->id]) }}">{{ $task->stage->project->name }}</a>

                                        </td>
                                        <td>
                                            <a href="{{ route('project.show', ['project' => $task->stage->project->id]) }}">{{ $task->stage->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('task.show', ['task' => $task->id]) }}">{{ $task->name }}</a>
                                        </td>
                                        
                                        <td>{{ $task->description }}</td>
                                        <td>
                                            {{ $task->finish_date }}
                                            @if ($task->finish_date < date('Y-m-d') && $task->status == 'open')
                                                <span class="badge bg-danger ml-1">Expired</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($task->status == 'open')
                                                <span class="badge bg-success">
                                                @else
                                                    <span class="badge bg-gray">
                                            @endif
                                            {{ $task->status }}</span>
                                        </td>
                                        <td><span class="badge bg-primary">{{ $task->progress }}</span></td>
                                        <td>
                                            @switch($task->priority)
                                                @case('Low')
                                                    <span class="badge bg-success">{{ $task->priority }}</span>
                                                @break
                                                @case('Medium')
                                                    <span class="badge bg-warning">{{ $task->priority }}</span>
                                                @break
                                                @case('High')
                                                    <span class="badge bg-danger">{{ $task->priority }}</span>
                                                @break
                                                @default
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section class="col-lg-5 connectedSortable ui-sortable">
                <div class="card bg-gradient-light">
                    <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="far fa-calendar-alt"></i>
                            Calendar
                        </h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mt-5">

                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @vite('resources/js/app.js')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">

    <style>
        .hover-bg:hover {
            background-color: #f0f8ff;
        }

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
            color: #5555aa;
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
                height: 650,
                themeSystem: 'boostratp5',
                initialView: 'dayGridMonth',
                eventDisplay: 'block', 
                eventContent: function(info) {
                    return {
                        html: '<a  href="' + info.event.url + '" style="color: ' + info.event
                            .textColor + ';" title="' + info.event.title + '"><b>' + info.event.title +
                            '</b></a>'
                    };
                },
                events: @json($event)
            });
            calendar.render();
        });
    </script>
@stop

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src="{{ asset('/resources/js/app.js') }}"></script>
@endpush
