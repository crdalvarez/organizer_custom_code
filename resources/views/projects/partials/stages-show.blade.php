@can('view', $data->module)
    @foreach ($data->module->stages as $stage)
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Section: <span class="text-blue">{{ $stage->name }}</span></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="collapse"
                        data-target="#collapseSection{{ $stage->id }}" aria-controls="collapseSection{{ $stage->id }}">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="collapse" id="collapseSection{{ $stage->id }}">
                <div class="card-body" style="display: block;">
                    <div class="row">
                        <div class="col-3">
                            {{ $stage->description }}
                        </div>
                        <div class="col-3">
                            {{ $stage->details }}
                        </div>
                        <div class="col-3">
                            {{ $stage->owner }}
                        </div>
                        <div class="col-3">
                            {{ $stage->status }}
                        </div>
                    </div>
                    @include('projects.partials.stages-tasks-index', [
                        'project_id' => $data->module->id,
                        'stage_id' => $stage->id,
                        'stage_tasks' => $stage->task, 
                    ])
                    
                </div>
            </div>
        </div>
    @endforeach
@endcan