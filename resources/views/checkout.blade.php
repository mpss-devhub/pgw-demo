<x-app-layout>
   <div x-data="{selectedPayment:null}">
       <div tabindex="-1" aria-hidden="true"  :class="{ 'hidden': !selectedPayment, 'block': !selectedPayment }" class="bg-gray-800 flex justify-center items-center bg-opacity-70 fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
           <div class="relative w-full max-w-2xl max-h-full">
               <!-- Modal content -->
               <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                   <!-- Modal header -->
                   <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                       <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                           Pay with <span x-text="selectedPayment.paymentName"></span>
                       </h3>
                       <button @click="selectedPayment=null" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                           <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                           <span class="sr-only">Close modal</span>
                       </button>
                   </div>
                   <!-- Modal body -->
                   <div class="p-6 space-y-6">
                       <div class="flex flex-col gap-2">
                           <div x-for="input in selectedPayment['input']">
                               <span x-text="input"></span>
                           </div>
                       </div>
                   </div>
                   <!-- Modal footer -->
                   <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                       <button  @click="selectedPayment=null" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                       <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Continue</button>
                   </div>
               </div>
           </div>
       </div>
       <div class="flex gap-12">
           <div class="w-2/3">
               @foreach($paymentCategoriesWithPayments as $category)
                   <div class="p-2">
                       <p class="text-lg font-bold text-gray-800">{{$category['paymentType']}}</p>
                       <div class="p-1 grid grid-cols-6 my-3 gap-2 bg-gray-300 rounded-md p-3">
                           @foreach($category['payments'] as $payment)
                               <div class="rounded-md dark:text-white" @click="selectedPayment={{json_encode($payment)}}">
                                   <img width="80" height="80" src="{{$payment['logo']}}"/>
                                   <span class="font-bold text-sm">{{$payment['paymentName']}}</span>
                               </div>
                           @endforeach
                       </div>
                   </div>
               @endforeach
           </div>
           <div class="mt-2 w-1/3">
               <p class="text-lg font-bold text-gray-800 mb-3">Your order</p>

               <ul role="list" class="divide-y divide-gray-200 rounded-md bg-gray-300 p-2">
                   @forelse($cartProducts as $product)
                       <li class="flex py-2">
                           <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                               <img src="{{$product->first()->image_url}}" alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt." class="h-full w-full object-cover object-center">
                           </div>

                           <div class="ml-4 flex flex-1 flex-col">
                               <div>
                                   <div class="flex justify-between text-base font-medium text-gray-900 dark:text-gray-300">
                                       <h3>
                                           <a href="#">{{$product->first()->name}}</a>
                                       </h3>
                                       <p class="ml-4">${{$product->sum('price')}}</p>
                                   </div>
                               </div>
                               <div class="flex flex-1 items-end justify-between text-sm">
                                   <p class="text-gray-500">Qty {{$product->count()}}</p>
                               </div>
                           </div>
                       </li>
                   @empty
                       <li>
                           <div class="p-2 bg-gray-200 mt-10 rounded-md">
                               No shoes were found in the cart.
                           </div>
                       </li>
                   @endforelse
               </ul>
               <div class="p-2 flex justify-between mt-2 rounded-md bg-gray-300">
                   <div class="font-bold">Total</div>
                   <div>${{$cartTotalPrice}}</div>
               </div>
           </div>
       </div>
   </div>
</x-app-layout>
