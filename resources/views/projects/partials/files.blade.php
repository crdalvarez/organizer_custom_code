<div class="card mt-3">
    <div class="card-header ui-sortable-handle">
        <div class="row">
            <div class="col-12">
                <h3 class="card-title">
                    Files
                </h3>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12 p-4">
            @foreach ($data->module->file as $file)
                <ul class="">
                    <li>
                        <a href="{{ Storage::url($file->file) }}" class="btn-link text-primary">
                            {{ $file->file }}</a>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
    @can('collaborate', $data->module)
        <div class="card-body">
            <form method="POST" action="{{ route('file.create') }}" enctype="multipart/form-data">
                @csrf

                @if ($data->module->status !== 'closed')
                    <div class="row align-items-center">
                        <div class="col-9">
                            <input id="file" class="form-control" type="file" name="file"
                                value="{{ old('file') }}" autocomplete="file">
                        </div>
                        <div class="col-3 text-left">
                            <x-text-input id="fileable_type" type="hidden" name="fileable_type"
                                value="{{ @get_class($data->module) }}" required />
                            <x-text-input id="fileable_id" type="hidden" name="fileable_id" value="{{ $data->module->id }}"
                                required />
                            <x-primary-button class="btn btn-primary">
                                {{ __('Add file') }}
                            </x-primary-button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    @endcan
</div>
