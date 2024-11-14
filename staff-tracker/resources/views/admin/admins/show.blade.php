<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="mb-6">
                <h3 class="text-lg font-bold">{{ $admin->name }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $admin->email }}</p>
            </div>

            <div class="mb-4">
                <strong>Status:</strong>
                @if($admin->is_active)
                    <span class="text-green-500">Active</span>
                @else
                    <span class="text-red-500">Inactive</span>
                @endif
            </div>

            <div class="mb-4">
                <strong>Last Login:</strong>
                @if($admin->last_login_at)
                    {{ $admin->last_login_at->format('d M Y, h:i A') }}
                @else
                    <span class="text-gray-500">Never</span>
                @endif
            </div>

            <!-- Future: Outstanding Timesheets -->
            {{-- <div class="mb-4">
                <strong>Outstanding Timesheets:</strong>
                <!-- Placeholder for future functionality -->
                <span class="text-gray-500">N/A</span>
            </div> --}}

            <div class="flex space-x-4">
                <x-link-button type="primary" href="{{ route('admin.admins.edit', $admin->id) }}">Edit</x-link-button>
                <x-link-button type="secondary" href="{{ route('admin.admins.index') }}">Back to Admins</x-link-button>
            </div>
        </x-card>
    </div>
</x-app-layout>
