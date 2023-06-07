<template>
    <div>
        <div>
            <payment-steps-component :current-step="currentStep"></payment-steps-component>

            <show-available-payments-component
                v-if="currentStep===1 && !selectedPayment"
                :payment-categories-with-payments="paymentCategoriesWithPayments"
                @on-payment-chosen="onPaymentClicked"
            ></show-available-payments-component>

            <show-payment-info-component
                v-if="currentStep===2 && selectedPayment"
                :payment-id="paymentId"
                :selected-payment="selectedPayment"
                :selected-payment-category="selectedPaymentCategory"
                @on-back-clicked="onInfoFormBackClicked"
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
                :message="inAppPayMessage"
            >
            </show-waiting-message-component>

            <payment-status-message-component
                v-if="currentStep===4"
                :successful-payment="successfulPayment"
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


const isPaymentSuccess = ref(null)

const pollingInterval = 1000; // 1 second
const totalDuration = 3 * 60 * 1000; // 3 minutes in milliseconds
const startTime = Date.now();
const isWaitingDone = ref(false)
const successfulPayment = ref(null)

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
function onInfoFormBackClicked(){
    currentStep.value = 1;
    selectedPayment.value = null;
    selectedPaymentCategory.value = null;
}
async function onPayRequestDone({type,data}){
    currentStep.value = 3
    if(type==="QR"){
        qrImage.value = data
    }
    if(type==="NOTI"){
        inAppPayMessage.value = data
    }
    await pollIfPaymentSuccess()
}

async  function pollIfPaymentSuccess(){
    const url = `/api/payments/${props.paymentId}/status`
    const response = await fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })

    const responseData = await response.json();

    const elapsedTime = Date.now() - startTime;
    if (elapsedTime < totalDuration && !isWaitingDone.value) {
        // Continue polling after a certain delay
        setTimeout(async () => await pollIfPaymentSuccess(), pollingInterval);
    } else {
        console.log('Polling completed.');
    }

    if(responseData.status==="success"){
        isPaymentSuccess.value = true
        isWaitingDone.value = true
        successfulPayment.value = responseData.data
        currentStep.value = 4
    }else if(responseData.status==="failed"){
        isPaymentSuccess.value = false
        isWaitingDone.value = true
        currentStep.value = 4
    }
}

</script>
