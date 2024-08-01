@can('update', $data->module)
    <div class="card">
        @if ($data->module->assignedTeams()->isEmpty())
            <div class="callout callout-danger">
                <h4>There is not any team assigned to this project yet</h4>
                <p>Only the administrators can assign teams</p>
            </div>
        @endif
        @if ($data->module->unassignedTeams()->isNotEmpty())
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                        <div class="row">
                            @foreach ($data->unassignedTeams as $team)
                                <div class="card card-widget widget-user shadow col-md-3 m-2 ml-5">
                                    <div class="widget-user-header bg-gray-light mt-1">
                                        <h3 class="widget-user-username"><a href="{{ route('team.show', ['team' => $team->id]) }}">{{ $team->name }}</a></h3>
                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle profile-user-img bg-gray-light"
                                            style="width: 100px; height: 100px;"
                                            src="/storage/{{ $team->user->profile->image }}">
                                    </div>
                                    <div class="widget-user-body">
                                        <div class="text-center mt-5">
                                            <span><a href="{{ route('profile.show', ['user' => $team->user_id]) }}">{{ $team->user->name }} {{ $team->user->lastname }}</a></span><br>

                                            <span class="text-small text-gray">(Team Leader)</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="description-block">
                                                @can('update', $data->module)
                                                <form method='post' action="{{ route('project.team.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="team" value="{{ $team->id }}">
                                                    <input type="hidden" name="project" value="{{ $data->module->id }}">
                                                    <input type="submit" class="btn btn-primary" value="Associate">
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endcan