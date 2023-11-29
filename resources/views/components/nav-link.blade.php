@props(['active'])

@php
$classes = ($active ?? false)
            ? 'cursor-pointer px-3 py-2 mt-2 text-gray-100 transition-colors duration-300 transform rounded-md lg:mt-0 bg-gray-500  text-gray-100  hover:bg-gray-600 '
            : 'cursor-pointer px-3 py-2 mt-2 text-gray-100 transition-colors duration-300 transform rounded-md lg:mt-0  hover:bg-gray-400 hover:text-gray-100 ';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
