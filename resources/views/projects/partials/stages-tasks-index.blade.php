@can('view', $data->module)
    <div class="card mt-4">
        @if ($stage->tasks->isNotEmpty())
            <div class="card-header">
                <h3 class="card-title">Tasks</h3>
                <div class="card-tools">
                    <ul class="pagination pagination-sm float-right">
                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                        <li class="page-item"><a class="page-link" href="">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Task</th>
                            <th>Description</th>
                            <th>Finish Date</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stage->tasks as $taskCount => $task)
                            <tr class="hover-bg"
                                onclick="window.location='{{ route('task.show', ['task' => $task->id]) }}';"
                                style="cursor: pointer;">

                                <td>{{ $taskCount + 1 }}.</td>
                                <td><a href="{{ route('task.show', $task->id) }}">{{ $task->name }}</a></td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->finish_date }}</td>
                                <td>
                                    @if ($task->status == 'open')
                                        <span class="badge bg-success">
                                        @else
                                            <span class="badge bg-gray">
                                    @endif
                                    {{ $task->status }}</span>
                                </td>
                                <td><span class="badge bg-primary">{{ $task->progress }}</span></td>
                                <td>
                                    @switch($task->priority)
                                        @case('Low')
                                            <span class="badge bg-success">{{ $task->priority }}</span>
                                        @break

                                        @case('Medium')
                                            <span class="badge bg-warning">{{ $task->priority }}</span>
                                        @break

                                        @case('High')
                                            <span class="badge bg-danger">{{ $task->priority }}</span>
                                        @break

                                        @default
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endcan
@can('collaborate', $data->module)
    @include('projects.partials.task-new')
@endcan
