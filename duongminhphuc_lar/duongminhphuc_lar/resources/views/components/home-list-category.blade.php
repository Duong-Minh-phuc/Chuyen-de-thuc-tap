@foreach ($categorys as $categoryitem)
    <div class="productcategory py-4">
        <div class="flex items-center">
            <div class="basis-1/0">
                <h1 class="font-bold text-2xl uppercase mb-4">{{ $categoryitem->name }}</h1>
            </div>
        </div>
        <div class="pl-5">
            @php
                $categoryid = $categoryitem->id;
            @endphp
            <x-sub-list-category :categoryid="$categoryid" />
        </div>
    </div>
@endforeach 