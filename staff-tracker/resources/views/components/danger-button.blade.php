<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg shadow-red-500/30 transform active:scale-95 transition-all duration-200 ease-in-out']) }}>
    {{ $slot }}
</button>
