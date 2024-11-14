<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Department') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300">Department Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $department->name) }}" required
                           class="mt-1 block w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-gray-200">
                </div>

                <div class="mb-4">
                    <label for="manager_id" class="block text-gray-700 dark:text-gray-300">Manager</label>
                    <select id="manager_id" name="manager_id"
                            class="mt-1 block w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-gray-200">
                        <option value="">-- Select Manager --</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}" {{ (old('manager_id', $department->manager_id) == $manager->id) ? 'selected' : '' }}>
                                {{ $manager->name }} ({{ $manager->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <x-link-button type="secondary" href="{{ route('admin.departments.index') }}" class="mr-2">Cancel</x-link-button>
                    <x-button type="primary">Update Department</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
