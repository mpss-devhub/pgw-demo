<template>
    <div class="font-bold  text-gray-800">
        Select your payment method
    </div>
    <div class="bg-gray-200 mt-2 p-1 rounded-md ">
        <div v-for="category in paymentCategoriesWithPayments" class="p-1 mx-1 lg:px-2 lg:mx-3">
            <p class="text-sm font-bold ">{{category.paymentType}}</p>
            <div class="grid grid-cols-2 lg:grid-cols-3 px-1 gap-2 rounded-md p-1">
                <div
                    v-for="payment in category.payments"
                   >
                    <div
                        :class="{
                        'bg-purple-500 text-white':(selectedPayment && selectedPayment.paymentCode===payment.paymentCode),
                        'hidden':payment.paymentCode==='KBZPAY_APP',
                         'lg:hidden':payment.paymentCode==='CBPAY_PIN'
                    }"
                        class="flex justify-start items-center gap-1 border cursor-pointer border-solid border-gray-400  rounded-md"
                        @click="onPaymentClicked(payment,category)">
                        <img class="rounded-md  w-8 h-8 object-cover"  :src="payment.logo"/>
                        <span class="font-medium text-sm" >{{payment.paymentName}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
            <button  @click="onPaymentClicked(null,null)" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-purple-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10      dark:focus:ring-gray-600">Cancel</button>
            <button @click="onContinueClicked" :disabled="!selectedPayment" :class="{'bg-gray-600   hover:bg-gray-600 cursor-not-allowed':!selectedPayment}" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center   dark:focus:ring-purple-800">Continue</button>
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
    if(!selectedPayment.value && !payment && !category && !selectedCategory.value){
        window.location.href = "/home"
    }
    selectedPayment.value = payment
    selectedCategory.value = category
}
function onContinueClicked(){
    emit('onPaymentChosen',selectedPayment.value,selectedCategory.value)
}

</script>
