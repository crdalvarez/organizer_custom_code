@extends('adminlte::page')
@section('title', 'Teams')
@section('content_header')
    <section class="mt-1">
    </section>
@stop

@section('content')
    @can('create', \App\Models\Team::class)
        <div class="card" id="app">
            <div class="card-header">
                <h2 class="text-primary">Team Details</h2>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="bg-white p-4 rounded-md shadow-md mb-1 col-12">
                                <form method="POST" action="{{ url('team') }}" enctype="multipart/form-data" class="w-full">
                                    @csrf

                                    <div class="row">
                                        <div class="col-6 col-lg-6 col-sm-12">
                                        </div>
                                        <div class="col-6 col-lg-6 col-sm-12">
                                            <x-input-label for="leader" :value="__('Team Leader')" class="text-primary" />
                                            <select name="leader_id" class="w-100 bg-white border rounded form-control-lg">
                                                @foreach ($users as $user)
                                                    <option class="bg-white" value="{{ $user->id }}">{{ $user->name }}
                                                        {{ $user->lastname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="name" :value="__('Team Name')" />
                                        <x-text-input id="name" class="form-control mt-1" type="text" name="name"
                                            value="{{ old('name') }}" required autofocus autocomplete="name" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="description" :value="__('Description')" />
                                        <x-text-input id="description" class="form-control mt-1" type="text"
                                            name="description" value="{{ old('description') }}" required autofocus
                                            autocomplete="description" />
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="details" :value="__('Details')" />
                                        <textarea id="details" name="details" placeholder="Details of this Team..." required autofocus autocomplete="details"
                                            class="form-control"></textarea>
                                        <x-input-error :messages="$errors->get('details')" class="mt-2" />
                                    </div>
                                    <div class="d-flex justify-content-end mt-4 pt-3">
                                        <input type="submit" class="btn btn-primary" value="Add new Team" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">  
                    </div>
                </div>
            </div>
        </div>
    @endcan
@stop
