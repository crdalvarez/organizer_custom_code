@extends('adminlte::page')
@section('title', 'Tasks')
@section('content_header')
    <div class="ml-1">
    </div>
@stop
@can('viewAny', \App\Models\Task::class)
    @section('content')
        <div class="card" id="app">
            <div class="card-header">
                <h2 class="text-primary">My Tasks</h2>
            </div>
            <div class="card-body" style="display: block;">
                <div class="row border-bottom pb-2">
                    <div class="col-1 text-left font-weight-bold">Project</div>
                    <div class="col-1 text-left font-weight-bold">Stage</div>
                    <div class="col-1 text-left font-weight-bold">Task</div>
                    <div class="col-2 text-left font-weight-bold">Description</div>
                    <div class="col-1 text-left font-weight-bold pl-3">In Charge</div>
                    <div class="col-1 text-left font-weight-bold">Start Date</div>
                    <div class="col-2 text-left font-weight-bold">Finish Date</div>
                    <div class="col-1 text-left font-weight-bold">Status</div>
                    <div class="col-1 text-left font-weight-bold">Progress</div>
                    <div class="col-1 text-left font-weight-bold">Priority</div>
                </div>
                @foreach ($tasks as $task)
                
                    <task-index element-id="{{ $task->id }}" :project="{{ $task->stage->project }}"
                        :stage="{{ $task->stage }}"
                        :responsible='[
                            { "name": "{{ $task->responsible->name }}", "lastname": "{{ $task->responsible->lastname }}", "image": "{{asset('/storage/'.$task->responsible->profile->image)}}", "id": "{{ $task->responsible->id }}" }
                        ]'>
                    </task-index>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
        @vite('resources/js/app.js')
    @stop

    @section('js')
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        @endpush
    @stop
    
    @section('css')
        <style>
            .switch {
                position: relative;
                display: inline-block;
                width: 30px;
                height: 20px;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: -15px;
                bottom: 0;
                background-color: #21C396F3;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 10px;
                width: 10px;
                left: 5px;
                bottom: 5px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }

            input:checked+.slider {
                background-color: #ccc;
            }

            input:focus+.slider {
                box-shadow: 0 0 1px #ccc;
            }

            input:checked+.slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
                border-radius: 10px;
            }

            .slider.round:before {
                border-radius: 50%;
            }

            @keyframes blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 0;
                }

                100% {
                    opacity: 1;
                }
            }

            /* Apply the blink animation to the span */
            .blinking {
                animation: blink 1s infinite;
            }
        </style>
    @stop
@endcan
