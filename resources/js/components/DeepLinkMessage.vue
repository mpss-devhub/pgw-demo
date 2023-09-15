<template>
    <div>
        <div>
            <div class="p-1 rounded-md lg:px-20">
                <div>
                    <div class="p-2 lg:p-8 flex gap-3 flex-col justify-center items-center dark:text-gray-200">
                        <div class="font-bold text-xl">Confirm payment</div>
                        <span class="p-5 bg-gray-300 dark:bg-gray-800  dark:text-gray-200 rounded-md text-black">Please confirm payment via your wallet.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

import {onMounted} from "vue";

const props = defineProps({
    deepLink:{
        type:String,
        required:true
    }
})
onMounted(()=>{
    window.location.href = props.deepLink
})
</script>
