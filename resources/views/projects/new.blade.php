@extends('adminlte::page')
@section('title', 'Projects')
@section('content_header')
    <div class="pt-1"></div>
@stop
@section('content')
    <div class="card card-default mt-4">
        <div class="card-header">
            <h2 class="text-primary">Create new Project</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('project.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="content active dstepper-block">
                    <div class="form-group">
                        <x-input-label for="name" :value="__('Project Name')" />
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
                    <div class="form-group col-3">
                        <x-input-label for="finish_date" :value="__('Finish Date')" />
                        <x-text-input id="finish_date" class="form-control datepicker-input" type="date"
                            name="finish_date" value="{{ old('finish_date') }}" required autofocus
                            autocomplete="finish_date" />
                        <x-input-error :messages="$errors->get('finish_date')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end mt-4 pt-3">
                        <input type="hidden" name="status" value="open" />
                        <x-primary-button class="btn btn-primary">
                            {{ __('Save Project') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
