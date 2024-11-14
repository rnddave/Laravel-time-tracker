<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Department Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="mb-6">
                <h3 class="text-2xl font-bold">{{ $department->name }}</h3>
                <p class="text-gray-700 dark:text-gray-300">
                    Manager: 
                    @if($department->manager)
                        {{ $department->manager->name }} ({{ $department->manager->email }})
                    @else
                        <span class="text-gray-500">No Manager Assigned</span>
                    @endif
                </p>
            </div>

            <div class="mb-6">
                <h4 class="text-xl font-semibold">Teams in {{ $department->name }}</h4>
                @if($department->teams->count() > 0)
                    <ul class="list-disc list-inside">
                        @foreach($department->teams as $team)
                            <li>
                                <strong>{{ $team->name }}</strong> - 
                                Manager: 
                                @if($team->manager)
                                    {{ $team->manager->name }} ({{ $team->manager->email }})
                                @else
                                    <span class="text-gray-500">No Manager Assigned</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No teams associated with this department.</p>
                @endif
            </div>

            <div class="flex justify-end">
                <x-link-button type="primary" href="{{ route('admin.departments.edit', $department->id) }}" class="mr-2">Edit Department</x-link-button>
                <x-link-button type="secondary" href="{{ route('admin.departments.index') }}">Back to Departments</x-link-button>
            </div>
        </x-card>
    </div>
</x-app-layout>
