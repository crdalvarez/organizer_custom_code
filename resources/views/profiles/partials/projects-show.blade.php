<div class="mt-4">
    <div class="row">
        @if ($projects->isEmpty())
            <div class="callout callout-info w-100">
                <h4>{{ $user->name }} is not participating in any project yet.</h4>
            </div>
        @else
            @foreach ($projects as $project)
                <div class="col-md-3 mb-4">
                    <div class="card border-primary h-100 d-flex flex-column">
                        <div class="card-header text-primary"><h4>{{ $project->name }}</h4></div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $project->description }}</h5>
                            <p class="card-text flex-fill">{{ $project->details }}</p>
                        </div>
                        <div class="mt-auto text-center p-3">
                            @can('view', $project)
                            <a href="{{ route('project.show', $project->id) }}" class="btn btn-outline-primary">View</a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
