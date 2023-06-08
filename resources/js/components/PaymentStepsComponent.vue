<template>
    <div class="max-w-2xl mx-auto py-8">
        <div class="grid grid-cols-4 justify-between items-center">
                <div class="flex items-center flex-col gap-2 h-full">
                    <div :class="{'bg-blue-500 text-white':currentStep===1,'bg-gray-300 text-gray-500':currentStep!==1}" class="w-5 h-5 flex items-center justify-center rounded-full">
                        1
                    </div>
                    <div class="text-center ml-2 text-sm font-medium text-gray-800  dark:text-gray-100">Choose Payment</div>
                </div>
                <div class="flex items-center flex-col gap-2 h-full">
                    <div :class="{'bg-blue-500 text-white':currentStep===2,'bg-gray-300 text-gray-500':currentStep!==2}" class="w-5 h-5 flex items-center justify-center rounded-full">
                        2
                    </div>
                    <div class="text-center ml-2 text-sm font-medium text-gray-500  dark:text-gray-100">Information</div>
                </div>

                <div class="flex items-center flex-col gap-2 h-full">
                    <div :class="{'text-white bg-blue-500':currentStep===3,'bg-gray-300 text-gray-500':currentStep!==3}" class="w-5 h-5 flex items-center justify-center rounded-full">
                        3
                    </div>
                    <div class="text-center ml-2 text-sm font-medium text-gray-500  dark:text-gray-100">Confirm Payment</div>
                </div>

                <div class="flex items-center flex-col gap-2 h-full">
                    <div :class="{'bg-blue-500 text-white':currentStep===4,'text-gray-500 bg-gray-300':currentStep!==4}" class="w-5 h-5 flex items-center justify-center rounded-full">
                        4
                    </div>
                    <div class="text-center ml-2 text-sm font-medium text-gray-500 dark:text-gray-100">Complete</div>
                </div>
        </div>
        <div>
            <div class="flex mt-1">
                <div :class="{'bg-blue-500':currentStep===1,'bg-gray-300':currentStep!==1}" class="h-1 w-1/4 "></div>
                <div :class="{'bg-blue-500':currentStep===2,'bg-gray-300':currentStep!==2}" class="h-1 w-1/4 "></div>
                <div :class="{'bg-blue-500':currentStep===3,'bg-gray-300':currentStep!==3}" class="h-1 w-1/4 "></div>
                <div :class="{'bg-blue-500':currentStep===4,'bg-gray-300':currentStep!==4}" class="h-1 w-1/4 "></div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    currentStep:{
        type:Number,
        default:1
    }
})
</script>
