<template>
    <div>
        <div>
            <div class="p-1 rounded-md">
               <div>
                   <div class="p-8 flex gap-8 flex-col justify-center items-center">
                       <div class="font-bold text-lg dark:text-gray-100">Scan this QR image from your wallet to finish payment</div>
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
    }
})
</script>
