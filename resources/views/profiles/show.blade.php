@extends('adminlte::page')
@section('title', 'profiles')
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
                                @if (empty($user->profile->image))
                                    <img class="img-circle profile-user-img" style="width: 200px; height: 200px;"
                                        src="{{ asset('storage/profile/no_image.png') }}" alt="">
                                @else
                                    <img class="img-circle profile-user-img" style="width: 200px; height: 200px;"
                                        src="{{ asset('storage/' . $user->profile->image) }}" alt="">
                                @endif
                            </div>
                            <h3 class="profile-username text-center">{{ $user->name }} {{ $user->lastname }}</h3>
                            <p class="text-muted text-center">@ {{ $user->username }}</p>
                            <p class="text-muted text-center">{{ $user->profile->title }}</p>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fas fa-pencil-alt mr-1"></i> email</strong>
                            <p class="text-muted">{{ $user->email }}</p>
                            <hr>
                            <strong><i class="fas fa-book mr-1"></i> Experience</strong>
                            <p class="text-muted">
                                {{ $user->profile->experience }}
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
                            <p class="text-muted">{{ $user->profile->address }}</p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                            <p class="text-muted">{{ $user->profile->skills }}</p>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Birthdate</strong>
                            <p class="text-muted">{{ $user->profile->birthdate }}</p>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Site:</strong>
                            <p class="text-muted">{{ $user->profile->url }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header text-right p-2">
                            @can('edit', $user->profile)
                                <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div id="app">

                                        <h2 class="text-primary mt-4">Projects</h2>
                                        @include('profiles.partials.projects-show')
                                        <hr class="mt-3 mb-3" />
                                        
                                        <h2 class="text-primary mt-4">Teams</h2>
                                        @include('profiles.partials.teams-show')
                                        <hr class="mt-3 mb-3" />
                                        
                                        <h2 class="text-primary mt-4">Posts</h2>
                                        @include('profiles.partials.posts-new')
                                        @if (!empty($user->posts))
                                            @include('profiles.partials.posts-show', [
                                                'posts' => $user->posts,
                                            ])
                                        @else
                                            <div class="callout callout-info">
                                                <h3>{{ $user->username }} Hasn't made any post yet.</h3>
                                            </div>
                                        @endif
                                        
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
