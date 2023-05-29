<x-app-layout>

    <div class="flex">
        <div class="w-1/4 py-12 hidden lg:block">
            <x-products.filter
                :brands="$brands"
                :categories="$categories"
                :categoriesParam="$categoriesParam"
                :brandsParam="$brandsParam"
                :openedTabs="$openedFilterTabs"
            />
        </div>
        <div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 lg:gap-4">
                        @foreach ($products as $product)
                            <div
                                class="max-w-xs flex flex-col justify-between overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 hover:bg-green-400 transition-colors duration-300">
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
