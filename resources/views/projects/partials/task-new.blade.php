@can('collaborate', $data->module)
    <div class="card card-default mt-3">
        <div class="card-header">
            <span class="text-primary text-lg">Add New Task</span>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="collapse"
                    data-target="#collapseNewTask" aria-controls="collapseNewTask">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @php
            $collapse = '';
            if ($stage->tasks->isNotEmpty()) {
                $collapse = 'collapse';
            }
        @endphp
        <div class="{{ $collapse }}" id="collapseNewTask">
            <div class="card-body">
                <form method="POST" action="{{ route('project.stage.task') }}" enctype="multipart/form-data" class="w-full">
                    @csrf
                    <div class="row space-between justify-content-left">
                        <div class="col-3"></div>
                        <div class="col-3"></div>
                        <div class="col-3">
                            <x-input-label for="owner" :value="__('Owner')" />
                            <select class="form-control" name="responsible_id">
                                @foreach ($data->collaborating as $collaborator)
                                    <option value="{{ $collaborator->id }}">{{ $collaborator->name }}
                                        {{ $collaborator->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <x-input-label for="status" :value="__('Status')" />
                            <select class="form-control" name="status">
                                <option selected>open</option>
                                <option>closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="row space-between mt-4">
                        <div class="col-3">
                            <x-input-label for="progress" :value="__('Progress')" />
                            <select class="form-control" name="progress">
                                @foreach ($data->allStatus as $status)
                                    <option>{{ $status->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <x-input-label for="priority" :value="__('Priority')" />
                            <select class="form-control" name="priority">
                                <option selected>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <x-input-label for="start_date" :value="__('Start date')" />
                            <x-text-input id="start_date" class="form-control" type="date" name="start_date"
                                value="{{ old('start_date') }}" required autofocus autocomplete="start_date" />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        <div class="col-3">
                            <x-input-label for="finish_date" :value="__('Finish date')" />
                            <x-text-input id="finish_date" class="form-control" type="date" name="finish_date"
                                value="{{ old('finish_date') }}" required autofocus autocomplete="finish_date" />
                            <x-input-error :messages="$errors->get('finish_date')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row space-between mt-4">
                        <div class="col-3">
                            <x-input-label for="name" :value="__('Task Name')" />
                            <x-text-input id="name" class="form-control" type="text" name="name"
                                value="{{ old('name') }}" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="col-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="form-control" type="text" name="description"
                                value="{{ old('description') }}" required autofocus autocomplete="description" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="col-5">
                            <x-input-label for="details" :value="__('Details')" />
                            <input type="text" id="details" name="details" value="{{ old('details') }}"
                                placeholder="Details... " required autofocus autocomplete="details" class="form-control" />
                            <x-input-error :messages="$errors->get('details')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row space-between justify-content-center">
                        <div class="col-3 mt-4">
                            <input type="hidden" id="project_id" name="project_id" value="{{ $data->module->id }}"
                                required />
                            <input type="hidden" id="stage_id" name="stage_id" value="{{ $stage->id }}" required />
                            <x-primary-button class="btn btn-primary ">
                                {{ __('Add new Task') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endcan