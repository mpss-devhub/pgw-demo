<template>
    <div>
        <div class="p-8 flex gap-8 flex-col justify-center items-center" v-if="isPaymentSuccess && payment">
            <div class="font-bold text-green-500">
                <div class="flex flex-col gap-2 w-full items-center">
                    <div class="w-2/3 flex flex-col text-gray-900 gap-2 justify-center items-center p-5">
                        <span class="flex justify-center items-center w-10 h-10 bg-green-800 rounded-full text-white"><i class="fa fa-check fa-lg"></i></span>
                        <span class="text-xl font-bold">Payment successful</span>
                    </div>

                    <div class="w-1/3  mt-5">
                        <div class="flex justify-between">
                            <div>Invoice Number</div>
                            <div>{{payment.invoice_id}}</div>
                        </div>
                        <div class="flex justify-between">
                            <div>Amount</div>
                            <div>{{payment.amount}}</div>
                        </div>
                        <div class="flex justify-between">
                            <div>Paid at</div>
                            <div>{{payment.created_at}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-8 flex gap-8 flex-col justify-center items-center" v-if="isPaymentSuccess!==null && !isPaymentSuccess">
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
        </div>
    </div>
</template>
<script setup>

import {onMounted, ref} from "vue";

const props = defineProps({
    paymentId:{
        type:String,
        required:true
    }
})
const emit = defineEmits(['onPaymentResultKnown'])

const isPaymentSuccess = ref(null)

const pollingInterval = 1000; // 1 second
const totalDuration = 3 * 60 * 1000; // 3 minutes in milliseconds
let startTime = Date.now();
const isWaitingDone = ref(false)
const payment = ref(null)

onMounted(async () => {
    await pollIfPaymentSuccess()
})

async  function pollIfPaymentSuccess(){
    const url = `/api/payments/${props.paymentId}/status`
    const response = await fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })

    const responseData = await response.json();

    const elapsedTime = Date.now() - startTime;
    if (elapsedTime < totalDuration && !isWaitingDone.value) {
        // Continue polling after a certain delay
        setTimeout(async () => await pollIfPaymentSuccess(), pollingInterval);
    } else {
        console.log('Polling completed.');
    }

    if(responseData.status==="success"){
        isPaymentSuccess.value = true
        isWaitingDone.value = true
        payment.value = responseData.data
        emit('onPaymentResultKnown')
    }else if(responseData.status==="failed"){
        isPaymentSuccess.value = false
        isWaitingDone.value = true
        emit('onPaymentResultKnown')
    }
}
</script>
