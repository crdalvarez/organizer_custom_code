@can('view', $team)
    @if ($team->leaders()->isNotEmpty())
        <div class="mt-4">
            <div class="row">
                @foreach ($team->leaders() as $leader)
                    <div class="card card-widget widget-user shadow col-md-4 mb-4">
                        <div class="widget-user-header bg-info">
                            <h3 class="widget-user-username">{{ $leader->profile->username }}</h3>
                            <h5 class="widget-user-desc">{{ $leader->profile->title }}</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle profile-user-img bg-gray-light" style="width: 100px; height: 100px;" src="{{ asset('storage/' . $leader->profile->image) }}">

                        </div>
                        <div class="widget-user-body pb-2">
                            <div class="text-center mt-5">
                                <div><a href="{{ route('profile.show', ['user' => $leader->id]) }}">{{ $leader->username }}</a></div>
                                <p class="font-bold"><a href="mailto:{{ $leader->email }}">{{ $leader->email }}</a></p>
                                
                                @can('changeLeader', $team)
                                    <a class="btn btn-primary mb-2" href="{{ route('teamcollaborator.store', ['team' => $team->id, 'user' => $leader->id]) }}">Remove</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-footer" style="padding-top:5px;">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $team->user->projects->count() }}</h5>
                                        <span class="description-text">Projects</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $team->user->teams->count() }}</h5>
                                        <span class="description-text">Teams</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $team->user->tasks->count() }}</h5>
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