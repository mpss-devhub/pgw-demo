<template>
    <div>
        <div class="p-2 flex gap-8 flex-col justify-center items-center" v-if="successfulPayment">
            <div class="font-bold text-green-500">
                <div class="flex flex-col gap-2 w-full items-center">
                    <div class="flex flex-col text-gray-900 gap-2 justify-center items-center p-5">
                        <span class="flex justify-center items-center w-10 h-10 bg-green-800 rounded-full text-white"><i class="fa fa-check fa-lg"></i></span>
                        <span class="text-xl font-bold">Payment successful</span>
                    </div>

                    <div class="mt-5 text-sm">
                        <div class="flex justify-between">
                            <div>Invoice Number</div>
                            <div>{{successfulPayment.invoice_id}}</div>
                        </div>
                        <div class="flex justify-between">
                            <div>Amount</div>
                            <div>{{successfulPayment.amount}}</div>
                        </div>
                        <div class="flex justify-between">
                            <div>Paid at</div>
                            <div>{{successfulPayment.created_at}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 flex gap-8 flex-col justify-center items-center" v-if="!successfulPayment">
            <div class="flex flex-col gap-2 w-full items-center">
                <div class="flex flex-col text-gray-900 gap-2 justify-center items-center p-5">
                    <span class="flex justify-center items-center w-10 h-10 bg-red-800 rounded-full text-white"><i class="fa fa-exclamation-circle fa-lg"></i></span>
                    <span class="text-xl font-bold">Payment fail</span>
                </div>

                <div class="mt-5 flex justify-center bg-red-200 rounded-md px-3 py-10">
                    <span>
                        Something went wrong with payment transaction.
                    </span>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-2 p-2 mt-5">
            <a href="/home"  class="px-6 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50 cursor-pointer">
                Continue Shopping
            </a>
            <a  v-if="!successfulPayment" href="/payment/direct-checkout"  class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Retry
            </a>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    successfulPayment:{
        type:Object,
        required:true,
        default:null
    }
})
</script>
