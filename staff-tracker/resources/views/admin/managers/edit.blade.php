<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Manager Assignment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <!-- Display Validation Errors -->
            @if ($errors->any())
                <x-alert type="error">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <form method="POST" action="{{ route('admin.managers.update', $staff->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="staff_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Staff Member</label>
                    <input type="text" id="staff_name" name="staff_name" value="{{ $staff->name }}" readonly class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                </div>

                <div class="mb-4">
                    <label for="manager_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Manager</label>
                    <select id="manager_id" name="manager_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">-- No Manager --</option>
                        @foreach($potentialManagers as $manager)
                            <option value="{{ $manager->id }}" {{ (old('manager_id', $staff->manager_id) == $manager->id) ? 'selected' : '' }}>
                                {{ $manager->name }} ({{ $manager->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('manager_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <x-button type="primary" class="mr-2">Save Changes</x-button>
                    <x-link-button type="secondary" href="{{ route('admin.managers.index') }}">Cancel</x-link-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
