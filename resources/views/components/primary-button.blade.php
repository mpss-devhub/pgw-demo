<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-6 py-1 text-sm font-medium tracking-wide text-white capitalize bg-purple-500 rounded-lg hover:bg-purple-400 focus:outline-none focus:ring focus:ring-purple-300 focus:ring-opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>
