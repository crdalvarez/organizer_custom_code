@can('update', $data->module)
    @if ($stage->tasks->isNotEmpty())
        <div class="row border-bottom">
            <div class="col-2 text-left font-weight-bold">Task</div>
            <div class="col-2 text-left font-weight-bold">Description</div>
            <div class="col-2 text-left font-weight-bold pl-3">In Charge</div>
            <div class="col-1 text-left font-weight-bold">Start Date</div>
            <div class="col-2 text-left font-weight-bold">Finish Date</div>
            <div class="col-1 text-left font-weight-bold">Status</div>
            <div class="col-1 text-left font-weight-bold">Progress</div>
            <div class="col-1 text-left font-weight-bold">Priority</div>
        </div>
        @foreach ($stage->tasks as $taskCount => $task)
            <project-task-status-list element-id="{{ $task->id }}"
                :responsible='[
                    { "name": "{{ $task->responsible->name }}", "lastname": "{{ $task->responsible->lastname }}", "image": "{{ $task->responsible->profile->image }}", "id": "{{ $task->responsible->id }}" }
                ]'>
            </project-task-status-list>
        @endforeach
    @endif
    <div class="mb-3"></div>
    @can('update', $data->module)
        @include('projects.partials.list-view.task-new')
    @endcan
@endcan 
