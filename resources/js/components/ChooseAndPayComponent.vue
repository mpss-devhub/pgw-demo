<template>
    <div>
        <div>

            <payment-steps-component :current-step="currentStep"></payment-steps-component>

                <show-available-payments-component
                    v-if="currentStep===1 && !selectedPayment && paymentCategoriesWithPayments && paymentId"
                    :payment-categories-with-payments="paymentCategoriesWithPayments"
                    @on-payment-chosen="onPaymentClicked"
                ></show-available-payments-component>

                <show-payment-info-component
                    v-if="currentStep===2 && selectedPayment  && paymentCategoriesWithPayments && paymentId"
                    :payment-id="paymentId"
                    :selected-payment="selectedPayment"
                    :selected-payment-category="selectedPaymentCategory"
                    @on-back-clicked="onInfoFormBackClicked"
                    @on-pay-request-done="onPayRequestDone"
                />

                <show-qr-component
                    v-if="currentStep===3 && qrImage  && paymentCategoriesWithPayments && paymentId"
                    :qr-image-url="qrImage"
                >
                </show-qr-component>

                <show-waiting-message-component
                    v-if="currentStep===3 && inAppPayMessage  && paymentCategoriesWithPayments && paymentId"
                    :message="inAppPayMessage"
                >
                </show-waiting-message-component>

                <deep-link-message
                    v-if="currentStep===3 && deepLink  && paymentCategoriesWithPayments && paymentId"
                    :deep-link="deepLink"
                >
                </deep-link-message>

                <payment-status-message-component
                    v-if="currentStep===4"
                    :successful-payment="payment"
                >
                </payment-status-message-component>

        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue"
import DeepLinkMessage from "./DeepLinkMessage.vue";

const currentStep  =  ref(1)
const selectedPayment = ref(null);
const selectedPaymentCategory = ref(null)


const isPaymentSuccess = ref(false)

const pollingInterval = 1000; // 1 second
const totalDuration = 5 * 60 * 1000; // 3 minutes in milliseconds
const startTime = Date.now();
const isWaitingDone = ref(false)
const payment = ref(null)

const qrImage = ref("")
const inAppPayMessage = ref("")
const deepLink = ref("")

const props = defineProps({
    isSuccess:{
        type:Boolean,
        required:false,
        default:null
    },
    paymentCategoriesWithPayments:{
        type:Array,
        required:false,
        default:null
    },
    paymentId:{
        type:String,
        required:false,
        default:null
    },
    payment:{
        type:Object,
        required:false,
        default:null
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
    if(type==="MESSAGE"){
        inAppPayMessage.value = data
    }
    if(type==="DEEP_LINK"){
        deepLink.value = data
    }
    await pollIfPaymentSuccess()
}

async  function pollIfPaymentSuccess(){
    const url = `/api/payments/${props.paymentId}/status`

    const response = await axios.get(url, null, {
        headers: {
            'Content-Type': 'application/json'
        }
    })

    const responseData = response.data;

    const elapsedTime = Date.now() - startTime;
    if (elapsedTime < totalDuration && !isWaitingDone.value) {
        // Continue polling after a certain delay
        setTimeout(async () => await pollIfPaymentSuccess(), pollingInterval);
    } else {
       onPaymentError()
    }

    if(responseData.status==="success"){
        isPaymentSuccess.value = true
        isWaitingDone.value = true
        payment.value = responseData.data
        currentStep.value = 4
    }else if(responseData.status==="failed"){
       onPaymentError()
    }
}

onMounted(()=>{
    if(!props.paymentId || !props.paymentCategoriesWithPayments){
        currentStep.value = 4
        payment.value = props.payment
    }
})

function onPaymentError(){
    isPaymentSuccess.value = false
    isWaitingDone.value = true
    currentStep.value = 4
}
</script>

