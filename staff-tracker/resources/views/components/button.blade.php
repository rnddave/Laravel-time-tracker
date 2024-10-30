@props(['type' => 'primary', 'size' => 'md'])

@php
    // Define size classes
    $sizeClasses = [
        'sm' => 'py-1 px-3 text-sm',
        'md' => 'py-2 px-4 text-base',
        'lg' => 'py-3 px-6 text-lg',
    ];

    // Define type-based classes
    $typeClasses = [
        'primary' => 'bg-blue-500 hover:bg-blue-600 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-600 text-white',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white',
    ];

    // Assign classes based on type and size
    $classes = $sizeClasses[$size] ?? $sizeClasses['md'];
    $classes .= ' ' . ($typeClasses[$type] ?? $typeClasses['primary']);
@endphp

<button {{ $attributes->merge(['class' => "font-semibold rounded focus:outline-none focus:ring-2 focus:ring-opacity-75 $classes"]) }}>
    {{ $slot }}
</button>
