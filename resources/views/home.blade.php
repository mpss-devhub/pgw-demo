<x-app-layout>
    <div class="relative" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div  x-show="isCartShown" class="fixed inset-0 bg-black bg-opacity-60 transition-opacity">

        </div>
        <div class="flex flex-col lg:flex-row"  @click="isCartShown=false">
            <div class="lg:w-1/4 py-4 lg:py-12">
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
                    <span class="bg-gray-300 rounded-md px-20 py-2">No products were found.</span>
                </div>
            @else
                <div class="py-4 lg:py-12">
                    <div class="max-w-7xl sm:pl-6 lg:pl-8">
                        <x-products.list :products="$products"/>
                        <div class="mt-10 w-100 flex justify-start">
                            <div>
                                {{$products->withQueryString()->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div x-show="isCartShown"  x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" x-cloak class="fixed inset-0 overflow-hidden z-50">
            <x-products.cart :cartProducts="$cartProducts" :total="$cartTotalPrice"></x-products.cart>
        </div>
    </div>
</x-app-layout>
