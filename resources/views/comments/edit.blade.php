<x-app-layout>
    <div class="container mx-auto p-4 w-1/2">
        <div class="bg-white p-4 rounded-md shadow-md mb-1 flex items-center">
            <form method="POST"action="{{ route('task.update', $task->id) }}" enctype="multipart/form-data"
                class="w-full">
                @csrf
                @method('PATCH')
                <div class="pb-11">
                    <h1>New Task</h1>
                </div>
                <div class="pt-5">
                    <x-input-label for="name" :value="__('Task Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        value="{{ old('name') ?? $task->name }}" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="pt-5">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input id="description" class="block mt-1 w-full" type="text" name="description"
                        value="{{ old('description') ?? $task->description }}" required autofocus
                        autocomplete="description" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="pt-5">
                    <x-input-label for="details" :value="__('Details')" />
                    <textarea id="details" name="details" value="{{ old('details') ?? $task->details }}"
                        placeholder={{ $task->details }}required autofocus autocomplete="details"
                        class="resize-none border rounded-md w-full h-24 px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        {{ $task->details }}
                    </textarea>
                    <x-input-error :messages="$errors->get('details')" class="mt-2" />
                </div>
                <div class="pt-5  w-1/4">
                    <x-input-label for="date" :value="__('Date')" />
                    <x-text-input id="date" class="block mt-1" type="date" name="date"
                        value="{{ old('date') ?? $task->date }}" required autofocus autocomplete="date" />
                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4 pt-3">
                    <x-primary-button class="ms-4 ">
                        {{ __('Save Task') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
