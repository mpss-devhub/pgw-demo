@props(['categories','brands','categoriesParam','brandsParam','openedTabs'])

<div
    x-data="{ openedTabs: new Set({{ json_encode($openedTabs) }}),selectedCategories: {{ json_encode($categoriesParam) }},selectedBrands:{{json_encode($brandsParam)}} }"
>
    <form

        method="GET" action="{{route('home')}}" class="w-full"  x-cloak>
        <!-- Accordion Container -->
        <div class="space-y-1">
            <div class="bg-gray-300 hover:bg-gray-400 rounded-sm">
                <!-- Accordion Header 1 -->
                <div @click="openedTabs.has('categories')?openedTabs.delete('categories'):openedTabs.add('categories');if(selectedBrands.size===0 && openedTabs.has('brands')){openedTabs.delete('brands')}" class="p-1 px-2 cursor-pointer">
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
                <div x-show="openedTabs.has('categories')" class="p-2">
                    <!-- Scrollable Checkbox List -->
                    <div class="max-h-40 overflow-y-auto">
                        <div class="">
                            @foreach ($categories as $category)
                                <label class="block">
                                    <input type="checkbox" {{in_array($category->name,$categoriesParam)?'checked':''}} @click="toggleSelection(selectedCategories, '{{$category->name}}')"  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 ms-1" />
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
                <div  @click="openedTabs.has('brands')?openedTabs.delete('brands'):openedTabs.add('brands');if(selectedCategories.size===0 && openedTabs.has('categories')){openedTabs.delete('categories')}" class="p-1 px-2 cursor-pointer">
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
                <div x-show="openedTabs.has('brands')" class="p-2">
                    <!-- Scrollable Checkbox List -->
                    <div class="max-h-40 overflow-y-auto">
                        <div class="">
                            @foreach ($brands as $brand)
                                <label class="block">
                                    <input type="checkbox"  {{in_array($brand->name,$brandsParam)?'checked':''}} @click="toggleSelection(selectedBrands, '{{$brand->name}}')" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 ms-1" />
                                    <span class="ml-2">{{ $brand->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
    <div class="flex justify-end gap-3 mt-4">
        <x-secondary-button class="rounded-sm py-0">
            <input class="cursor-pointer" type="button" @click="selectedCategories=[];selectedBrands=[]; window.location.href=window.location.href.split('?')[0];" value="Clear"/>
        </x-secondary-button>
        <x-primary-button class="rounded-sm py-0">
            <input class="cursor-pointer" type="button" @click="submitFilterForm($event,selectedCategories,selectedBrands)" value="Filter"/>
        </x-primary-button>
    </div>
</div>

