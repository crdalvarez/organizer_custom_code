@can('view', $team)
    @if ($team->collaborators->isEmpty())
        <div class="callout callout-danger">
            <h4>There aren't Collaborators in this Team yet</h4>
            <p>Only the administrator of this Team can add new Collaborators</p>
        </div>
    @endif
    <div class="mt-4 ml-1">
        <div class="row">
            @foreach ($team->collaborators as $collaborator)
                <div class="card card-widget widget-user shadow col-md-4 mb-4">
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">{{ $collaborator->profile->username }}</h3>
                        <h5 class="widget-user-desc">{{ $collaborator->profile->title }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle profile-user-img bg-gray-light" style="width: 100px; height: 100px;"
                        src="{{ asset('storage/' . $collaborator->profile->image) }}">
                    
                    </div>
                    <div class="widget-user-body pb-2">
                        <div class="text-center mt-5">
                            <div><a href="{{ route('profile.show', ['user' => $collaborator->id]) }}">{{ $collaborator->username }}</a></div>
                            <p class="font-bold "><a href="mailto:{{ $collaborator->email }}">{{ $collaborator->email }}</a></p>
                            @can('update', $team)
                                <a class="btn btn-primary mb-2" href="{{ route('teamcollaborator.store', ['team' => $team->id, 'user' => $collaborator->id]) }}">Remove</a>
                                <add_team_collaborator user-id="{{ $collaborator->id }}"></add_team_collaborator>
                            @endcan
                        </div>
                        
                    </div>
                    <div class="card-footer" style="padding-top:5px;">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $collaborator->projects->count() }}</h5>
                                    <span class="description-text">Projects</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $collaborator->teams->count() }}</h5>
                                    <span class="description-text">Teams</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $collaborator->tasks->count() }}</h5>
                                    <span class="description-text">Tasks</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endcan