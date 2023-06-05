<template>
    <div>
        <div>
            <p class="text-lg font-bold text-gray-800 mt-2 mb-3">Fill in payment information</p>

            <show-available-payments-component
                v-if="!selectedPayment"
                :payment-categories-with-payments="paymentCategoriesWithPayments"
                @on-payment-chosen="onPaymentClicked"
            ></show-available-payments-component>

            <show-payment-info-component
                v-if="selectedPayment && !isLastStep"
                :selected-payment="selectedPayment"
                :is-payment-requesting="isPaymentRequesting"
                @on-continue-clicked="onContinueClicked"
            />

            <show-q-r-component
                v-if="isLastStep && qrImage"
                :qr-image-url="qrImage"
                :payment-id="paymentId"
            >
            </show-q-r-component>

            <show-waiting-message-component
                v-if="isLastStep && inAppPayMessage"
                :payment-id="paymentId"
                :message="inAppPayMessage">
            </show-waiting-message-component>


        </div>
    </div>
</template>
<script setup>
import {ref} from "vue";
import ShowQRComponent from "./ShowQRComponent.vue";

const selectedPayment = ref(null);
const selectedPaymentCategory = ref(null)

const isLastStep = ref(false)
const qrImage = ref("")
const inAppPayMessage = ref("")
const isPaymentRequesting = ref(false)


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
    selectedPaymentCategory.value = category
}


async function onContinueClicked(userFilledData){
    const credentialData = {
        paymentId:props.paymentId,
        paymentCode:selectedPayment.value.paymentCode
    }
    const formData = { ...userFilledData,...credentialData }

    if(selectedPaymentCategory.value.paymentType==="Web Pay" || selectedPaymentCategory.value.paymentType==="Local Card" ){
        submitWebPayRequest(userFilledData)
        isLastStep.value = true
        return;
    }else if(selectedPaymentCategory.value.paymentType==="QR Scan"){
        const response = await submitQRPayRequest(formData)
        qrImage.value = response.data;
        isLastStep.value = true
        return;
    }else{
        const response = await submitInAppPayRequest(formData)
        inAppPayMessage.value = response.data;
        isLastStep.value = true
        return;
    }
}
async function submitInAppPayRequest(formData){
    isPaymentRequesting.value = true

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/api/non-web-pay', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(formData)
    })
    isPaymentRequesting.value = false;
    return response.json();
}
function submitWebPayRequest(userFilledData){
    isPaymentRequesting.value = true
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/payment/webpay';

    const paymentId = document.createElement('input');
    paymentId.type = 'text';
    paymentId.name = 'paymentId';
    paymentId.value = props.paymentId
    form.appendChild(paymentId);

    const paymentCode = document.createElement('input');
    paymentCode.type = 'text';
    paymentCode.name = 'paymentCode';
    paymentCode.value = selectedPayment.value.paymentCode
    form.appendChild(paymentCode);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const xsrfToke = document.createElement('input');
    xsrfToke.type = 'hidden';
    xsrfToke.name = '_token';
    xsrfToke.value = csrfToken
    form.appendChild(xsrfToke);

    for (let key in userFilledData) {
        const userInput = document.createElement('input');
        userInput.type = 'text';
        userInput.name = key;
        userInput.value = userFilledData[key];
        form.appendChild(userInput);
    }

    document.body.appendChild(form);
    isPaymentRequesting.value = false;

    form.submit();

}

async function submitQRPayRequest(formData){
    isPaymentRequesting.value = true
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/api/non-web-pay', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(formData)
    })
    isPaymentRequesting.value = false
    return response.json();
}
</script>
