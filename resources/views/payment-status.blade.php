<x-app-layout>
    <div class="flex  justify-center items-center w-full h-full mt-20">
        @if(isset($payment))
            <div class="flex flex-col gap-2 w-full items-center">
                <div class="w-2/3 flex flex-col text-gray-900 gap-2 justify-center items-center p-5">
                    <span class="flex justify-center items-center w-10 h-10 bg-green-800 rounded-full text-white"><i class="fa fa-check fa-lg"></i></span>
                    <span class="text-xl font-bold">Payment successful</span>
                </div>

                <div class="w-1/3  mt-5">
                    <div class="flex justify-between">
                        <div>Invoice Number</div>
                        <div>{{$payment->invoice_id}}</div>
                    </div>
                    <div class="flex justify-between">
                        <div>Amount</div>
                        <div>{{$payment->amount}}</div>
                    </div>
                    <div class="flex justify-between">
                        <div>Paid at</div>
                        <div>{{$payment->created_at}}</div>
                    </div>
                </div>
            </div>
        @else
            <div class="flex flex-col gap-2 w-full items-center">
                <div class="w-2/3 flex flex-col text-gray-900 gap-2 justify-center items-center p-5">
                    <span class="flex justify-center items-center w-10 h-10 bg-red-800 rounded-full text-white"><i class="fa fa-exclamation-circle fa-lg"></i></span>
                    <span class="text-xl font-bold">Payment fail</span>
                </div>

                <div class="w-1/3  mt-5 flex justify-center bg-red-200 rounded-md px-3 py-10">
                    <span>
                        Something went wrong with payment transaction.
                    </span>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
