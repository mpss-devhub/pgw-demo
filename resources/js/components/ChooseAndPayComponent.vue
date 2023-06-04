<template>
    <div>
        <div>
            <p class="text-lg font-bold text-gray-800 mt-2 mb-3">Fill in payment information</p>

            <show-available-payments-component
                v-if="!selectedPayment&& !isLastStep"
                :payment-categories-with-payments="paymentCategoriesWithPayments"
                @on-payment-chosen="onPaymentClicked"
            ></show-available-payments-component>

            <show-payment-info-component   v-if="selectedPayment && !isLastStep" :selected-payment="selectedPayment"/>

            <show-q-r-component v-if="isLastStep && qrImage"  :qr-image-url="qrImage"></show-q-r-component>
            
            <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button  @click="selectedPayment=null" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                <button @click="onContinueClicked" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Continue</button>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref} from "vue";
import ShowQRComponent from "./ShowQRComponent.vue";

const selectedPayment = ref(null);
const isPaymentTypeRedirect = ref(null)
const isLastStep = ref(false)
const qrImage = ref("")


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

function onPaymentClicked(payment,category){
    selectedPayment.value = payment
    isPaymentTypeRedirect.value = category.paymentType==="Web Pay"
}

async function onContinueClicked(){
    if(isPaymentTypeRedirect.value){
        submitWebPayForm()
        return;
    }else{
        const response = await getQrImage("09440813572")
        qrImage.value = response.data;
        isLastStep.value = true
    }
}

function submitWebPayForm(){
    const webPayForm = document.getElementById('webPayForm');
    webPayForm.submit();
}

async function getQrImagegetQrImage(phoneNumber){
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/api/non-web-pay', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            paymentId:props.paymentId,
            paymentCode:selectedPayment.value.paymentCode,
            phoneNumber:phoneNumber
        })
    })
    return response.json();
}
</script>
