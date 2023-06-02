<x-app-layout>
  <div class="flex gap-12">
      <div class="w-2/3">
          @foreach($paymentCategoriesWithPayments as $category)
              <div class="p-2">
                  <p class="text-lg font-bold text-gray-800">{{$category['paymentType']}}</p>
                  <div class="p-1 grid grid-cols-6 my-3 gap-2 bg-gray-300 rounded-md p-3">
                      @foreach($category['payments'] as $payment)
                          <div class="rounded-md dark:text-white">
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
</x-app-layout>
