<template>
    <div>
        <div>
            <div class=" bg-gray-200 p-1 mt-3 mb-20 rounded-md">
                <p class="text-lg font-bold text-gray-800 mt-2  mx-2 flex justify-between">
                       <span>
                           Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">3</span>
                       </span>
                </p>
                <div class="p-2 flex gap-8 flex-col justify-center items-center">
                        <div class="font-bold">Please wait</div>
                    <span>{{message}}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

const props = defineProps({
    message:{
        type:String,
        required:true
    }
})
</script>
