<template>
    <div>
        <div>
            <p class="text-lg font-bold text-gray-800 mt-2 mb-3">Fill in payment information</p>
            <div class="bg-gray-200 p-1 rounded-md"  v-if="!selectedPayment">
                <p class="text-lg font-bold text-gray-800 mt-2  mx-2">Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">1</span></p>
                <div v-for="category in paymentCategoriesWithPayments" class="p-2 mx-3">
                    <p class="text-sm font-bold">{{category.paymentType}}</p>
                    <div class="grid grid-cols-3 px-1 gap-2 rounded-md p-1">
                        <div
                            v-for="payment in category.payments"
                              :class="{'bg-gray-700':selectedPayment&&selectedPayment.paymentCode===payment.paymentCode}"
                              class="border border-solid border-gray-400 justify-between items-center gap-1 flex  rounded-md dark:text-white"
                              @click="onPaymentClicked(payment)">
                            <div class="flex justify-start items-center gap-1">
                                <img class="rounded-md  w-8 h-8 object-cover"  :src="payment.logo"/>
                                <span class="font-medium text-sm" :class="{'text-white':selectedPayment&&selectedPayment.paymentCode===paymentCode}">{{payment.paymentName}}</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class=" bg-gray-200 p-1 mt-3 mb-20 rounded-md"
                 v-if="selectedPayment">
                <p class="text-lg font-bold text-gray-800 mt-2  mx-2 flex justify-between">
                       <span>
                           Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">2</span>
                       </span>
                </p>
                <div class="p-2">
                    <form>
                        <input type="hidden" name="paymentCode" :value="selectedPayment.paymentCode"/>
                        <input type="hidden" name="paymentId" :value="paymentId"/>
                        <div class="p-2false space-y-6">
                            <div class="flex flex-col gap-2">
                                <template v-for="input in selectedPayment.input">
                                    <div class="mb-4" :class="{'hidden':input.required==='false'}">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">{{input.label}}</label>
                                        <input :name="input.label" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :value="input.value" :type="input.type" :placeholder="`Enter ${input.label}`">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button  @click="selectedPayment=null" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                <button @click="" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Continue</button>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref} from "vue";

const selectedPayment = ref(null);
const isPaymentTypeRedirect = ref(null)

const props = defineProps({
    paymentCategoriesWithPayments:{
        type:Array,
        required:true
    },
    paymentId:{
        type:String,
        required:true
    }
})

function onPaymentClicked(payment){
    selectedPayment.value = payment
}
</script>
