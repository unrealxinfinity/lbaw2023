@extends('layouts.app')

@section('title', 'Contacts')

@section('content')

    <section id="Contacts" class="flex items-start justify-center h-screen">
        <div class="bg-white p-5 rounded-md w-1/2">
            <h1 class="text-black bold">Contacts us via email:</h1>
            <ul class="list-disc pl-5 text-black">
                <li> Afonso Vaz Osório: <a href="mailto:up202108700@up.pt" class="hover:underline">up202108700@up.pt</a></li>
                <li> HaoChang Fu: <a href="mailto:up202108730@up.pt" class="hover:underline">up202108730@up.pt </a></li>
                <li> Isabel Moutinho: <a href="mailto:up202108767@up.pt" class="hover:underline">up202108767@up.pt</a></li>
                <li> Tiago Cruz: <a href="mailto:up202108810@up.pt" class="hover:underline">up202108810@up.pt </a></li>
            </ul>
        </div>
    </section>
    
@endsection