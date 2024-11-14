<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Users</h2>
                <x-link-button type="primary" href="{{ route('admin.users.create') }}">Create New User</x-link-button>
            </div>

            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif

            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex items-center space-x-4">
                <!-- Search Input -->
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200">
                </div>
                <!-- Active/Inactive Filter -->
                <div>
                    <select name="status" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <!-- Filter Button -->
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">Filter</button>
                </div>
            </form>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Name</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Status</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Role</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    {{ $user->name }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    @if($user->is_active)
                                        <span class="text-green-500">Active</span>
                                    @else
                                        <span class="text-red-500">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    <x-link-button type="secondary" href="{{ route('admin.users.show', $user->id) }}" class="mr-2">View</x-link-button>
                                    <x-link-button type="primary" href="{{ route('admin.users.edit', $user->id) }}" class="mr-2">Edit</x-link-button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</x-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-2 px-4 text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </x-card>
    </div>
</x-app-layout>
