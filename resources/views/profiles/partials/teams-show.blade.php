<div class="mt-4">
    <div class="row">
        @if ($user->teams->isNotEmpty())
            @foreach ($user->teams as $team)
                <div class="card card-widget widget-user shadow col-md-3 col-lg-3 col-3 m-2 ml-5">
                    <div class="widget-user-header bg-gray-light mt-1">
                        <h3 class="widget-user-username"><a href="{{ route('team.show', $team->id) }}">{{ $team->name }}</a></h3>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle profile-user-img bg-gray-light" style="width: 100px; height: 100px;"
                        src="{{ asset('storage/' . $team->user->profile->image) }}">
                    </div>
                    <div class="widget-user-body pb-3">
                        <div class="text-center mt-5">
                            <a href="{{ url('profile', $team->user->id) }}">{{ $team->user->name }} {{ $team->user->lastname }}</a>
                            <div class="text-small text-muted">(Team Leader)</div>
                            <p class="font-bold "><a href="{{ url('profile', $team->details) }}">{{ $team->email }}</a>
                                </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="callout callout-info w-100">
                <h4>{{ $user->name }} is not participating in any team yet</h4>
            </div>
        @endif
    </div>
</div>
