<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Time Code') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <form action="{{ route('admin.timecodes.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="code" class="block text-gray-700 dark:text-gray-300">Code</label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required
                           class="mt-1 block w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-gray-200">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300">Description</label>
                    <textarea id="description" name="description" required
                              class="mt-1 block w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:text-gray-200">{{ old('description') }}</textarea>
                </div>

                <div class="flex justify-end">
                    <x-link-button type="secondary" href="{{ route('admin.timecodes.index') }}" class="mr-2">Cancel</x-link-button>
                    <x-button type="primary">Create Time Code</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
