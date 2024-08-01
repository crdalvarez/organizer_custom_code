@can('update', $data->module)
    <div class="card card-light">
        <div class="card-header">
            <span class="text-primary text-lg">Add new section</span>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="collapse"
                    data-target="#collapseNewSection" aria-controls="collapseNewSection">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="collapse" id="collapseNewSection">
            <div class="card-body" style="display: block;">
                <div class="row">
                    <div class="col-12">
                        <form method="POST" action="{{ route('stage.create') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row space-between">
                                    <div class="col-3">
                                        <span>In Charge:</span>
                                        <select name="responsible_id" class="form-control">
                                            @foreach ($data->collaborating as $collaborator)
                                                <option value="{{ $collaborator->id }}">{{ $collaborator->name }}
                                                    {{ $collaborator->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row space-between">
                                    <div class="col-3">
                                        <x-input-label for="name" :value="__('Stage Name')" />
                                        <x-text-input id="name" class="form-control" type="text" name="name"
                                            required autofocus autocomplete="name" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                    <div class="col-4">
                                        <x-input-label for="description" :value="__('Description')" />
                                        <x-text-input id="description" class="form-control" type="text"
                                            name="description" required autofocus autocomplete="description" />
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                    <div class="col-5">
                                        <x-input-label for="details" :value="__('Details')" />
                                        <x-text-input id="details" class="form-control" type="text" name="details"
                                            required autofocus autocomplete="details" />
                                        <x-input-error :messages="$errors->get('details')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="row space-between mt-3">
                                    <div class="col-3">
                                        <x-text-input id="project_id" type="hidden" name="project_id"
                                            value="{{ $data->module->id }}" required />
                                        <x-primary-button class="btn btn-primary">
                                            {{ __('Create Stage') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan
