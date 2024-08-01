@extends('adminlte::page')
@section('title', 'Client')
@section('content_header')
    <section class="mt-1">

    </section>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="img-circle profile-client-img" style="width: 200px; height: 200px;"
                                    src="/storage/{{ $client->image }}" alt="No profile picture yet.">
                            </div>
                            <h3 class="profile-username text-center text-primary">{{ $client->name }}</h3>
                            <p class="text-muted text-center">{{ $client->clientProfile->title }}</p>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fas fa-phone-alt mr-1"></i> phone</strong>
                            <p class="text-muted">{{ $client->clientProfile->phone }}</p>
                            <hr>
                            <strong><i class="fas fa-book mr-1"></i> industry</strong>
                            <p class="text-muted">
                                {{ $client->clientProfile->industry }}
                            </p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Descriptors</strong>
                            <p class="text-muted">{{ $client->clientProfile->descriptors }}</p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
                            <p class="text-muted">{{ $client->clientProfile->address }}</p>
                            <hr>
                            <strong><i class="far fa-envelope mr-1"></i> Email</strong>
                            <p class="text-muted">{{ $client->clientProfile->email }}</p>
                            <hr>
                            <strong><i class="fa-solid solid-globe mr-1"></i> Site:</strong>
                            <p class="text-muted">{{ $client->clientProfile->url }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills justify-content-end">
                                <li class="nav-item m-1"><a href="{{ route('client.edit', $client->id) }}"
                                        class="btn btn-primary">Edit</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div id="app">
                                        <h3 class="text-primary mt-4">Projects</h3>
                                        <div class="row">
                                            @if (!empty($client->project))
                                                @foreach ($client->project as $project)
                                                    <div class="col-md-3 mb-4">
                                                        <div class="card border-primary h-100 d-flex flex-column">
                                                            <div class="card-header">{{ $project->name }}</div>
                                                            <div class="card-body d-flex flex-column">
                                                                <h5 class="card-title">{{ $project->description }}</h5>
                                                                <p class="card-text flex-fill">{{ $project->details }}</p>
                                                            </div>
                                                            <div class="mt-auto text-center p-3">
                                                                <a href="/project/{{ $project->id }}"
                                                                    class="btn btn-outline-primary">View</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <hr class="mt-3 mb-3" />
                                        <h3 class="text-primary mt-4">Posts</h3>
                                        @can('update', $client)
                                            @include('comments.new')
                                        @endcan
                                        @can('view', $client)
                                            @include('comments.show')
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

