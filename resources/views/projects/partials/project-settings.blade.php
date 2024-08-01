@can('update', $data->module)
    <div class="col-12 col-md-12 col-lg-6 order-md-2 p-3 pt-5">
        <h3 class="text-primary">Settings</h3>
    </div>
    <div class="content active dstepper-block">
        @php
            $settingsGroup = $data->settings->groupBy('setting');
        @endphp
        @if ($settingsGroup instanceof \Illuminate\Database\Eloquent\Collection || is_array($group))
            @foreach ($settingsGroup as $settings)
                <div class="pb-5">
                    <h5 class="pb-1">{{ $settings[0]->setting }}</h5>
                    @foreach ($settings as $setting)
                        <form method="POST" action="{{ route('settings.update') }}">

                            @csrf
                            <div class="row py-1">
                                <div class="col-4">
                                    <x-text-input id="{{ $setting->setting }}" class="form-control" type="text"
                                        name="value" value="{{ $setting->value }}" autofocus required />
                                    <x-input-error :messages="$errors->get('value')" class="mt-2" />
                                </div>
                                <div class="col-4">
                                    <x-text-input id="{{ $setting->order }}" class="form-control" type="number"
                                        name="order" value="{{ $setting->order }}" autofocus required />
                                    <x-input-error :messages="$errors->get('order')" class="mt-2" />
                                </div>
                                <div class="col-4">
                                    <input type="hidden" name="id" value="{{ $setting->id }}" />
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                    <form method="POST" action="{{ route('settings.create') }}">
                        <div class="row">
                            @csrf
                            <div class="col-4">
                                <x-input-label for="status" :value="__('New Value')" />
                                <x-text-input id="new" class="form-control" type="text" name="value"
                                    value="" autofocus />
                                <x-input-error :messages="$errors->get('status_color')" class="mt-2" />
                            </div>
                            <div class="col-4">
                                <x-input-label for="status" :value="__('Order')" />
                                <x-text-input id="new" class="form-control" type="number" name="order"
                                    value="" autofocus />
                                <x-input-error :messages="$errors->get('status_color')" class="mt-2" />
                            </div>
                            <div class="col-4 pt-4 place-items-baseline">
                                <input type="hidden" name="model" value="{{ $settings[0]->model }}" />
                                <input type="hidden" name="element_id" value="{{ $settings[0]->element_id }}" />
                                <input type="hidden" name="group" value="settings" />
                                <input type="hidden" name="setting" value="{{ $settings[0]->setting }}" />
                                <input type="hidden" name="status" value="1" />
                                <input type="hidden" name="policy" value="{{ $settings[0]->policy }}" />
                                <button class="btn btn-primary" type="submit">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        @elseif ($group instanceof \App\Models\Settings)
            <p>Setting ID: {{ $group->id }}, Value: {{ $group->value }}</p>
        @else
            <span class="text-danger">No Settings found</span>
        @endif
    </div>
@endcan
