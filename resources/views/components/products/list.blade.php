@props(['products'])

<div
    class="overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 lg:gap-10 ">
    @foreach ($products as $product)
        <div
            class="max-w-xs flex flex-col justify-between overflow-hidden  rounded-lg shadow-lg transition-colors duration-300">
                <img class="object-cover w-full  h-[200px]" src="{{ $product->image_url }}"
                     alt="{{ $product->name }}">

            <div>
                <div class="py-1 min-h-[50px] lg:min-h-[50px]  flex flex-col items-start justify-center">
                    <h1 class="px-2 text-sm font-bold text-white uppercase ">
                        {{ $product->name }}
                    </h1>
                </div>
                <a class="hover:text-purple-700  px-2 text-sm" href="{{route('home').'?brands='.$product->brand->name}}">{{$product->brand->name}}</a>

                <div
                    class="flex py-2 items-center  flex-col lg:flex-row justify-between px-4 bg-gray-100">
                    <h1 class="text-sm font-bold">{{ $product->price }} MMK</h1>
                    <form method="post" action="{{route('cart.add')}}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="submit"
                               value="Add Cart"
                               class="mb-1 lg:mb-0 cursor-pointer px-2 py-1 text-xs font-semibold  uppercase bg-purple-700 text-white rounded hover:bg-purple-800 focus:bg-purple-400 focus:outline-none"/>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
