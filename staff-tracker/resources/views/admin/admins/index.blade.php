<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admins') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6 overflow-visible">
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Admins Management</h2>
                <x-link-button type="primary" href="{{ route('admin.admins.create') }}">Create New Admin</x-link-button>
            </div>

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
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Last Login</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Status</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $admin->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    @if($admin->last_login_at)
                                        {{ $admin->last_login_at->format('d M Y, h:i A') }}
                                    @else
                                        <span class="text-gray-500">Never</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    @if($admin->is_active)
                                        <span class="text-green-500">Active</span>
                                    @else
                                        <span class="text-red-500">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Actions
                                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <a href="{{ route('admin.admins.show', $admin->id) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">View</a>
                                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Edit</a>
                                            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                                            </form>
                                            <form action="{{ route('admin.admins.toggle', $admin->id) }}" method="POST" class="block px-4 py-2 text-sm text-yellow-600 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" onclick="return confirm('{{ $admin->is_active ? 'Deactivate' : 'Activate' }} this admin?')">
                                                    {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-2 px-4 text-center">No admins found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $admins->links() }}
            </div>
        </x-card>
    </div>
</x-app-layout>
