@can('update', $data->module)
    <form method="POST" action="{{ route('stage.create') }}" enctype="multipart/form-data">
        @csrf
        <div class="row p-3">
            <div class="col-12 bg-primary rounded p-1">
                <h5 class="pl-3 pt-2">Create New Stage</h5>
            </div>
        </div>
        <div class="row p-3 pb-4">
            <div class="col-2">
                <x-input-label for="name" :value="__('In Charge')" />
                <select class="form-control" name="responsible_id">
                    @foreach ($data->collaborating as $collaborator)
                        <option value="{{ $collaborator->id }}">{{ $collaborator->name }} {{ $collaborator->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-2">
                <x-input-label for="name" :value="__('Stage Name')" />
                <x-text-input id="name" class="form-control" type="text" name="name" required autofocus
                    autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="col-2">
                <x-input-label for="description" :value="__('Description')" />
                <x-text-input id="description" class="form-control" type="text" name="description" required autofocus
                    autocomplete="description" />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div class="col-2">
                <x-input-label for="details" :value="__('Details')" />
                <x-text-input id="details" class="form-control" type="text" name="details" required autofocus
                    autocomplete="details" />
                <x-input-error :messages="$errors->get('details')" class="mt-2" />
            </div>
            <div class="col-3 d-flex flex-column pt-4">
                <x-text-input id="project_id" type="hidden" name="project_id" value="{{ $project->id }}" required />
                <x-primary-button class="btn btn-primary">
                    {{ __('Create Stage') }}
                </x-primary-button>
            </div>
        </div>
    </form>
@endcan