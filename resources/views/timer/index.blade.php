@extends('adminlte::page')
@section('title', 'Time Sheet')
@section('content_header')
    <div class="ml-1">
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="text-primary">Search by:</h5>
        </div>
        <div class="card-body">
            <form method="post" action="">
                @csrf
                <div class="row">
                    <div class="col-5"></div>
                    <div class="col-1">
                        <x-input-label for="date" :value="__('Start Date')" />
                        <x-text-input id="created_at" class="form-control" type="date" name="created_at"
                            value="{{ old('created_at') }}" autofocus autocomplete="created_at" />
                        <x-input-error :messages="$errors->get('created_at')" class="mt-2" />
                    </div>
                    <div class="col-1">
                        <x-input-label for="date" :value="__('Finish Date')" />
                        <x-text-input id="finished_at" class="form-control" type="date" name="finished_at"
                            value="{{ old('finished_at') }}" autofocus autocomplete="finished_at" />
                        <x-input-error :messages="$errors->get('finished_at')" class="mt-2" />
                    </div>
                    <div class="col-2 text-left">
                        <x-input-label for="project" :value="__('Project')" />
                        <select name="project" class="form-control">
                            <option selected></option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 text-left">
                        <x-input-label for="collaborator" :value="__('Collaborator')" />
                        <select name="collaborator" class="form-control">
                            <option selected></option>
                            @foreach ($collaborators as $collaborator)
                                <option value="{{ $collaborator->id }}" @if ($collaborator->id == auth()->user()->id) selected @endif>
                                    {{ $collaborator->name }} {{ $collaborator->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-1 text-left d-flex align-items-end">
                        <button class="btn btn-primary">View</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" id="app">
        <div class="card-header">
            <h2 class="text-primary">Time Sheet</h2>
        </div>
        <div class="card-body" style="display: block;">
            <div class="row border-bottom pb-2">
                <div class="col-2 text-left font-weight-bold">Project</div>
                <div class="col-1 text-left font-weight-bold">Stage</div>
                <div class="col-1 text-left font-weight-bold">Task</div>
                <div class="col-2 text-left font-weight-bold">Time Description</div>
                <div class="col-2 text-left font-weight-bold">Start Date</div>
                <div class="col-2 text-left font-weight-bold">Finish Date</div>
                <div class="col-1 text-left font-weight-bold">Total Time</div>
                <div class="col-1 text-left font-weight-bold">Status</div>
            </div>

            @foreach ($timer as $time)
                @if (!empty($time->task))
                    <div class="row pb-2 pt-2 border-bottom">
                        <div class="col-2">
                            <a
                                href="{{ route('project.show', ['project' => $time->task->stage->project->id]) }}">{{ $time->task->stage->project->name }}</a>
                        </div>
                        <div class="col-1">
                            <a
                                href="{{ route('project.show', ['project' => $time->task->stage->project->id]) }}">{{ $time->task->stage->name }}</a>
                        </div>
                        <div class="col-1">
                            <a
                                href="{{ route('project.show', ['project' => $time->task->id]) }}">{{ $time->task->name }}</a>
                        </div>
                        <div class="col-2">
                            <a
                                href="{{ route('project.show', ['project' => $time->task->id]) }}">{{ $time->description }}</a>
                        </div>
                        <div class="col-2">
                            {{ $time->created_at }}
                        </div>
                        <div class="col-2">
                            {{ $time->finished_at }}
                        </div>
                        <div class="col-1">
                            @php
                                if ($time->finished_at != 'null') {
                                    $start_date = new dateTime($time->created_at);
                                    $finish_date = new dateTime($time->finished_at);
                                    $timeDifference = $finish_date->diff($start_date);
                                    $formattedTime = sprintf(
                                        '%02d:%02d:%02d',
                                        $timeDifference->h,
                                        $timeDifference->i,
                                        $timeDifference->s,
                                    );
                                    echo $formattedTime;
                                }
                            @endphp
                        </div>
                        <div class="col-1">
                            @if ($time->finished_at == '')
                                <span class="text-danger">In Progress</span>
                            @else
                                <span class="text-success">Concluded</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@stop

@section('css')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 30px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: -15px;
            bottom: 0;
            background-color: #21C396F3;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 10px;
            width: 10px;
            left: 5px;
            bottom: 5px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #ccc;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #ccc;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 10px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .blinking {
            animation: blink 1s infinite;
        }
    </style>
@stop
