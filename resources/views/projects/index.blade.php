@extends('adminlte::page')
@section('title', 'Projects')
@section('content_header')
    <section class="mt-1">
    </section>
@stop

@section('content')
    @can('viewAny', \App\Models\Project::class)
        <div class="card">
            <div class="card-header">
                <h2 class="text-primary">Projects</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row border rounded-border">
                            <div class="col-12 order-2 order-md-1">
                                @if (!$projects->isEmpty())
                                    <div class="row border-bottom py-3">
                                        <div class="col-2 pl-3"><span class="font-weight-bold">Name</span></div>
                                        <div class="col-3"><span class="font-weight-bold">Description</span></div>
                                        <div class="col-2"><span class="font-weight-bold">Details</span></div>
                                        <div class="col-2"><span class="font-weight-bold">Owner</span></div>
                                        <div class="col-2"><span class="font-weight-bold">Teams</span></div>
                                        <div class="col-1"><span class="font-weight-bold">Status</span></div>
                                    </div>
                                    @foreach ($projects as $project)
                                        <div class="row border-bottom">
                                            <div class="col-2 py-3 pl-3">
                                                <a
                                                    href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->name }}</a>
                                            </div>
                                            <div class="col-3 py-3">
                                                <a
                                                    href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->description }}</a>
                                            </div>
                                            <div class="col-2 py-3">
                                                <a
                                                    href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->shortDetails() }}</a>
                                            </div>
                                            <div class="col-2 py-3">
                                                <img class="user-image img-circle elevation-1" style="height:25px; width:25px;"
                                                    src="{{ asset('storage/' . $project->user->profile->image) }}" />

                                                <a href="{{ route('profile.show', ['user' => $project->user->id]) }}">{{ $project->user->name }}
                                                    {{ $project->user->lastname }}</a>
                                            </div>
                                            <div class="col-2 py-3">
                                                @foreach ($project->teams as $team)
                                                    <a
                                                        href="{{ route('team.show', ['team' => $team->id]) }}">{{ $team->name }}</a>
                                                @endforeach
                                            </div>
                                            <div class="col-1 py-3">
                                                @if ($project->status == 'closed')
                                                    <span class="badge bg-green">
                                                    @else($project->status == 'close')
                                                        <span class="badge bg-warning">
                                                @endif
                                                {{ $project->status }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row justify-content-end">
                                        <div class="col-12 callout callout-danger text-center ml-4">
                                            <h3>We couldn't find any projects</h3>
                                            <h4 class="py-3 text-primary">Create new Project</h4>
                                            <a class="btn btn-primary" href="{{ route('project.new') }}">Create</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        @if (!$projects->isEmpty())
                            @if (!empty($statusGraphValues))
                                <h3 class="text-primary text-center pt-3">Status</h3>
                                @php
                                    $colors = '#20c997, #ffc107, #ddd';
                                @endphp
                                <div id="app" class="pb-4 text-center">
                                    <div class="mx-auto" style="width: 70%">
                                        <graph :status="{{ json_encode($statusGraphValues) }}" <?php
                                        /*
                                    :colors="{{json_encode(explode(',',$data->status->value))}}" */
                                        ?>
                                            :colors="{{ json_encode(explode(',', $colors)) }}"></graph>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @vite('resources/js/app.js')
        @stop
    @endcan
