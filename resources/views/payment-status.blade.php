<x-app-layout>
    <div id="app">
        <div class="flex gap-12">
            <div class="hidden lg:block">
                <x-checkout-cart
                    class="mt-2 w-1/4"
                    :cart-products="$cartProducts"
                    :invoice-no="$invoiceNo"
                    :cart-total-price="$cartTotalPrice"
                >
                </x-checkout-cart>
            </div>
                <choose-and-pay-component
                    class="lg:w-3/4"
                    :payment="{{json_encode($payment)}}"
                ></choose-and-pay-component>
        </div>

    </div>
</x-app-layout>
