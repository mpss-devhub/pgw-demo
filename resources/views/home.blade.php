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
        @if($products->count()<=0)
            <div class="w-full flex content-center justify-center items-center">
                <span class="bg-gray-300 rounded-md px-20 py-2">No shoes were found.</span>
            </div>
        @else
            <div class="py-12">
                <div class="max-w-7xl sm:pl-6 lg:pl-8">
                    <x-products.list :products="$products"/>
                </div>
            </div>
        @endif
    </div>

</x-app-layout>
