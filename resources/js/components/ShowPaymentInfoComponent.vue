<template>
    <div>
        <div class="font-bold dark:text-gray-200 text-gray-800">
            Pay with
        </div>
        <div class="mt-2 px-6 py-3 bg-purple-400 dark:bg-purple-500 text-white flex items-center rounded-md justify-start gap-2">
            <div class="flex items-center justify-center gap-2">
                <img class="rounded-md  w-10 h-10 object-cover"  :src="selectedPayment.logo"/>
                <span>{{selectedPayment.paymentName}}</span>
            </div>
                 <i class="fa fa-check-circle text-white"></i>
        </div>
        <div class="mt-8 font-bold dark:text-gray-200 text-gray-800">
            Fill in required information
        </div>
        <div class="px-6 py-1 mt-2 text-red-500 rounded-md border border-red-300" v-if="errorMessage">
            <i class="fa fa-circle-exclamation"></i> {{errorMessage}}
        </div>
        <div class="dark:bg-gray-800 bg-gray-200 p-1 mt-3 mb-20 rounded-md">
            <div class="p-2 px-5">
                <form>
                    <div class="p-2 false space-y-6">
                        <div class="flex flex-col gap-1">
                            <template v-for="(value, key) in selectedPayment.input">
                                <label class="block text-gray-700 text-sm font-bold mb-1">{{value.label}}<span class="text-red-500">{{value.required==='true'?'*':''}}</span></label>
                                <input
                                        v-model="inputModels[`${key}`]"
                                        :name="key"
                                        :type="value.type"
                                        :placeholder="`Enter ${value.label}`"

                                        @input="onInputFieldChange(key)"
                                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    >
                                <span class="text-red-500 text-sm mb-5">{{errors[key]?errors[key]:''}}</span>

                            </template>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button  @click="onBackClick" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-purple-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>

                <button

                        @click="onContinueClicked"
                        :disabled="isContinueButtonDisabled"
                        :class="{'bg-gray-600 dark:bg-gray-600  hover:bg-gray-600 dark:hover:bg-gray-600 cursor-not-allowed':isContinueButtonDisabled,'cursor-pointer':!isContinueButtonDisabled}"
                        class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                    {{isPaymentRequesting?"Processing..":"Continue"}}
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import {computed, ref} from "vue";

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
const errors = ref({})
const emit = defineEmits(["onPayRequestDone","onBackClicked"])
const type = ref(null)
const responseData = ref(null)
const errorMessage = ref(null)

const isRequiredFieldsBlank = computed(()=>{
    if(Object.keys(inputModels.value).length === 0) return true


    for(let key in inputModels.value){
        const input = props.selectedPayment.input[key]
        if(input.required==="true" && inputModels.value[key]==="") return true
    }

    return false
})
const isContinueButtonDisabled = computed(()=>isPaymentRequesting.value || Object.keys(errors.value).length > 0 || isRequiredFieldsBlank.value)


async function onContinueClicked() {
    const credentialData = {
        paymentId: props.paymentId,
        paymentCode: props.selectedPayment.paymentCode
    }
    const enteredFormValues = inputModels.value

    const formData = {...enteredFormValues, ...credentialData}

    if (props.selectedPaymentCategory.paymentType === "Web Pay" || props.selectedPaymentCategory.paymentType === "Local Card") {
        submitWebPayRequest(enteredFormValues)
    } else if (props.selectedPaymentCategory.paymentType === "QR Scan") {

        const response = await submitQRPayRequest(formData)
        if(response.status==="0000") {
            responseData.value = response.data.data;
            type.value = response.data.type;
        }else{
            errorMessage.value = response.message;
        }
    } else {

        const response = await submitInAppPayRequest(formData)
        if(response.status==="0000") {
            responseData.value = response.data.data;
            type.value = response.data.type;
        } else{
            errorMessage.value = response.message
        }
    }
    if(type.value && responseData.value){
        emit('onPayRequestDone',{type:type.value,data:responseData.value})
    }
}


async function submitInAppPayRequest(formData){
    isPaymentRequesting.value = true

    const response = await axios.post('/api/non-web-pay', formData, {
        headers: {
            'Content-Type': 'application/json'
        }
    })

    isPaymentRequesting.value = false;
    return response.data;
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
    paymentCode.value = props.selectedPayment.paymentCode
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
    const response = await axios.post('/api/non-web-pay', formData, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
    isPaymentRequesting.value = false
    return response.data;
}

function onBackClick(){
    emit("onBackClicked")
}

function onInputFieldChange(key){

    const validations = props.selectedPayment.input[key].validations

    validations.forEach(validation=>{
        if(inputModels.value[key]==="" || inputModels.value[key]===null) return

        if(validation.type==="reg" && validation.params){
            const regex = new RegExp(validation.params[0]);
            if(!regex.test(inputModels.value[key])){
                errors.value[key] = validation.params[1]
                console.log("eerror")
            }else{
                console.log("no error")

                delete errors.value[key]
            }
        }
        if(validation.type==="min" && validation.params){

            if(inputModels.value[key].length<validation.params[0]){
                errors.value[key] = validation.params[1]
                console.log("eerror")
            }else{
                console.log("no error")

                delete errors.value[key]
            }
        }
        if(validation.type==="max" && validation.params){

            if(inputModels.value[key].length>validation.params[0]){
                errors.value[key] = validation.params[1]
                console.log("eerror")
            }else{
                console.log("no error")

                delete errors.value[key]
            }
        }
    })
}

</script>
