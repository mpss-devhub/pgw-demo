<div class="p-2 flex flex-col gap-1 w-1/3 bg-gray-300 rounded-sm mb-10">
    <template x-for="item in cart">
       <div  class="flex justify-between px-2 py-1">
           <span x-text="item.name"></span>
           <span x-text="'$'+item.price"></span>
       </div>
    </template>
    <div class="flex justify-between px-2 py-1">
        <span class="font-bold">Total</span>
        <span>$30000</span>
    </div>
    <hr class="border-b border-gray-600 mb-2 mt-3">
    <div class="flex justify-end">
        <x-primary-button class="rounded-sm py-0">
            <input type="button"  value="Checkout"/>
        </x-primary-button>
    </div>
</div>
