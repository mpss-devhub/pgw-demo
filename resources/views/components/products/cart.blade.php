@props(['cartProducts','total'])
<div class="absolute inset-0 overflow-hidden">
    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div class="pointer-events-auto w-screen max-w-md">
            <div @click.away="isCartShown=false" class="flex h-full flex-col overflow-y-scroll dark:bg-gray-800 bg-gray-300 shadow-xl">
                <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                    <div class="flex items-start justify-between">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-300" id="slide-over-title">Shopping cart</h2>
                        <div class="ml-3 flex h-7 items-center">
                            <button type="button" @click="isCartShown=false" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Close panel</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                @forelse($cartProducts as $product)
                                    <li class="flex py-6">
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

                                                <div class="flex">
                                                    <form method="POST" action="{{route('cart.remove')}}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$product->first()->id}}">
                                                        <input type="submit" class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer" value="Remove"/>
                                                    </form>
                                                </div>
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
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                    <div class="flex justify-between text-base font-medium text-gray-900 dark:text-gray-300">
                        <p>Subtotal</p>
                        <p>${{$total}}</p>
                    </div>
                    <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                    <div class="mt-6">
                        <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</a>
                    </div>
                    <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                        <p>
                            or
                            <button @click="isCartShown=false" type="button" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Continue Shopping
                                <span aria-hidden="true"> &rarr;</span>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
