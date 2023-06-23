<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-6 py-2 text-sm font-medium tracking-wide text-white capitalize bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>
