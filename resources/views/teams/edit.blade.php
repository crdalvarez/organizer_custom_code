@extends('adminlte::page')
@section('title', 'Projects')
@section('content_header')
    <section class="content-header">
    </section>
@stop
@can('update', $team)
    @section('content')
        <div class="card" id="app">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="text-primary">Update {{ $team->name }}</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('team.show', ['team' => $team->id]) }}" class="btn btn-primary m-1">View</a>
                    </div>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="bg-white p-4 rounded-md shadow-md mb-1 col-12">
                                <form method="POST" action="{{ route('team.create') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')

                                    <div class="pt-3">
                                        <label for="name" class="form-label">{{ __('Team Name') }}</label>
                                        <input id="name" class="form-control" type="text" name="name"
                                            value="{{ old('name') ?? $team->name }}" required autofocus autocomplete="name">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="pt-3">
                                        <label for="description" class="form-label">{{ __('Description') }}</label>
                                        <input id="description" class="form-control" type="text" name="description"
                                            value="{{ old('description') ?? $team->description }}" required autofocus
                                            autocomplete="description">
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="pt-3">
                                        <label for="details" class="form-label">{{ __('Details') }}</label>
                                        <textarea id="details" name="details" class="form-control" placeholder="{{ $team->details }}" required autofocus
                                            autocomplete="details" rows="4">{{ $team->details }}</textarea>
                                        @error('details')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <input type="hidden" name="id" value="{{ $team->id }}" />
                                        <button type="submit" class="btn btn-primary me-4">{{ __('Update Team') }}</button>
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
    @stop
@endcan
