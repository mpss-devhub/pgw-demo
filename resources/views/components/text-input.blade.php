@props(['disabled' => false,'placeholder'=>''])

<input placeholder="{{$placeholder}}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg dark:border-gray-600 dark:placeholder-gray-400 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300']) !!}>
