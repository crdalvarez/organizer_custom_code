@extends('adminlte::page')

@section('title', 'Clients')
@section('content_header')
    <h1>New Client</h1>
@stop

@section('content')
    <div class="card card-default mt-4">
        <div class="card-header">
            <h3 class="card-title">Create new Client</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('client.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="content active dstepper-block">
                    <div class="form-group">
                        <x-input-label for="name" :value="__('Client Name')" />
                        <x-text-input id="name" class="form-control" type="text" name="name"
                            value="{{ old('name') }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-input id="description" class="form-control" type="text" name="description"
                            value="{{ old('description') }}" required autofocus autocomplete="description" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <x-input-label for="details" :value="__('Details')" />
                        <textarea id="details" class="form-control" name="details" value="{{ old('details') }}"
                            placeholder="Details of this task... " required autofocus autocomplete="details"
                            class="resize-none border rounded-md w-full h-24 px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        </textarea>
                        <x-input-error :messages="$errors->get('details')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end mt-4 pt-3">
                        <x-primary-button class="btn btn-primary">
                            {{ __('Save Client') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
