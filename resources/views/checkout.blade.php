<x-app-layout>
   <div id="app">
       <div class="flex gap-12">
           <x-checkout-cart
               class="mt-2 w-1/3"
               :cart-products="$cartProducts"
               :cart-total-price="$cartTotalPrice"
           >
           </x-checkout-cart>
           <choose-and-pay-component
               class="w-1/2"
               :payment-id="{{$paymentId}}"
               :payment-categories-with-payments="{{json_encode($paymentCategoriesWithPayments)}}"
           ></choose-and-pay-component>
       </div>

   </div>
</x-app-layout>
