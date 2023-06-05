<template>
    <div class=" bg-gray-200 p-1 mt-3 mb-20 rounded-md">
        <p class="text-lg font-bold text-gray-800 mt-2  mx-2 flex justify-between mb-2 px-3">
            <span>
                            Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">2</span>
            </span>
            <span>
                Fill in required information
            </span>
        </p>
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
            <button @click="onContinueClicked" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                {{isPaymentRequesting?"Processing...":"Continue"}}
            </button>
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
    }
})

const inputModels = ref({})
const emit = defineEmits(["onContinueClicked"])

function onContinueClicked(){
    emit('onContinueClicked',inputModels.value)
}

</script>
