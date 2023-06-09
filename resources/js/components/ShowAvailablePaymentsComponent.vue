<template>
    <div class="bg-gray-200 p-1 rounded-md dark:bg-gray-800">
        <div v-for="category in paymentCategoriesWithPayments" class="p-1 mx-1 lg:px-2 lg:mx-3">
            <p class="text-sm font-bold text-gray-200">{{category.paymentType}}</p>
            <div class="grid grid-cols-2 lg:grid-cols-3 px-1 gap-2 rounded-md p-1">
                <div
                    v-for="payment in category.payments"
                    :class="{'bg-blue-500 text-white':(selectedPayment && selectedPayment.paymentCode===payment.paymentCode)}"
                    class="border cursor-pointer border-solid border-gray-400 justify-between items-center gap-1 flex  rounded-md dark:text-white"
                    @click="onPaymentClicked(payment,category)">
                    <div class="flex justify-start items-center gap-1">
                        <img class="rounded-md  w-8 h-8 object-cover"  :src="payment.logo"/>
                        <span class="font-medium text-sm" >{{payment.paymentName}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button  @click="onPaymentClicked(null,null)" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
            <button @click="onContinueClicked" :disabled="!selectedPayment" :class="{'bg-gray-500 hover:bg-gray-500 cursor-not-allowed':!selectedPayment}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Continue</button>
        </div>
    </div>
</template>
<script setup>
import {ref} from "vue";

const props = defineProps({
    paymentCategoriesWithPayments:{
        type:Array,
        required:true
    }
})
const selectedPayment = ref(null)
const selectedCategory = ref(null)

const emit = defineEmits(['onPaymentChosen'])

function onPaymentClicked(payment,category){
    selectedPayment.value = payment
    selectedCategory.value = category
}
function onContinueClicked(){
    emit('onPaymentChosen',selectedPayment.value,selectedCategory.value)
}

</script>
