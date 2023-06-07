<template>
    <div>
        <div class="px-6 py-1 text-red-500 rounded-md border border-red-300" v-if="errorMessage">
            <i class="fa fa-circle-exclamation"></i> {{errorMessage}}
        </div>
        <div class=" bg-gray-200 p-1 mt-3 mb-20 rounded-md">
            <div class="p-2 px-5">
                <form>
                    <div class="p-2false space-y-6">
                        <div class="flex flex-col gap-2">
                            <template v-for="(value, key) in selectedPayment.input">
                                <div class="mb-4" v-if="value.required==='true'">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">{{value.label}}</label>
                                    <input v-model="inputModels[`${key}`]" :name="key" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  :type="value.type" :placeholder="`Enter ${value.label}`">
                                </div>
                            </template>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button  @click="onBackClick" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>

                <button @click="onContinueClicked" :class="{'bg-blue-500 cursor-not-allowed':isPaymentRequesting}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{isPaymentRequesting?"Processing..":"Continue"}}
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref} from "vue";

const props = defineProps({
    selectedPayment:{
        type:Object,
        required:true
    },
    isPaymentRequesting:{
        type:Boolean,
        required:true,
        default:false
    },
    paymentId:{
        type:String,
        required:true
    },
    selectedPaymentCategory:{
        type:Object,
        required:true
    }
})
const isPaymentRequesting = ref(false)
const inputModels = ref({})
const emit = defineEmits(["onPayRequestDone","onBackClicked"])
const type = ref(null)
const responseData = ref(null)
const errorMessage = ref(null)


async function onContinueClicked() {
    const credentialData = {
        paymentId: props.paymentId,
        paymentCode: props.selectedPayment.paymentCode
    }
    const enteredFormValues = inputModels.value

    const formData = {...enteredFormValues, ...credentialData}

    if (props.selectedPaymentCategory.paymentType === "Web Pay" || props.selectedPaymentCategory.paymentType === "Local Card") {
        submitWebPayRequest(userFilledData)
    } else if (props.selectedPaymentCategory.paymentType === "QR Scan") {
        type.value = "QR"
        const response = await submitQRPayRequest(formData)
        if(response.status==="0000")
            responseData.value = response.data;
        else{
            errorMessage.value = response.message
        }
    } else {
        type.value = "NOTI"
        const response = await submitInAppPayRequest(formData)
        if(response.status==="0000")
            responseData.value = response.data;
        else{
            errorMessage.value = response.message
        }
    }
    if(type.value && responseData.value){
        emit('onPayRequestDone',{type:type.value,data:responseData.value})
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

function onBackClick(){
    emit("onBackClicked")
}

</script>
