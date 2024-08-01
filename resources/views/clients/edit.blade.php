@extends('adminlte::page')
@section('title', 'Client')
@section('content_header')
    <section class="mt-1">
    </section>
@stop

@section('content')
    <div class="card card-default mt-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-primary">{{ $client->name }}</h2>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <a class="btn btn-primary m-2" href="{{ route('client.show', $client->id) }}">View Client</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST"action="{{ route('client.update', $client->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="content active dstepper-block">
                    @method('PATCH')
                    <div class="row pt-3">
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="name" :value="__('Client Name')" />
                            <x-text-input id="name" class="form-control" type="text" name="name"
                                value="{{ old('name') ?? $client->name }}" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="form-control" type="text" name="title"
                                value="{{ old('title') ?? $client->clientProfile->title }}" required autofocus
                                autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div>
                    <div class="form-group">
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-input id="description" class="form-control" type="text" name="description"
                            value="{{ old('description') ?? $client->description }}" required autofocus
                            autocomplete="description" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <x-input-label for="details" :value="__('Details')" />
                        <textarea id="details" name="details" value="{{ old('details') ?? $client->details }}"
                            placeholder={{ $client->details }}required autofocus autocomplete="details" class="form-control">
                            {{ $client->details }}
                        </textarea>
                        <x-input-error :messages="$errors->get('details')" class="mt-2" />
                    </div>
                    <div class="row pt-3">
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="industry" :value="__('Industry')" />
                            <x-text-input id="industry" class="form-control" type="text" name="industry"
                                value="{{ old('industry') ?? $client->clientProfile->industry }}" required autofocus
                                autocomplete="industry" />
                            <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                        </div>
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="descriptors" :value="__('Descriptors')" />
                            <x-text-input id="descriptors" class="form-control" type="text" name="descriptors"
                                value="{{ old('descriptors') ?? $client->clientProfile->descriptors }}" required autofocus
                                autocomplete="descriptors" />
                            <x-input-error :messages="$errors->get('descriptors')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" class="form-control" type="text" name="address"
                                value="{{ old('address') ?? $client->clientProfile->address }}" required autofocus
                                autocomplete="address" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="url" :value="__('Url')" />
                            <x-text-input id="url" class="form-control" type="text" name="url"
                                value="{{ old('url') ?? $client->clientProfile->url }}" autofocus autocomplete="url" />
                            <x-input-error :messages="$errors->get('url')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="form-control" type="email" name="email"
                                value="{{ old('email') ?? $client->clientProfile->email }}" required autofocus
                                autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" class="form-control" type="phone" name="phone"
                                value="{{ old('phone') ?? $client->clientProfile->phone }}" required autofocus
                                autocomplete="phone" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="form-group col-6 col-lg-6 col-sm-6">
                            <x-input-label for="image" :value="__('Image')" />
                            <x-text-input id="image" class="form-control" type="file" name="image"
                                value="{{ old('image') ?? $client->image }}" autofocus autocomplete="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4 pt-3">
                        <x-primary-button class="btn btn-primary">
                            {{ __('Update Client') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
