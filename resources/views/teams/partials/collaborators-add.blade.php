@can('view', $team)
    @if ($team->noCollaborators()->isEmpty())
        <div class="callout callout-danger">
            <h4>We can't find users to add to this Team.</h4>
            <p>Only the administrator of this Team can add new Collaborators</p>
        </div>
    @else
        <div class="mt-4">
            <div class="row">
                @foreach ($team->noCollaborators() as $noCollaborator)
                    <div class="card card-widget widget-user shadow col-md-4 mb-4">
                        <div class="widget-user-header bg-info">
                            <h3 class="widget-user-username">{{ $noCollaborator->profile->username }}</h3>
                            <h5 class="widget-user-desc">{{ $noCollaborator->profile->title }}</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle profile-user-img bg-gray-light" style="width: 100px; height: 100px; src="{{ asset('storage/' . $noCollaborator->profile->image) }}" alt="">
                        </div>
                        <div class="widget-user-body pb-2">
                            <div class="text-center mt-5">
                                <div><a href="{{ route('profile.show', ['user' => $noCollaborator->id]) }}">{{ $noCollaborator->username }}</a></div>
                                <p class="font-bold"><a href="mailto:{{ $noCollaborator->email }}">{{ $noCollaborator->email }}</a></p>
                                <a class="btn btn-primary mb-2" href="{{ route('teamcollaborator.store', ['team' => $team->id, 'user' => $noCollaborator->id]) }}">Add</a>
                                @can('update', $team)
                                    <add_team_collaborator user-id="{{ $noCollaborator->id }}"></add_team_collaborator>
                                @endcan
                            </div>
                            
                        </div>
                        <div class="card-footer" style="padding-top:5px;">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $noCollaborator->projects->count() }}</h5>
                                        <span class="description-text">Projects</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $noCollaborator->teams->count() }}</h5>
                                        <span class="description-text">Teams</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $noCollaborator->tasks->count() }}</h5>
                                        <span class="description-text">Tasks</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endcan