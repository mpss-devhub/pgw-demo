<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Cart
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-2 flex flex-col gap-1 w-1/3 bg-gray-300 rounded-sm mb-10">
                @foreach($cartProducts as $product)
                    <div  class="flex justify-between px-2 py-1">
                        <span>{{$product->name}}</span>
                        <span>{{$product->price}}</span>
                    </div>
                @endforeach
                <div class="flex justify-between px-2 py-1">
                    <span class="font-bold">Total</span>
                    <span>$30000</span>
                </div>
                <hr class="border-b border-gray-600 mb-2 mt-3">
                <div class="flex justify-end">
                    <x-primary-button class="rounded-sm py-0">
                        <input type="button"  value="Checkout"/>
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
