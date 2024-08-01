@extends('adminlte::page')
@section('title', 'Project')
@section('content_header')
    <section class="mt-1">
        @if ($data->module->teams->isEmpty())
            <div class="callout callout-danger">
                @can('update', $data->module)  
                    <h3 class="text-danger">This Project has not any associated collaborators. Assign a team</h3>
                @endcan
                @cannot('update', $data->module)
                    <h3 class="text-danger">This Project has not any associated collaborators.</h3>
                @endcannot
            </div>
        @endif
    </section>
@stop
@section('content')
    <div class="card" id="app">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h2 class="text-primary">{{ $data->module->name }}</h2>
                </div>
                <div class="col-4 text-right">
                    @can('update', $data->module)
                        <a class="btn btn-primary m-2" href="{{ route('project.edit', ['project' => $data->module->id]) }}">Settings</a>
                    @endcan
                
                    <a class="btn btn-primary m-2" href="{{ route('project.tasks', ['project' => $data->module->id]) }}">Show Tasks</a>
                
                    @can('open', $data->module)
                        @if ($data->module->status === 'closed')
                            <button class="btn btn-warning m-2" onclick="openProject({{ $data->module->id }})">Open this Project</button>
                        @else
                            <button class="btn btn-warning m-2" onclick="forceToClose({{ $data->module->id }})">Close Project</button>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body" style="display: block;">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Sections</span>
                                    <h2 class="info-box-number text-center mb-0 text-primary">
                                        {{ $data->module->stages->count() }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Tasks</span>
                                    <h2 class="info-box-number text-center mb-0 text-primary">{{ count($data->event) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Collaborators</span>
                                    <h2 class="info-box-number text-center mb-0 text-primary">1</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        </div>
                        <div class="col-12">
                            <div class="card card-default" id="sections">
                                <div class="card-header">
                                    <span class="text-primary text-lg">Sections</span>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            data-toggle="collapse" data-target="#collapseAllSection"
                                            aria-controls="collapseAllSection">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse" id="collapseAllSection">
                                    <div class="card-body" style="display: block;">
                                        <div class="row">
                                            <div class="col-12">
                                                @include('projects.partials.stages-show')
                                                @can('update', $data->module)
                                                    @include('projects.partials.stages-new')
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default" id="teams">
                                <div class="card-header">
                                    <span class="text-primary text-lg">Teams</span>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            data-toggle="collapse" data-target="#collapseAllTeams"
                                            aria-controls="collapseAllTeams">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse" id="collapseAllTeams">
                                    <div class="card-body" style="display: block;">
                                        <div class="row">
                                            <div class="col-12">
                                                @include('projects.partials.teams-show')

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can('collaborate', $data->module)
                                @include('comments.new')
                            @endcan
                            @can('view', $data->module)
                                @include('comments.show')
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <div class="text-center mt-1">
                        <h5 class="text-primary"><a
                            href="{{ route('profile.show', ['user' => $data->module->user->id]) }}">{{ $data->module->user->name }} {{ $data->module->user->lastname }}</a>
                        <div class="text-primary text-sm">(Project Leader)</div>
                    </div>
                    <div class="text-right mt-1 mb-3">
                        <h5 class="text-primary my-3">End Date: <span class="text-danger ml-2">
                                {{ $data->module->finish_date }}</span></h4>
                            <span class="text-primary mr-3 text-lg">Status:</span>
                            @if ($data->module->status == 'closed')
                                <span class="btn btn-success">Closed</span>
                            @else
                                <span class="btn btn-warning">Open</span>
                            @endif
                    </div>
                    <h5 class="text-primary">Client</h5>
                    @if ($data->module->clients->isEmpty())
                        <div class="callout callout-warning">
                            <p>This Project doesn't have any client associated yet. </p>
                            @can('update', $data->module)
                            <a class="text-primary" href="{{ route('project.edit', ['project' => $data->module->id]) }}">Add a client here</a>

                            @endcan
                        </div>
                    @else
                        @foreach ($data->module->clients as $client)
                        <a href="{{ route('client.show', ['client' => $client->id]) }}" class="text-muted">{{ $client->name }}</a>

                        @endforeach
                    @endif
                    <h5 class="text-primary mt-4"> Description</h5>
                    <p class="text-muted">{{ $data->module->description }}</p>
                    <h5 class="text-primary"> Details</h5>
                    <p class="text-muted">{{ $data->module->details }}</p>
                    @if (!empty($data->statusGraphValues))
                        <h3 class="text-primary text-center">Status</h3>
                        @php
                            $colors = '#20c997, #ffc107, #ddd';
                        @endphp
                        <div>
                            <div class="pb-4 text-center">
                                <div class="mx-auto" style="width: 50%;">
                                    <graph :status="{{ json_encode($data->statusGraphValues) }}"
                                        :colors="{{ json_encode(explode(',', $colors)) }}"></graph>
                                </div>
                            </div>
                    @endif

                    <div class="mt-5">
                        <div id='calendar'></div>
                    </div>
                        @include('projects.partials.files')
                    <div class="card card-default" id="sections">
                        <div class="card-header">
                            <h3 class="card-title">Teams</h3>
                        </div>
                        <div id="collapseAllSection">
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-12 pb-4">
                                        @if ($data->module->teams->isNotEmpty())
                                            @foreach ($data->module->teams as $team)
                                            <h5 class="text-primary pt-4"><a href="{{ route('team.show', ['team' => $team->id]) }}">{{ $team->name }}</a></h5>
                                                <div class="pl-3">
                                                    @foreach ($team->collaborators as $collaborator)
                                                    <a href="{{ route('profile.show', ['user' => $collaborator->id]) }}" class="pr-3" title="{{ $collaborator->username }}">
                                                        <img class="img-circle" style="width: 40px; height: 40px;" src="{{ asset('storage/' . $collaborator->profile->image) }}" alt="">
                                                            {{ $collaborator->name }} {{ $collaborator->lastname }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-danger">This project doesn't have any team assigned
                                                yet.</span><br>
                                            @can('update', $data->module)
                                                <a href="{{ route('project.edit', ['project' => $data->module->id]) }}">Add Teams here.</a>
                                            @endcan
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
@stop

@section('js')
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

        <script>
            function forceToClose(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This Project has open tasks.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                        axios.post('{{ route('project.close') }}', {
                                id: id
                            })
                            .then(response => {
                                if (response.status === 200) {
                                    location.reload();
                                } else {
                                    throw new Error('Failed to close Project');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Failed to close the Project. Please try again later.',
                                    'error'
                                );
                            });
                    }
                });
            }

            function openProject(id) {
               
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Please confirm to reOpen this Project.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                        axios.post('{{ route('project.open') }}', {
                                id: id
                            })
                            .then(response => {
                                if (response.status === 200) {
                                    location.reload();
                                } else {
                                    throw new Error('Failed to open Project');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Failed to open the Project. Please try again later.',
                                    'error'
                                );
                            });
                    }
                });
            }
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    height: 650,
                    themeSystem: 'boostratp5',
                    initialView: 'dayGridMonth',
                    eventDisplay: 'block',
                    eventContent: function(info) {
                       
                        return {
                            html: '<a href="' + '{{ route('task.show', ['task' => '__event__']) }}'.replace('__event__', info.event.id) +  '" style="color:' + info.event.textColor + ';" title="' + info.event.title + '"><b>' + info.event.title + '</b></a>'
                        };
                    },
                    events: @json($data->event)

                });
                calendar.render();
            });
        </script>
    @stop
@endpush
