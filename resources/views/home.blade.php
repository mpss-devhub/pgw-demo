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
                    <x-products.list :products="$products"/>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
