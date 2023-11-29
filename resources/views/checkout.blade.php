<x-app-layout>
   <div id="app">
       <div class="flex gap-12">
           <div class="hidden lg:block">
               <x-checkout-cart
                   class="mt-2 w-1/5"
                   :cart-products="$cartProducts"
                   :cart-total-price="$cartTotalPrice"
                   :invoice-no="$payment->invoice_id"
               >
               </x-checkout-cart>
           </div>
           <choose-and-pay-component
               class="lg:w-4/5 w-full"
               payment-id="{{$payment->id}}"
               :payment-categories-with-payments="{{json_encode($paymentCategoriesWithPayments)}}"
           ></choose-and-pay-component>
       </div>

   </div>
</x-app-layout>
