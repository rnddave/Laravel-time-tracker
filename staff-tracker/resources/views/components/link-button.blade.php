@props(['type' => 'primary', 'href' => '#'])

@php
    $classes = 'font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-opacity-75 inline-block ';
    $classes .= match($type) {
        'primary' => 'bg-blue-500 hover:bg-blue-600 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-600 text-white',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white',
        default => 'bg-blue-500 hover:bg-blue-600 text-white',
    };
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
