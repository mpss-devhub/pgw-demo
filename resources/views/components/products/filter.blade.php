@props(['categories','brands'])

<div  x-data="{ openedTab: null,selectedCategories:[],selectedBrands:[] }">
    <form  method="GET" action="{{route('home')}}" class="w-full"  x-cloak>
        <!-- Accordion Container -->

        <div class="space-y-1">
            <div class="bg-gray-300 hover:bg-gray-400 rounded-sm">
                <!-- Accordion Header 1 -->
                <div @click="openedTab = (openedTab==='categories')?null:'categories'" class="p-1 px-2 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium">Categories</h3>
                        <svg :class="{ 'transform rotate-180': open, 'transform rotate-0': !open }"
                             class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Accordion Content 1 -->
                <div x-show="openedTab==='categories'" class="p-2">
                    <!-- Scrollable Checkbox List -->
                    <div class="max-h-40 overflow-y-auto">
                        <div class="">
                            @foreach ($categories as $category)
                                <label class="block">
                                    <input type="checkbox" @click="toggleSelection(selectedCategories, '{{$category->name}}')"  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 ms-1" />
                                    <span class="ml-2">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="space-y-1 mt-2">
            <!-- Accordion Item 1 -->
            <div class="bg-gray-300 hover:bg-gray-400 rounded-sm">
                <!-- Accordion Header 1 -->
                <div  @click="openedTab =(openedTab==='brands')?null:'brands'" class="p-1 px-2 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium">Brands</h3>
                        <svg :class="{ 'transform rotate-180': open, 'transform rotate-0': !open }"
                             class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Accordion Content 1 -->
                <div x-show="openedTab==='brands'" class="p-2">
                    <!-- Scrollable Checkbox List -->
                    <div class="max-h-40 overflow-y-auto">
                        <div class="">
                            @foreach ($brands as $brand)
                                <label class="block">
                                    <input type="checkbox"  @click="toggleSelection(selectedBrands, '{{$brand->name}}')" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 ms-1" />
                                    <span class="ml-2">{{ $brand->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
    <div class="flex justify-end mt-4">
        <x-primary-button class="rounded-sm py-1">
            <input type="button" @click.prevent="submitFilterForm($event,selectedCategories,selectedBrands)" value="Filter"/>
        </x-primary-button>
    </div>
</div>

