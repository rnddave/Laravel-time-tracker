<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manager-Staff Relationship Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <!-- Success Message -->
            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif

            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.managers.index') }}" class="mb-4">
                <div class="flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email" class="flex-grow px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200">
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-r-md">Search</button>
                </div>
            </form>

            <!-- Managers Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Staff Name</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Email</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Manager</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffMembers as $staff)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $staff->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $staff->email }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    @if($staff->manager)
                                        {{ $staff->manager->name }}
                                    @else
                                        <span class="text-gray-500">No Manager Assigned</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    <!-- Edit Button -->
                                    <x-link-button type="secondary" href="{{ route('admin.managers.edit', $staff->id) }}" class="mr-2">Edit</x-link-button>

                                    <!-- Remove Button (Visible Only If Manager Is Assigned) -->
                                    @if($staff->manager)
                                        <form action="{{ route('admin.managers.destroy', $staff->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="danger" onclick="return confirm('Are you sure you want to remove the manager?')">Remove</x-button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-2 px-4 text-center">No staff members found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $staffMembers->links() }}
            </div>
        </x-card>
    </div>
</x-app-layout>
