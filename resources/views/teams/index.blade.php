@extends('adminlte::page')
@section('title', 'Teams')
@section('content_header')
    <div class="mt-1"></div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="text-primary">Teams</h2>
            <div class="card-tools">
            </div>
        </div>
        @if ($teams->isEmpty())
            <div class="text-center my-5">
                <h1 class="text-gray">There is not any team created yet.</h1>
                <a href="{{ route('team.create') }}" class="btn btn-primary mt-3">Create New Team</a>
            </div>
        @else
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                        <div class="row">
                            @foreach ($teams as $team)
                                <div class="card card-widget widget-user shadow col-md-4 col-lg-3 m-2 ml-lg-5 ml-md-5">
                                    <div class="widget-user-header bg-gray-light mt-1">
                                        <h3 class="widget-user-username"><a href="{{ route('team.show', ['team' => $team->id]) }}">{{ $team->name }}</a></h3>

                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle profile-user-img bg-gray-light"
                                            style="width: 100px; height: 100px;"
                                            src="{{ asset('storage/' . $team->leader->profile->image) }}">

                                    </div>
                                    <div class="widget-user-body">
                                        <div class="text-center mt-5">
                                            <div>
                                                <a href="{{ route('profile.show', $team->leader->id) }}">{{ $team->leader->name }}
                                                    {{ $team->leader->lastname }}</a>
                                            </div>
                                            <span class="text-small text-gray">(Team Leader)</span>
                                            <p class="font-bold">
                                                <a
                                                    href="{{ route('profile.show', $team->details) }}">{{ $team->email }}</a>
                                            </p>

                                        </div>
                                        <div class="card-footer" style="padding-top: 5px;">
                                            <div class="row">
                                                <div class="col-sm-6 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header text-primary">
                                                            {{ $team->project->count() }}</h5>
                                                        <span>Projects</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header text-primary">
                                                            {{ $team->collaborators->count() }}</h5>
                                                        <span">Collaborators</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop
