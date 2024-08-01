@can('update', $data->module)
    <div class="col-12 col-md-12 col-lg-6 order-md-2 p-3">
        <h3 class="text-primary">General</h3>
    </div>
    <form method="POST" action="{{ route('project.update', ['project' => $data->module]) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="content active dstepper-block">
            <div class="form-group">
                <x-input-label for="name" :value="__('Project Name')" />
                <x-text-input id="name" class="form-control" type="text" name="name"
                    value="{{ old('name') ?? $data->module->name }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="form-group">
                <x-input-label for="description" :value="__('Description')" />
                <x-text-input id="description" class="form-control" type="text" name="description"
                    value="{{ old('description') ?? $data->module->description }}" required autofocus
                    autocomplete="description" />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div class="form-group">
                <x-input-label for="details" :value="__('Details')" />
                <textarea id="details" name="details" placeholder={{ $data->module->details }} required autofocus
                    autocomplete="details" class="form-control">
                {{ trim($data->module->details) }}
            </textarea>
                <x-input-error :messages="$errors->get('details')" class="mt-2" />
            </div>
            <div class="form-group">
                <x-input-label for="finish_date" :value="__('Date')" />
                <x-text-input id="finish_date" class="form-control datepicker-input" type="date" name="finish_date"
                    value="{{ old('finish_date') ?? $data->module->finish_date }}" required autofocus
                    autocomplete="finish_date" />
                <x-input-error :messages="$errors->get('date')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4 pt-3">
                <input type="hidden" name="project_id" value={{ $data->module->id }} />
                <x-primary-button class="btn btn-primary text-md">
                    {{ __('Update Project') }}
                </x-primary-button>
            </div>
        </div>
    </form>
@endcan