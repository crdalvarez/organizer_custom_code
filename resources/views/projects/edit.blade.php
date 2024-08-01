@extends('adminlte::page')
@section('title', 'Projects')
@section('content_header')
    <div class="mt-1">
    </div>
@stop

@section('content')
    @can('update', $data->module)
        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="text-primary">{{ $data->module->name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right mt-2">
                            <a class="btn btn-primary m-2"
                                href="{{ route('project.tasks', ['project' => $data->module->id]) }}">Show Tasks</a>
                            <a class="btn btn-primary m-2"
                                href="{{ route('project.show', ['project' => $data->module->id]) }}">Project View</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-1 order-md-1 p-3">
                        <div class="row">
                            <div class="col">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="text-primary">Teams</h3>
                                @include('projects.partials.teams-show')
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <h3 class="text-primary">Add Team</h3>
                                @include('projects.partials.team-add')
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-2 order-md-2">
                        <div class="row">
                            <div class="col">
                                @include('projects.partials.project-edit')
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                @if ($data->module->clients->isEmpty())
                                    @include('projects.partials.client-add')
                                @else
                                    <h3 class="text-primary">Associated Client</h3>
                                    @foreach ($data->module->clients as $client)
                                        <span class="text-lg"><a
                                                href="{{ route('client.show', $client->id) }}">{{ $client->name }}</a></span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @include('projects.partials.project-settings')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@stop
