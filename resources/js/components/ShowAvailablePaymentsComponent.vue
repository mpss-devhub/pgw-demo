<template>
    <div class="bg-gray-200 p-1 rounded-md">
        <p class="text-lg font-bold text-gray-800 mt-2  mx-2">Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">1</span></p>
        <div v-for="category in paymentCategoriesWithPayments" class="p-2 mx-3">
            <p class="text-sm font-bold">{{category.paymentType}}</p>
            <div class="grid grid-cols-3 px-1 gap-2 rounded-md p-1">
                <div
                    v-for="payment in category.payments"
                    :class="{'bg-gray-700':selectedPayment&&selectedPayment.paymentCode===payment.paymentCode}"
                    class="border border-solid border-gray-400 justify-between items-center gap-1 flex  rounded-md dark:text-white"
                    @click="$emit('onPaymentChosen',payment,category)">
                    <div class="flex justify-start items-center gap-1">
                        <img class="rounded-md  w-8 h-8 object-cover"  :src="payment.logo"/>
                        <span class="font-medium text-sm" :class="{'text-white':selectedPayment&&selectedPayment.paymentCode===paymentCode}">{{payment.paymentName}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

const props = defineProps({
    paymentCategoriesWithPayments:{
        type:Array,
        required:true
    },
    selectedPayment:{
        type:Object,
        default:null,
        required:true
    }
})
const emit = defineEmits(['onPaymentChosen'])
</script>
