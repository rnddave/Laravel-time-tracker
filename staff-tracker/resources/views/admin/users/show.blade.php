<x-app-layout>
    <div class="container mx-auto px-4">
        <x-card>
            <h2 class="text-2xl font-bold mb-6">User Details</h2>

            <div class="mb-6">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                <p><strong>Account Created:</strong> {{ $user->created_at->format('d M Y') }}</p>
                <p><strong>Last Password Change:</strong> 
                    {{ $user->password_changed_at ? $user->password_changed_at->format('d M Y') : 'Never' }}
                </p>
            </div>

            <div class="flex space-x-4">
                <x-link-button type="primary" href="{{ route('admin.users.edit', $user->id) }}">Edit User</x-button>
                <x-link-button type="secondary" href="{{ route('admin.users.index') }}">Back to Users</x-button>
            </div>
        </x-card>
    </div>
</x-app-layout>
