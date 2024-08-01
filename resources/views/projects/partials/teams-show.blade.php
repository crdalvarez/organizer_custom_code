@can('view', $data->module)
    <div class="card">
        @if ($data->module->assignedTeams()->isEmpty())
            <div class="callout callout-danger">
                <h4>There aren't Teams associated with this project yet.</h4>
                <p>Only the Administrator of this project can add new Teams and Collaborators.</p>
                <p>(Go to <a class="text-primary"
                        href="{{ route('project.edit', ['project' => $data->module->id]) }}">settings</a>
                    to add new collaborators).</p>
            </div>
        @endif
        <div class="card-body mt-4">
            <div class="row">
                @foreach ($data->module->assignedTeams() as $team)
                    <div class="card card-widget widget-user shadow col-md-3 col-lg-3 col-3 m-2 ml-5">
                        <div class="widget-user-header bg-gray-light mt-1">
                            <h3 class="widget-user-username"><a
                                    href="{{ route('team.show', ['team' => $team->id]) }}">{{ $team->name }}</a></h3>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle profile-user-img bg-gray-light" style="width: 100px; height: 100px;"
                                src="/storage/{{ $team->user->profile->image }}">
                        </div>
                        <div class="widget-user-body pb-3">
                            <div class="text-center mt-5">
                                <a href="{{ route('profile.show', ['user' => $team->user_id]) }}">{{ $team->user->name }}
                                    {{ $team->user->lastname }}</a>
                                <div class="text-small text-muted">(Team Leader)</div>
                                <p class="font-bold "><a href="{{ route('profile.show', ['user' => $team->details]) }}">{{ $team->email }}</a>
                                </p>
                                @can('update', $data->module)
                                    <form method='post' action="{{ route('project.team.store') }}">
                                        @csrf
                                        <input type="hidden" name="team" value="{{ $team->id }}">
                                        <input type="hidden" name="project" value="{{ $data->module->id }}">
                                        <input type="submit" class="btn btn-warning" value="Remove Team">
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endcan
