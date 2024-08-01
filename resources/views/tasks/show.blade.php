@extends('adminlte::page')
@section('title', 'Project')
@section('content_header')
    <section class="mt-1">
    </section>
@stop
@can('view', $data->module)
    @section('content')
        <div class="card" id="app">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="text-primary">{{ $data->module->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('project.show', $data->module->stage->project->id) }}"
                                class="btn btn-primary mr-3">Return to Project {{ $data->module->stage->project->name }}</a>
                            @if (!($data->module->status == 'closed' || $data->module->stage->project->status == 'closed'))
                                <a href="{{ route('task.edit', $data->module->id) }}" class="btn btn-primary mr-3">Edit</a>
                                <button onclick="deleteTask({{ $data->module->id }}, {{ $data->module->stage->project->id }})"
                                    class="btn btn-danger mr-3">Delete</button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-right mb-4 pr-3">
                                        <div class="text-gray-700 pr-2 pt-4 ">
                                            <span class="text-md text-primary">Created At: {{ $data->module->created_at }}, by
                                                <a href="{{ route('profile.show', $data->module->user->id) }}">
                                                    {{ $data->module->user->name }} {{ $data->module->user->lastname }}
                                                </a>

                                            </span>
                                            <br>
                                            <task-status parent-id="{{ $data->module->stage->project->id }}"
                                                element-id="{{ $data->module->id }}">
                                            </task-status>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-right mb-4 pr-4">
                                        <div class="mt-3 text-right">
                                            <span class="text-lg mt-3">
                                                <span class="text-gray">In Charge: </span><br>
                                                <a href="{{ route('profile.show', $data->module->responsible->id) }}">
                                                    {{ $data->module->responsible->name }}
                                                    {{ $data->module->responsible->lastname }}
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-12 order-2 order-md-1">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-sm-6">
                                                    <div class="border rounded p-3 text-right w-100">
                                                        <label class="fw-bold">Priority:</label>
                                                        @if ($data->module->priority == 'Low')
                                                            <span class="btn btn-primary ml-4 pl-3 pr-3 text-md">
                                                            @elseif ($data->module->priority == 'Medium')
                                                                <span class="btn btn-warning ml-4 pl-3 pr-3 text-md">
                                                                @elseif ($data->module->priority == 'High')
                                                                    <span class="btn btn-danger ml-4 pl-3 pr-3 text-md">
                                                                    @else
                                                                        <span class="btn btn-primary ml-4 pl-3 pr-3 text-md">
                                                        @endif
                                                        {{ $data->module->priority }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="border rounded p-3">
                                                        @if ($data->module->status !== 'closed')
                                                            <form method="post" action="{{ route('task.progress.update') }}"
                                                                class="d-flex justify-content-end">
                                                                @csrf
                                                                <div class="w-100 block ">
                                                                    <select name="progress" class="form-control">
                                                                        @foreach ($data->module->allProgress as $allProgress)
                                                                            <option
                                                                                {{ $data->module->progress === $allProgress->value ? 'selected' : '' }}>
                                                                                {{ $allProgress->value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="block text-right">
                                                                    <input type="hidden" name="task"
                                                                        value="{{ $data->module->id }}" />
                                                                    <button class="btn btn-primary ml-1"
                                                                        type="submit">Update</button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <div class=" d-flex justify-content-end">
                                                                <label class="fw-bold">Progress: </label>
                                                                <span
                                                                    class="btn btn-primary ml-4 pl-3 pr-3 text-md">{{ $data->module->progress }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-6">
                                                    <div class="border rounded p-3">
                                                        <label class="fw-bold">Start Date:</label>
                                                        <span class="text-primary pl-4 text-lg">{{ $data->module->start_date }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="border rounded p-3 text-right">
                                                        <label class="fw-bold">Finish Date:</label>
                                                        <span
                                                            class="text-primary pl-4 text-lg">{{ $data->module->finish_date }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border rounded p-3 mb-3">
                                                <div class="row pl-3 pt-1 pb-1">
                                                    <div class="col-3 font-medium text-primary">
                                                        Name
                                                    </div>
                                                    <div class="col-9">
                                                        {{ $data->module->name }}</div>
                                                </div>
                                                <div class="row pl-3 pt-1 pb-1">
                                                    <div class="col-3 font-medium text-primary">
                                                        Description
                                                    </div>
                                                    <div class="col-9 ">
                                                        {{ $data->module->description }}</div>
                                                </div>
                                                <div class="row pl-3 pt-1 pb-1">
                                                    <div class="col-3 font-medium text-primary">Details
                                                    </div>
                                                    <div class="col-9">
                                                        {{ $data->module->details }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4 sm:p-4 bg-white border-top border-gray-50 mt-5">
                                            <div class="w-full">
                                                @can('update', $data->module)
                                                    @include('comments.new')
                                                @endcan
                                                @can('view', $data->module)
                                                    @include('comments.show')
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            </div>
                            <div class="col-12">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <time-tracker-button element_id="{{ $data->module->id }}"
                            element_type="{{ @get_class($data->module) }}"
                            status="{{ $data->module->status }}"></time-tracker-button>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Project Details
                                </h3>
                            </div>
                            <div class="card-body">
                                <p>
                                    <span class="text-primary text-lg">Project Name: </span>
                                    <span class="pl-3">
                                        <a class="text-lg" href="{{ route('project.show', ['project' => $data->module->stage->project->id]) }}">
                                            {{ $data->module->stage->project->name }}
                                        </a>
                                    </span>
                                </p>
                                <p>
                                    <span class="text-primary text-lg">Project Leader: </span>
                                    <span class="pl-3">{{ $data->module->stage->project->user->name }}
                                        {{ $data->module->stage->project->user->lastname }}</span>
                                </p>
                                <p>
                                    <span class="text-primary text-lg">Description:</span>
                                    <span class="pl-3">{{ $data->module->stage->project->description }}</span>
                                </p>
                                <p>
                                    <span class="text-primary text-lg">Details:</span>
                                    <span class="pl-3">{{ $data->module->stage->project->details }}</span>
                                </p>
                                <p>
                                    <span class="text-primary text-lg">Teams:</span>
                                    @foreach ($data->module->stage->project->teams as $team)
                                        <span class="pl-3"><a
                                                href="/team/{{ $team->id }}">{{ $team->name }}</a></span>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <to-do element="{{ @class_basename($data->module) }}" element_id="{{ $data->module->id }}"
                            status="{{ $data->module->status }}">
                        </to-do>
                        @include('tasks.partials.files')
                    </div>
                </div>
            </div>
        </div>
        @vite('resources/js/app.js')
    @stop

    @section('js')
        <script>
            function deleteTask(id, projectId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure you want to delete this Task?.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                        axios.post('{{ route('task.delete') }}', {
                                id: id
                            })
                            .then(response => {
                                if (response.status === 200) {
                                    var redirectTo = "{{ route('project.show', ['project' => '__PROJECT_ID__']) }}".replace('__PROJECT_ID__', projectId);
                                    location.href = redirectTo;

                                } else {
                                    throw new Error('Failed to delte task');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete this task. Please try again later.',
                                    'error'
                                );
                            });
                    }
                });
            }
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var buttons = document.querySelectorAll('.btn-toggle');

                buttons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        buttons.forEach(function(btn) {
                            if (btn !== button) {
                                btn.classList.remove('active');
                            }
                        });
                        button.classList.add('active');
                    });
                });
            });
        </script>
    @stop

    @section('css')
        <style>
            .timeline-line {
                border: none;
                height: 2px;
                background-color: #ccc;
            }

            .form-check-inline {
                margin-bottom: 0;
            }

            .form-check-input {
                margin-top: 0.25rem;
            }

            .form-check-label {
                display: block;
            }

            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
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
                right: 0;
                bottom: 0;
                background-color: #21C396F3;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
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

            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }
        </style>
    @stop
@endcan
