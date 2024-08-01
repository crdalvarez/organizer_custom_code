@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <section class="mt-1">

    </section>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="text-primary">Clients</h2>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body" style="display: block;">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                    <div class="row">
                        @if ($clients->isNotEmpty())
                            @foreach ($clients as $client)
                                <div class="card card-widget widget-user shadow col-md-3 m-2">
                                    <div class="widget-user-header bg-gray-light mt-1">
                                        <h3 class="widget-user-username"><a
                                                href="{{ route('client.show', $client->id) }}">{{ $client->name }}</a></h3>
                                    </div>
                                    <div class="widget-client-image text-center">
                                        <img class="img-circle profile-client-img bg-gray-light"
                                            style="width: 100px; height: 100px;" src="/storage/{{ $client->image }}">
                                    </div>
                                    <div class="widget-client-body">
                                        <div class="text-center mt-5">
                                            <div class=""><a
                                                    href="{{ route('client.show', $client->id) }}">{{ $client->name }}</a>
                                            </div>
                                            <div class="pt-0"><a
                                                    href="mailto:{{ $client->clientProfile->email }}">{{ $client->clientProfile->email }}</a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="pb-3 pt-4">
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <a href="{{ route('client.show', $client->id) }}"
                                                    class="btn btn-primary">Visit Profile</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12 col-12 h-100 text-center">
                                <h1 class="mt-5 text-gray">We can't find any clients yet.</h1>
                                <div class="mt-5 mb-5">
                                    <a href="{{ route('client.create') }}" class="btn btn-primary">Add New Client</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @stop
