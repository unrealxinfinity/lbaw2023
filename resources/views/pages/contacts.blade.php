@extends('layouts.app')

@section('title', 'Contacts')

@section('content')

    <section id="Contacts" class="bg-white/90 p-5 rounded-md desktop:w-1/2 tablet:w-2/3 m-auto">
        <h1 class="text-black bold">Contacts us via email:</h1>
        <ul class="list-disc pl-5 text-black">
            <li> Afonso Vaz Osório: <a href="mailto:up202108700@up.pt" class="hover:underline">up202108700@up.pt</a></li>
            <li> HaoChang Fu: <a href="mailto:up202108730@up.pt" class="hover:underline">up202108730@up.pt </a></li>
            <li> Isabel Moutinho: <a href="mailto:up202108767@up.pt" class="hover:underline">up202108767@up.pt</a></li>
            <li> Tiago Cruz: <a href="mailto:up202108810@up.pt" class="hover:underline">up202108810@up.pt </a></li>
        </ul>
</section>
    
@endsection