<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Time Codes') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Time Codes</h2>
                <x-link-button type="primary" href="{{ route('admin.timecodes.create') }}">Create New Time Code</x-link-button>
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
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Code</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Description</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($timeCodes as $timeCode)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $timeCode->code }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $timeCode->description }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                    <x-link-button type="secondary" href="{{ route('admin.timecodes.show', $timeCode->id) }}" class="mr-2">View</x-link-button>
                                    <x-link-button type="primary" href="{{ route('admin.timecodes.edit', $timeCode->id) }}" class="mr-2">Edit</x-link-button>
                                    <form action="{{ route('admin.timecodes.destroy', $timeCode->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="danger" onclick="return confirm('Are you sure you want to delete this time code?')">Delete</x-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-2 px-4 text-center">No time codes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $timeCodes->links() }}
            </div>
        </x-card>
    </div>
</x-app-layout>
