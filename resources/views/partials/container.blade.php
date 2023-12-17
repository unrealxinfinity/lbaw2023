<div class="container">
    <img class="h-1/2 overflow-hidden rounded-t-md object-cover" src="{{ $img }}" alt ="{{$alt}}">
    @php
        $translateXValue = (strlen($title)>20)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
    @endphp
    <div class="title"><h2><a class="{{$translateXValue}}" href="{{ $link }}">{{ $title }}</a></h2></div>
    <div class="desc"><h4>{{$description}}</h4></div>
</div>