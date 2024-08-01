@extends('adminlte::page')
@section('title', 'Project')
@section('content_header')
    <section class="mt-1">
        @if ($task->status == 'closed')
            <div class="callout callout-danger">
                <h1 class="text-danger">This Task is closed. Can't be updated.</h1>
            </div>
        @endif
    </section>
@stop
@can('update', $task)
    @section('content')
        <div class="card" id="app">
            <div class="card-header ">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="text-primary">{{ $task->name }}</h2>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right">
                            <a class="btn btn-primary m-2" href="{{ route('task.show', $task->id) }}">Return to {{ $task->name }}</a>
                            <a class="btn btn-primary m-2" href="{{ route('project.show', $task->stage->project->id) }}">Go to {{ $task->stage->project->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="col-12 col-md-12 order-2 order-md-1 ">
                                    <task-status parent-id="{{ $task->stage->project->id }}" element-id="{{ $task->id }}">
                                    </task-status>
                                    <div class="container mx-auto p-4 w-1/2">
                                        <div class="bg-white p-4 rounded-md shadow-md mb-1 flex items-center">
                                            <form method="POST" action="{{ route('task.update', $task->id) }}" enctype="multipart/form-data" class="w-full">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <x-input-label for="name" :value="__('Task Name')" />
                                                    <x-text-input id="name" class="form-control" type="text"
                                                        name="name" value="{{ old('name') ?? $task->name }}" required
                                                        autofocus autocomplete="name" />
                                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                </div>
                                                <div class="form-group">
                                                    <x-input-label for="description" :value="__('Description')" />
                                                    <x-text-input id="description" class="form-control" type="text"
                                                        name="description"
                                                        value="{{ old('description') ?? $task->description }}" required
                                                        autofocus autocomplete="description" />
                                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                                </div>
                                                <div class="form-group">
                                                    <x-input-label for="details" :value="__('Details')" />
                                                    <textarea id="details" name="details" placeholder={{ $task->details }} required autofocus autocomplete="Details"
                                                        class="form-control">
                                                    {{ $task->details }}
                                                </textarea>
                                                    <x-input-error :messages="$errors->get('details')" />
                                                </div>
                                                <div class="form-group">
                                                    <x-input-label for="start_date" :value="__('Start Date')" />
                                                    <x-text-input id="start_date" class="form-control datepicker-input"
                                                        type="date" name="start_date"
                                                        value="{{ old('start_date') ?? $task->start_date }}" required autofocus
                                                        autocomplete="start_date" />
                                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                                </div>
                                                <div class="form-group">
                                                    <x-input-label for="finish_date" :value="__('Finish Date')" />
                                                    <x-text-input id="finish_date" class="form-control datepicker-input"
                                                        type="date" name="finish_date"
                                                        value="{{ old('finish_date') ?? $task->finish_date }}" required
                                                        autofocus autocomplete="finish_date" />
                                                    <x-input-error :messages="$errors->get('finish_date')" class="mt-2" />
                                                </div>
                                                @if ($task->status !== 'closed')
                                                    <div class="flex items-center justify-end mt-4 pt-3">
                                                        <input type="hidden" name="responsible_id" value="{{ $task->responsible_id }}" />                                                    
                                                        <input type="hidden" name="task_id" value="{{ $task->id }}" />
                                                        <x-primary-button class="btn btn-primary">
                                                            {{ __('Save Task') }}
                                                        </x-primary-button>
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Project Details
                                </h3>
                            </div>
                            <div class="card-body">
                                <p>
                                    <span class="text-primary text-lg">Project: </span>
                                    <span class="pl-3 text-lg"><a href="{{ route('project.show', $task->stage->project->id) }}">{{ $task->stage->project->name }}</a></span>
                                </p>
                                <p>
                                    <span class="text-primary text-lg">Project Leader: </span>
                                    <span class="pl-3">{{ $task->stage->project->user->name }}
                                        {{ $task->stage->project->user->lastname }}</span>
                                </p>
                                <p>
                                    <span class="text-primary text-lg">Description:</span>
                                    <span class="pl-3">{{ $task->stage->project->description }} </span>
                                </p>
                                <p>
                                    <span class="text-primary text-lg">Details:</span>
                                    <span class="pl-3">{{ $task->stage->project->details }}</span>
                                </p>
                                <p>
                                    <span class="text-primary text-lg">Teams:</span>
                                    @foreach ($task->stage->project->teams as $team)
                                        {{ $team->name }}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('css')
        <style>
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