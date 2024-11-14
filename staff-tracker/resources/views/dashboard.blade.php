<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Timesheets Awaiting Approval (Placeholder) -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Timesheets Awaiting Approval</h3>
                    <p class="text-gray-500 dark:text-gray-400">This section will display timesheets that need your approval.</p>
                    <!-- Future: Implement timesheets list here -->
                </div>

                <!-- Admin Log -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Recent Admin Actions</h3>
                    <div class="overflow-y-auto max-h-80">
                        <ul class="space-y-2">
                            @forelse(\App\Models\LogEntry::latest()->take(20)->get() as $log)
                                <li class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $log->message }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                                </li>
                            @empty
                                <li class="text-gray-500 dark:text-gray-400">No admin actions logged yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Announcements Component (Placeholder) -->
            <div class="mt-6">
                <h3 class="text-lg font-bold mb-4">Announcements</h3>
                <p class="text-gray-500 dark:text-gray-400">This section will display system announcements and maintenance updates.</p>
                <!-- Future: Implement announcements here -->
            </div>
        </x-card>
    </div>
</x-app-layout>
