@props(['products'])

<div
    class="overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 lg:gap-4">
    @foreach ($products as $product)
        <div
            class="max-w-xs flex flex-col justify-between overflow-hidden bg-gray-300 rounded-lg shadow-lg dark:bg-gray-800 hover:bg-green-400 dark:hover:bg-green-800 transition-colors duration-300">
            <div class="py-2 min-h-[70px] lg:min-h-[60px  flex flex-col items-start justify-center">
                <h1 class="px-2 text-sm font-bold text-gray-800 uppercase dark:text-white">
                    {{ $product->name }}
                </h1>
            </div>


                <img class="object-cover w-full  h-[200px]" src="{{ $product->image_url }}"
                     alt="{{ $product->name }}">

            <div>
                <a class="dark:hover:text-blue-300 hover:text-blue-700 dark:text-white px-2 text-sm" href="{{route('home').'?brands='.$product->brand->name}}">{{$product->brand->name}}</a>

                <div
                    class="flex py-2 items-center  flex-col lg:flex-row justify-between px-4 bg-gray-600 dark:bg-gray-900">
                    <h1 class="text-sm font-bold text-white">{{ $product->price }} MMK</h1>
                    <form method="post" action="{{route('cart.add')}}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="submit"
                               value="Add Cart"
                               class="mb-1 lg:mb-0 px-2 py-1 text-xs font-semibold text-gray-900 uppercase transition-colors duration-300 transform bg-gray-700 text-white rounded hover:bg-gray-800 focus:bg-gray-400 focus:outline-none"/>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
