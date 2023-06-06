<x-app-layout>
    <div class="flex flex-col justify-center content-center">
        @if(isset($payment))
            <div class="p-6 bg-green-300">
                <span>Your payment has been received successfully.</span>
                <i class="fa fa-thumbs-up"></i>
            </div>
        @else
            <div class="p-6 bg-red-300">
                <span>Something went wrong with your payment.</span>
                <i class="fa fa-thumbs-down"></i>
            </div>
        @endif
    </div>
</x-app-layout>
