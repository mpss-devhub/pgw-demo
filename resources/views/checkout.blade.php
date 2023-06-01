<x-app-layout>
   <div>
       @foreach($paymentCategoriesWithPayments as $category)
           <div class="p-2">
               <h2>{{$category['paymentType']}}</h2>
               <div class="p-1">
                   @foreach($category['payments'] as $payment)
                       <div>
                           <span>{{$payment['paymentName']}}</span>
                           <img width="100" height="100" src="{{$payment['logo']}}"/>
                       </div>
                   @endforeach
               </div>
           </div>
       @endforeach
   </div>
</x-app-layout>
