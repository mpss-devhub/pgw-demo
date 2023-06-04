<template>
    <div class=" bg-gray-200 p-1 mt-3 mb-20 rounded-md">
        <p class="text-lg font-bold text-gray-800 mt-2  mx-2 flex justify-between">
           <span>
               Step <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-gray-500 text-white">2</span>
           </span>
        </p>
        <div class="p-2">
            <form>
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
</template>
<script setup>

const props = defineProps({
    selectedPayment:{
        type:Object,
        required:true
    }
})
</script>
