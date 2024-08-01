@extends('adminlte::page')
@section('title', 'Projects')
@section('content_header')
    <section class="mt-1">
    </section>
@stop

@section('content')
    @can('create', $team)
        <div class="card" id="app">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h2 class="text-primary">{{ $team->name }}</h2>
                    </div>
                    @can('update', $team)
                        <div class="col-4 text-right">
                            <a class="btn btn-primary m-2" href="{{ route('team.edit', ['team' => $team->id]) }}">Edit</a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Projects</span>
                                        <h2 class="info-box-number text-center text-primary mb-0">{{ $team->project->count() }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Collaborators</span>
                                        <h2 class="info-box-number text-center text-primary mb-0">{{ $team->collaborators->count() }}
                                       
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-default" id="sections">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Leaders</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="collapse" data-target="#collapseLeadersCard"
                                        aria-controls="collapseLeadersCard">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="collapseLeadersCard">
                                <div class="card-body" style="display: block;">
                                    <div class="row">
                                        <div class="col-12">
                                            @include('teams.partials.team-leaders')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-default" id="sections">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Collaborating</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="collapse" data-target="#collapseCollaboratorsCard"
                                        aria-controls="collapseCollaboratorsCard">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="collapseCollaboratorsCard">
                                <div class="card-body" style="display: block;">
                                    <div class="row">
                                        <div class="col-12">
                                            @include('teams.partials.collaborators-show')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-default" id="sections">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Add new collaborators</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="collapse" data-target="#collapseNewCollaboratorsCard"
                                        aria-controls="collapseNewCollaboratorsCard">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="collapseNewCollaboratorsCard">
                                <div class="card-body" style="display: block;">
                                    <div class="row">
                                        <div class="col-12">
                                            @include('teams.partials.collaborators-add')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2 pt-3">
                        <h4 class="text-primary"> Description</h4>
                        <p class="text-muted">{{ $team->description }}</p>
                        <h4 class="text-primary"> Details</h4>
                        <p class="text-muted">{{ $team->details }}</p>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-primary"> Projects</h4>
                            </div>
                            <div class="card-body">
                                @foreach ($team->project as $project)
                                    <div class="row border-bottom pt-2">
                                        <div class="col-12">
                                            <a href="/project/{{ $project->id }}">{{ $project->name }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@stop
