<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Results for: ') }} "{{ $query }}"
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Name</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Email</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Role</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $user->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    @if($user->role !== 'admin')
                                        <x-link-button type="secondary" href="{{ route('admin.users.show', $user->id) }}" class="mr-2">View</x-link-button>
                                        <x-link-button type="primary" href="{{ route('admin.users.edit', $user->id) }}" class="mr-2">Edit</x-link-button>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</x-button>
                                        </form>
                                    @else
                                        <x-link-button type="secondary" href="{{ route('admin.admins.edit', $user->id) }}" class="mr-2">Edit</x-link-button>
                                        <form action="{{ route('admin.admins.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="danger" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</x-button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-2 px-4 text-center">No users found matching your query.</td>
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
