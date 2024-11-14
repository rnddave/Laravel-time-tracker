<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">User Information</h2>
                <x-link-button type="primary" href="{{ route('admin.users.edit', $user->id) }}">Edit User</x-link-button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                    <p><strong>Status:</strong> 
                        @if($user->is_active)
                            <span class="text-green-500">Active</span>
                        @else
                            <span class="text-red-500">Inactive</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p><strong>Department:</strong> 
                        @if($user->department)
                            <a href="{{ route('admin.departments.show', $user->department->id) }}" class="text-blue-500 hover:underline">
                                {{ $user->department->name }}
                            </a>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
                    </p>
                    <p><strong>Team:</strong> 
                        @if($user->team)
                            <a href="{{ route('admin.teams.show', $user->team->id) }}" class="text-blue-500 hover:underline">
                                {{ $user->team->name }}
                            </a>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
                    </p>
                    <p><strong>Manager:</strong> 
                        @if($user->manager)
                            {{ $user->manager->name }}
                        @else
                            <span class="text-gray-500">No Manager Assigned</span>
                        @endif
                    </p>
                    <p><strong>Last Login:</strong> 
                        @if($user->last_login_at)
                            {{ $user->last_login_at->format('d M Y, h:i A') }}
                        @else
                            <span class="text-gray-500">Never</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <x-link-button type="secondary" href="{{ route('admin.users.index') }}">Back to Users</x-link-button>
            </div>
        </x-card>
    </div>
</x-app-layout>
