@props(['type' => 'success'])

@php
    $classes = [
        'success' => 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative',
        'error' => 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative',
        'warning' => 'bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative',
        'info' => 'bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative',
    ];
@endphp

<div {{ $attributes->merge(['class' => $classes[$type] ?? $classes['info']]) }} role="alert">
    {{ $slot }}
</div>
