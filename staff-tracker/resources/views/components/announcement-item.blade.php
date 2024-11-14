{{-- resources/views/components/announcement-item.blade.php --}}
@props(['date', 'title', 'message'])

<div class="border-l-4 border-primary-DEFAULT pl-4 py-2">
    <div class="flex justify-between items-start">
        <h3 class="font-semibold text-gray-900 dark:text-white font-sans">{{ $title }}</h3>
        <span class="text-sm text-secondary-DEFAULT dark:text-gray-400">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</span>
    </div>
    <p class="mt-1 text-secondary-DEFAULT dark:text-gray-300">{{ $message }}</p>
</div>