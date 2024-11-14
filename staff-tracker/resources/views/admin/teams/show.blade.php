<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="mb-6">
                <h3 class="text-2xl font-bold">{{ $team->name }}</h3>
                <p class="text-gray-700 dark:text-gray-300">
                    Department: {{ $team->department->name }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    Manager: 
                    @if($team->manager)
                        {{ $team->manager->name }} ({{ $team->manager->email }})
                    @else
                        <span class="text-gray-500">No Manager Assigned</span>
                    @endif
                </p>
            </div>

            <div class="mb-6">
                <h4 class="text-xl font-semibold">Team Members</h4>
                @if($team->users->count() > 0)
                    <ul class="list-disc list-inside">
                        @foreach($team->users as $user)
                            <li>{{ $user->name }} ({{ $user->email }})</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No team members assigned to this team.</p>
                @endif
            </div>

            <div class="flex justify-end">
                <x-link-button type="primary" href="{{ route('admin.teams.edit', $team->id) }}" class="mr-2">Edit Team</x-link-button>
                <x-link-button type="secondary" href="{{ route('admin.teams.index') }}">Back to Teams</x-link-button>
            </div>
        </x-card>
    </div>
</x-app-layout>
