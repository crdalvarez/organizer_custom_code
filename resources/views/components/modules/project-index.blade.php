<div class="mt-4">
    <div class="row">
        @foreach ($projects as $project)
            <div class="col-md-3 mb-4">
                <div class="card border-primary h-100 d-flex flex-column">
                    <div class="card-header">{{ $project->name }}</div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $project->description }}</h5>
                        <p class="card-text flex-fill">{{ $project->details }}</p>
                    </div>
                    <div class="mt-auto text-center p-3">
                        <a href="{{ route('project.show', $project->id) }}" class="btn btn-outline-primary">View</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


