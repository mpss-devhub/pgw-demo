<template>
    <div>
        <div>
            <div class=" bg-gray-200 p-1 mt-3 mb-20 rounded-md">
               <div>
                   <p class="text-lg font-bold text-gray-800 mt-2  mx-2 flex justify-between">
                       <span>
                           Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">3</span>
                       </span>
                   </p>
                   <div class="p-8 flex gap-8 flex-col justify-center items-center">
                       <div class="font-bold">Scan this QR Image from your wallet to finish payment.</div>
                       <img :src="qrImageUrl" width="300" height="300"/>
                   </div>
               </div>
            </div>
        </div>
    </div>
</template>
<script setup>
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
</script>
