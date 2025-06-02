@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center justify-center px-2 py-2 text-light bg-accent rounded-lg hover:bg-primary focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'flex items-center justify-center px-2 py-1 text-light bg-primary-soft rounded-lg hover:bg-accent hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
