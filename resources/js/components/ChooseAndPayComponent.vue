<template>
    <div>
        <div>
            <payment-steps-component :current-step="currentStep"></payment-steps-component>

            <show-available-payments-component
                v-if="!selectedPayment"
                :payment-categories-with-payments="paymentCategoriesWithPayments"
                @on-payment-chosen="onPaymentClicked"
            ></show-available-payments-component>

            <show-payment-info-component
                v-if="currentStep===2 && selectedPayment"
                :payment-id="paymentId"
                :selected-payment="selectedPayment"
                :selected-payment-category="selectedPaymentCategory"
                @on-pay-request-done="onPayRequestDone"
            />

            <show-qr-component
                v-if="currentStep===3 && qrImage"
                :qr-image-url="qrImage"
                :payment-id="paymentId"
            >
            </show-qr-component>

            <show-waiting-message-component
                v-if="currentStep===3 && inAppPayMessage"
                :payment-id="paymentId"
                :message="inAppPayMessage">
            </show-waiting-message-component>

            <payment-status-message-component
                v-if="currentStep===3"
                @on-payment-result-known="onPaymentResult"
                :payment-id="paymentId">
            </payment-status-message-component>

        </div>
    </div>
</template>
<script setup>
import {ref} from "vue"

const currentStep  =  ref(1)
const selectedPayment = ref(null);
const selectedPaymentCategory = ref(null)

const qrImage = ref("")
const inAppPayMessage = ref("")

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
    currentStep.value = 2
    selectedPayment.value = payment
    selectedPaymentCategory.value = category
}


async function onPayRequestDone({type,data}){
    currentStep.value = 3
    if(type==="QR"){
        qrImage.value = data
    }
    if(type==="NOTI"){
        inAppPayMessage.value = data
    }
}
function onPaymentResult(isSuccess){
    currentStep.value = 4
}


</script>
