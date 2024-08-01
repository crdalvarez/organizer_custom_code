@extends('adminlte::page')
@section('title', 'Profile')
@section('content_header')
    <section class="mt-1">
    </section>
@stop

@section('content')
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="w-full">
        @csrf
        @method('PATCH')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="img-circle profile-user-img" style="width: 200px; height: 200px;"
                                src="{{ asset('storage/' . $user->profile->image) }}" alt="">
                            </div>
                            <h3 class="profile-username text-center">{{ $user->name }}</h3>
                            <p class="text-muted text-center">@ {{ $user->username }}</p>
                            <p class="text-muted text-center">{{ $user->profile->title }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Project Owner</b> <a class="float-right">{{$user->projects->count()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Team Leader</b> <a class="float-right">{{$user->teams->count()}}</a>
                                </li>
                            </ul>
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
                        <div class="card-header p-2">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h2 class="text-primary">Edit Profile</h2>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <a href="{{ route('profile.show', $user->id) }}" class="btn btn-primary">Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}" type="text"
                                        required>
                                    <div class="pt-5">
                                        <x-input-label for="title" :value="__('Title')" />
                                        <x-text-input id="title" class="form-control" type="text" name="title"
                                            value="{{ old('title') ?? ($user->profile->title ?? 'N/A') }}" required
                                            autofocus autocomplete="title" />
                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="description" :value="__('Description')" />
                                        <x-text-input id="description" class="form-control" type="text"
                                            name="description"
                                            value="{{ old('description') ?? ($user->profile->description ?? 'N/A') }}"
                                            required autofocus autocomplete="description" />
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="birthdate" :value="__('Birth date')" />
                                        <x-text-input id="birthdate" class="form-control" type="date" name="birthdate"
                                            value="{{ old('birthdate') ?? ($user->profile->birthdate ?? 'N/A') }}" required
                                            autofocus autocomplete="birthdate" />
                                        <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="experience" :value="__('Experience')" />
                                        <x-text-input id="experience" class="form-control" type="text" name="experience"
                                            value="{{ old('experience') ?? ($user->profile->experience ?? 'N/A') }}"
                                            required autofocus autocomplete="experience" />
                                        <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="skills" :value="__('Skills')" />
                                        <x-text-input id="skills" class="form-control" type="text" name="skills"
                                            value="{{ old('skills') ?? ($user->profile->skills ?? 'N/A') }}" required
                                            autofocus autocomplete="skills" />
                                        <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="phone" :value="__('Phone')" />
                                        <x-text-input id="phone" class="form-control" type="number" name="phone"
                                            value="{{ old('phone') ?? ($user->profile->phone ?? '') }}" required autofocus
                                            autocomplete="phone" />
                                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="address" :value="__('Address')" />
                                        <x-text-input id="address" class="form-control" type="tel" name="address"
                                            value="{{ old('address') ?? ($user->profile->address ?? 'N/A') }}" required
                                            autofocus autocomplete="address" />
                                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                    </div>
                                    <div class="pt-5">
                                        <x-input-label for="url" :value="__('Url')" />
                                        <x-text-input id="url" class="form-control" type="text" name="url"
                                            value="{{ old('url') ?? ($user->profile->url ?? 'N/A') }}" required autofocus
                                            autocomplete="url" />
                                        <x-input-error :messages="$errors->get('url')" class="mt-2" />
                                    </div>
                                    <div class="mt-4">
                                        <x-input-label for="image" :value="__('Profile Image')" />
                                        <x-text-input id="image" class="form-control" type="file" name="image"
                                            :value="old('image')" autocomplete="image" />
                                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                    </div>
                                    <div class="flex items-center justify-end mt-4 pt-3">
                                        <x-primary-button class="btn btn-primary">
                                            {{ __('Save Profile') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop


