@extends('adminlte::page')
@section('title', 'Project')
@section('content_header')
    <section class="mt-1">

    </section>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="text-primary">Collaborators</h2>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body pb-11 block pt-10">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        @foreach ($users as $user)
                            <div class="card card-widget widget-user shadow col-md-4 m-2">
                                <div class="widget-user-header bg-gray-light mt-1">
                                    <h3 class="widget-user-username"><a href="{{ route('profile.show', $user->id) }}">{{ $user->name }}</a></h3>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle profile-user-img bg-gray-light"
                                        style="width: 100px; height: 100px;" src="/storage/{{ $user->profile->image }}">
                                </div>
                                <div class="widget-user-body">
                                    <div class="text-center mt-5">
                                        <div class=""><a href="{{ route('profile.show', $user->id) }}">{{ $user->name }} {{ $user->lastname }}</a></div>
                                        <div class="pt-0"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-3 pt-4">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <a href="{{ route('profile.show', $user->id) }}" class="btn btn-primary">Visit Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
