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
           @if(isset($payment))
               <choose-and-pay-component
                   class="lg:w-1/2"
                   :successful-payment="{{$payment}}"
               ></choose-and-pay-component>
           @else
               <choose-and-pay-component
                   class="lg:w-1/2"
                   :payment-id="{{$paymentId}}"
                   :payment-categories-with-payments="{{json_encode($paymentCategoriesWithPayments)}}"
               ></choose-and-pay-component>
           @endif

       </div>

   </div>
</x-app-layout>
