<x-app-layout>
   <div x-data="{selectedPayment:null}">
       <div class="flex gap-12">
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
           <div class="w-1/2">
               <p class="text-lg font-bold text-gray-800 mt-2 mb-3">Fill in payment information</p>
               <div class=" bg-gray-200 p-1 rounded-md"  x-show="!selectedPayment"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="bg-blue-500 text-white p-4"
               >
                   <p class="text-lg font-bold text-gray-800 mt-2  mx-2">Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">1</span></p>
                   @foreach($paymentCategoriesWithPayments as $category)
                       <div class="p-2 mx-3">
                           <p class="text-sm font-bold">{{$category['paymentType']}}</p>
                           <div class="grid grid-cols-3 px-1 gap-2 rounded-md p-1">
                               @foreach($category['payments'] as $payment)
                                   <div  x-data="{paymentCode:'{{$payment['paymentCode']}}'}"
                                         :class="{'bg-gray-700':selectedPayment.paymentCode===paymentCode}" class="border border-solid border-gray-400 justify-between items-center gap-1 flex  rounded-md dark:text-white" @click="selectedPayment={{json_encode($payment)}}">
                                       <div class="flex justify-start items-center gap-1">
                                           <img class="rounded-md  w-8 h-8 object-cover"  src="{{$payment['logo']}}"/>
                                           <span class="font-medium text-sm" :class="{'text-white':selectedPayment.paymentCode===paymentCode}">{{$payment['paymentName']}}</span>
                                       </div>

                                   </div>
                               @endforeach
                           </div>
                       </div>
                   @endforeach
               </div>
               <div class=" bg-gray-200 p-1 mt-3 mb-20 rounded-md"
                    x-show="selectedPayment"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90">
                   <p class="text-lg font-bold text-gray-800 mt-2  mx-2 flex justify-between">
                       <span>
                           Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">2</span>
                       </span>
                   </p>
                   <div class="p-2">
                       <form method="post" action="{{route('payment.webpay')}}">
                           @csrf
                           <input type="hidden" name="paymentCode" :value="selectedPayment.paymentCode"/>
                           <input type="hidden" name="paymentId" value="{{$paymentId}}"/>
                           <div class="p-2 space-y-6">
                               <div class="flex flex-col gap-2">
                                   <template x-for="[key, value] in Object.entries(selectedPayment.input)">
                                       <div class="mb-4" :class="{'hidden':value.required==='false'}">
                                           <label class="block text-gray-700 text-sm font-bold mb-2" x-text="value.label"></label>
                                           <input :name="key" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" x-bind:value="value.value" x-bind:type="value.type" :placeholder="'Enter ' + key">
                                       </div>
                                   </template>
                               </div>
                           </div>
                       </form>
                   </div>
               </div>
               <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                   <button  @click="selectedPayment=null" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                   <input type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" value="Continue"/>
               </div>
           </div>
       </div>


   </div>
</x-app-layout>
