<x-app-layout>

    <div class="flex">
        <div class="w-1/4 py-12 hidden lg:block">
            <div class="w-full">
                <!-- Accordion Container -->
                <div x-data="{ open: false }" class="space-y-2">
                    <!-- Accordion Item 1 -->
                    <div class="bg-gray-300 rounded-lg">
                        <!-- Accordion Header 1 -->
                        <div @click="open = !open" class="p-2 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium">Categories</h3>
                                <svg :class="{ 'transform rotate-180': open, 'transform rotate-0': !open }"
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Accordion Content 1 -->
                        <div x-show="open" class="p-2">
                            <!-- Scrollable Checkbox List -->
                            <div class="max-h-48 overflow-y-auto">
                                <div class="space-y-2">
                                    @foreach ($categories as $category)
                                        <label class="block">
                                            <input type="checkbox" class="form-checkbox h-3 w-3 text-indigo-600" />
                                            <span class="ml-2">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div x-data="{ open: false }" class="space-y-2 mt-2">
                    <!-- Accordion Item 1 -->
                    <div class="bg-gray-300 rounded-lg">
                        <!-- Accordion Header 1 -->
                        <div @click="open = !open" class="p-2 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium">Brands</h3>
                                <svg :class="{ 'transform rotate-180': open, 'transform rotate-0': !open }"
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Accordion Content 1 -->
                        <div x-show="open" class="p-2">
                            <!-- Scrollable Checkbox List -->
                            <div class="max-h-48 overflow-y-auto">
                                <div class="space-y-2">
                                    @foreach ($brands as $brand)
                                        <label class="block">
                                            <input type="checkbox" class="form-checkbox h-3 w-3 text-indigo-600" />
                                            <span class="ml-2">{{ $brand->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="flex justify-end mt-4">
                    <x-primary-button>
                      Filter
                    </x-primary-button>
                </div>
            </div>

        </div>
        <div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 lg:gap-4">
                        @foreach ($products as $product)
                            <div
                                class="max-w-xs flex flex-col justify-between overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                                <div class="py-2">
                                    <h1 class="px-4 text-sm font-bold text-gray-800 uppercase dark:text-white">
                                        {{ $product->name }}
                                    </h1>
                                    <img class="object-cover w-full h-30 lg:h-48 mt-2" src="{{ $product->image_url }}"
                                        alt="{{ $product->name }}">
                                </div>

                                <div>
                                    <p class="px-4 py-2 mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $product->description }}</p>

                                    <div
                                        class="flex items-center flex-col lg:flex-row justify-between px-4 py-2 bg-gray-900">
                                        <h1 class="text-lg font-bold text-white">${{ $product->price }}</h1>
                                        <button
                                            class="px-2 py-1 text-xs font-semibold text-gray-900 uppercase transition-colors duration-300 transform bg-white rounded hover:bg-gray-200 focus:bg-gray-400 focus:outline-none">Add
                                            to cart</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
