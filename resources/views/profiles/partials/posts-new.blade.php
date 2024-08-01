@can('update', $user->profile)
    <div class="post">
        <form method="POST"action="{{ route('profile.store') }}" enctype="multipart/form-data">

            @csrf
            <div>
                <x-input-label for="post" :value="__('Make new post')" />
                <x-text-input id="post" class="form-control" type="text" name="post" required autofocus
                    autocomplete="post" />
                <x-input-error :messages="$errors->get('post')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="file" :value="__('File')" />
                <x-text-input id="file" class="form-control" type="file" name="file" autocomplete="file" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="btn btn-primary">
                    {{ __('New Post') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endcan
