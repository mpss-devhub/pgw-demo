<x-app-layout>
    <div id="app">
        <div class="flex gap-12">
            <div class="hidden lg:block">
                <x-checkout-cart
                    class="mt-2 w-1/3"
                    :cart-products="$cartProducts"
                    :cart-total-price="$cartTotalPrice"
                >
                </x-checkout-cart>
            </div>
                <choose-and-pay-component
                    class="lg:w-1/2 w-full"
                    :payment="{{json_encode($payment)}}"
                ></choose-and-pay-component>
        </div>

    </div>
</x-app-layout>
