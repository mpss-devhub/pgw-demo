<template>
    <div>
        <div class="p-8 flex gap-8 flex-col justify-center items-center" v-if="isPaymentSuccess">
            <div class="font-bold text-green-500">Payment successfully received.</div>
        </div>
        <div class="p-8 flex gap-8 flex-col justify-center items-center" v-if="isPaymentSuccess!==null && !isPaymentSuccess">
            <div class="font-bold text-red-500">Payment timeout or unsuccessful payment.</div>
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
