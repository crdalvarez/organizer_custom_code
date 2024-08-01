@can('update', $data->module)
    @if ($stage->tasks->isEmpty())
        <div class="callout callout-danger">
            <h5>This section doesn't has task yet</h5>
        </div>
    @endif
    <div class="card card-default mt-2">
        <div class="card-header">
            <h3 class="card-title text-primary">Add New Task</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="collapse"
                    data-target="#collapseNewTask{{ $stage->id }}" aria-controls="collapseNewTask{{ $stage->id }}">
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

        <div class="{{ $collapse }}" id="collapseNewTask{{ $stage->id }}">
            <div class="card-body">
                <form method="POST"action="{{ route('project.stage.task') }}" enctype="multipart/form-data" class="w-full">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <x-input-label for="name" :value="__('Task Name')" />
                            <x-text-input id="name" class="form-control" type="text" name="name"
                                value="{{ old('name') }}" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="col-2">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="form-control" type="text" name="description"
                                value="{{ old('description') }}" required autofocus autocomplete="description" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="col-2">
                            <x-input-label for="owner" :value="__('In Charge')" />
                            <select class="form-control" name="responsible_id">
                                @foreach ($data->collaborating as $collaborator)
                                    <option value="{{ $collaborator->id }}">{{ $collaborator->name }}
                                        {{ $collaborator->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-1">
                            <x-input-label for="date" :value="__('Start Date')" />
                            <x-text-input id="start_date" class="form-control" type="date" name="start_date"
                                value="{{ old('start_date') }}" required autofocus autocomplete="start_date" />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        <div class="col-1">
                            <x-input-label for="date" :value="__('Finish Date')"
                                title="Date must be within Project Finish Date" />
                            <x-text-input id="finish_date" class="form-control" type="date" name="finish_date"
                                max="{{ $project->finish_date }}" value="{{ old('finish_date') }}" required autofocus
                                autocomplete="finish_date" />
                            <x-input-error :messages="$errors->get('finish_date')" class="mt-2" />
                        </div>
                        <div class="col-1">
                            <x-input-label for="status" :value="__('Status')" />

                            <select class="form-control" name="status">
                                <option value="open" selected>open</option>
                                <option value="closed">closed</option>

                            </select>
                        </div>
                        <div class="col-1">
                            <x-input-label for="progress" :value="__('Progress')" />
                            <select class="form-control" name="progress">
                                @foreach ($data->allStatus as $status)
                                    <option>{{ $status->value }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-1">
                            <x-input-label for="priority" :value="__('Priority')" />
                            <select class="form-control" name="priority">
                                <option selected>Low</option>
                                <option>Medium</option>
                                <option>High</option>

                            </select>
                        </div>
                    </div>
                    <div class="row pb-3 pt-3">
                        <div class="col-8">
                            <x-input-label for="details" :value="__('Details')" />
                            <input type="text" id="details" name="details" value="{{ old('details') }}"
                                placeholder="Details... " required autofocus autocomplete="details" class="form-control" />
                            <x-input-error :messages="$errors->get('details')" class="mt-2" />
                        </div>
                        <div class="col-3 text-left d-flex flex-column pt-4">

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