<template>
    <div>
        <div>
            <div class="p-1 rounded-md lg:px-20">
                <div>
                    <div class="p-2 lg:p-8 flex gap-3 flex-col justify-center items-center ">
                        <div class="font-bold text-xl">Confirm payment</div>
                        <span class="p-5 bg-gray-300    rounded-md text-black">{{message}}</span>
                    </div>
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
