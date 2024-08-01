@can('view', $data->module)
    @foreach ($data->module->stages as $stage)
        <div class="card">
            <div class="bg-gray-light p-3 text-right">
                <h3 class="card-title">Section: <span class="text-blue pl-3">{{ $stage->name }}</span></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="collapse"
                        data-target="#collapseSection{{ $stage->id }}" aria-controls="collapseSection{{ $stage->id }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div id="collapseSection{{ $stage->id }}">
                <div class="card-body">
                    
                    @include('projects.partials.list-view.task-index', [
                        'project_id' => $data->module->id,
                        'stage_id' => $stage->id,
                        'stage_tasks' => $stage->tasks,
                    ])
                </div>
            </div>
        </div>
    @endforeach
@endcan
