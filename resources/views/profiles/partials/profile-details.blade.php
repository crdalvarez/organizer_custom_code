<div class="p-2 rounded-md">
    <div class="flex items-center w-1/2">
        <div class="font-bold">Aditional Information:</div>
    </div>
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 grid grid-cols-2 gap-4">
        <div>
            <label for="experience" class="block text-gray-700 font-bold mb-2">Experience:</label>
            <p id="experience" class="text-gray-900">{{ $user->profile->experience }}</p>
        </div>
        <div>
            <label for="skills" class="block text-gray-700 font-bold mb-2">Skills: </label>
            <p id="skills" class="text-gray-900">{{ $user->profile->skills }}</p>
        </div>
        <div>
            <label for="address" class="block text-gray-700 font-bold mb-2">Address</label>
            <p id="address" class="text-gray-900">{{ $user->profile->address }}</p>
        </div>
        <div>
            <label for="phone" class="block text-gray-700 font-bold mb-2">Phone:</label>
            <p id="phone" class="text-gray-900">{{ $user->profile->phone }}</p>
        </div>
        <div>
            <label for="birthdate" class="block text-gray-700 font-bold mb-2">Birth date:</label>
            <p id="birthdate" class="text-gray-900">{{ $user->profile->birthdate }}</p>
        </div>
    </div>

</div>
