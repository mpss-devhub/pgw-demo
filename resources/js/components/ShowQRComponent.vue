<template>
    <div>
        <div>
            <div class=" bg-gray-200 p-1 mt-3 mb-20 rounded-md">
                <p class="text-lg font-bold text-gray-800 mt-2  mx-2 flex justify-between">
                       <span>
                           Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">3</span>
                       </span>
                </p>
                <div class="p-8 flex gap-8 flex-col justify-center items-center" v-if="isPaymentSuccess===null">
                        <div class="font-bold">Scan this QR Image from your wallet to finish payment.</div>
                        <img :src="qrImageUrl" width="300" height="300"/>
                </div>
                <div class="p-8 flex gap-8 flex-col justify-center items-center" v-else-if="isPaymentSuccess">
                    <div class="font-bold text-green-500">Payment successfully received.</div>
                </div>
                <div class="p-8 flex gap-8 flex-col justify-center items-center" v-else>
                    <div class="font-bold text-red-500">Payment timeout or unsuccessful payment.</div>
                </div>

            </div>
        </div>
    </div>
</template>
<script setup>

import {onMounted,ref} from "vue";

const props = defineProps({
    qrImageUrl:{
        type:String,
        required:true
    },
    paymentId:{
        type:String,
        required:true
    }
})
const isPaymentSuccess = ref(null)

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
    console.log(responseData)

    if(responseData.status==="success"){
        isPaymentSuccess.value = true
    }else{
        isPaymentSuccess.value = false
    }
}
</script>
