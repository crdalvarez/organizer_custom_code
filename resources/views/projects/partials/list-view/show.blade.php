@extends('adminlte::page')

@section('title', 'Project Table')

@section('content_header')
    <section class="mt-1">
    </section>
@stop
@can('view', $data->module)
    @section('content')
        <div class="col-12" id="app">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h2 class="text-primary">{{ $project->name }}</h2>
                        </div>
                        <div class="col-4 text-right">
                            @can('update', $data->module)
                                <a class="btn btn-primary m-2" href="{{ route('project.edit', $data->module->id) }}">Project Settings</a>
                            @endcan
                            <a class="btn btn-primary m-2" href="{{ route('project.show', $data->module->id) }}">Project View</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="mt-3">
                        @can('view', $data->module)
                            @include('projects.partials.list-view.stage-show')
                        @endcan
                        @can('update', $data->module)
                            @include('projects.partials.list-view.stage-new')
                        @endcan
                    </div>
                </div>
            </div>
            
        </div>
       
    @stop
    @section('js')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var buttons = document.querySelectorAll('.btn-toggle');

                buttons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        buttons.forEach(function(btn) {
                            if (btn !== button) {
                                btn.classList.remove('active');
                            }
                        });
                        button.classList.add('active');
                    });
                });
            });
        </script>
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

            .slider.round {
                border-radius: 10px;
            }

            .slider.round:before {
                border-radius: 50%;
            }
        </style>
    @stop
@endcan

@vite('resources/js/app.js')