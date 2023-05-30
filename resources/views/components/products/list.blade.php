@props(['products'])

<div
    class="overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 lg:gap-4">
    @foreach ($products as $product)
        <div
            class="max-w-xs flex flex-col justify-between overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 hover:bg-green-400 dark:hover:bg-green-600 transition-colors duration-300">
            <div class="py-2">
                <h1 class="px-2 text-sm font-bold text-gray-800 uppercase dark:text-white">
                    {{ $product->name }}
                </h1>
                <a class="dark:hover:text-blue-700 hover:text-blue-700 dark:text-white px-2 text-sm" href="{{route('home').'?brands='.$product->brand->name}}">{{$product->brand->name}}</a>

                <img class="object-cover w-full h-30 lg:h-48 mt-2" src="{{ $product->image_url }}"
                     alt="{{ $product->name }}">
            </div>

            <div>
{{--                <p class="px-4 py-2 mt-1 text-sm text-gray-600 dark:text-gray-400">--}}
{{--                    {{ $product->description }}</p>--}}
                <div class="flex flex-wrap gap-1 mb-2 text-white px-1">
                    @foreach($product->categories as $category)
                        <p class="text-xs px-2 whitespace-nowrap hover:bg-blue-500 dark:hover:bg-blue-950  bg-blue-400 dark:bg-blue-800 rounded-md">
                            <a  href="{{route('home').'?categories='.$category->name}}">
                            {{$category->name}}
                            </a>
                        </p>
                    @endforeach
                </div>
                <div
                    class="flex  items-center flex-col lg:flex-row justify-between px-4 py-2 bg-gray-600 dark:bg-gray-900">
                    <h1 class="text-lg font-bold text-white mb-1 lg:mb-0">${{ $product->price }}</h1>
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
