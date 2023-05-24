@props(['active'])

@php
$classes = ($active ?? false)
            ? 'cursor-pointer px-3 py-2 mx-3 mt-2 text-gray-700 transition-colors duration-300 transform rounded-md lg:mt-0 bg-gray-900 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700'
            : 'cursor-pointer px-3 py-2 mx-3 mt-2 text-gray-700 transition-colors duration-300 transform rounded-md lg:mt-0 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
