<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Time Code Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="mb-6">
                <h3 class="text-2xl font-bold">{{ $timeCode->code }}</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $timeCode->description }}</p>
            </div>

            <div class="flex justify-end">
                <x-link-button type="primary" href="{{ route('admin.timecodes.edit', $timeCode->id) }}" class="mr-2">Edit Time Code</x-link-button>
                <x-link-button type="secondary" href="{{ route('admin.timecodes.index') }}">Back to Time Codes</x-link-button>
            </div>
        </x-card>
    </div>
</x-app-layout>
