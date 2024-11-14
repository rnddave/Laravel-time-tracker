<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Departments</h2>
                <x-link-button type="primary" href="{{ route('admin.departments.create') }}">Create New Department</x-link-button>
            </div>

            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif

            @if($errors->any())
                <x-alert type="danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Name</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Manager</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $department->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    @if($department->manager)
                                        {{ $department->manager->name }}
                                    @else
                                        <span class="text-gray-500">No Manager Assigned</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    <x-link-button type="secondary" href="{{ route('admin.departments.show', $department->id) }}" class="mr-2">View</x-link-button>
                                    <x-link-button type="primary" href="{{ route('admin.departments.edit', $department->id) }}" class="mr-2">Edit</x-link-button>
                                    <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="danger" onclick="return confirm('Are you sure you want to delete this department?')">Delete</x-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-2 px-4 text-center">No departments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $departments->links() }}
            </div>
        </x-card>
    </div>
</x-app-layout>
