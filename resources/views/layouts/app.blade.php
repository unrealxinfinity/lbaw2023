<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - {{env('APP_NAME')}} </title>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Roboto:wght@100;400&display=swap" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/minecraft-4" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal/minimal.css" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="icon" type="image/png" sizes="192x192" href="favicon/android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="512x512" href="favicon/android-chrome-512x512.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        @vite('public/css/app.css')
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script src="https://js.pusher.com/7.0/pusher.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
        
    </head>
    <body id="main-body" class="min-h-full min-w-full bg-mine text-white font-roboto" data-auth="{{ Auth::check() ? 'true' : 'false' }}">
        <nav id="navbar" class="z-20 fixed w-full py-2 h-16 bg-opacity-90 bg-black flex justify-between transition-transform duration-300 transform translate-y-0">
            <div id="navbar-left" class="items-center flex p-1 child:mx-2">
                <h1><label for="show-menu" class="cursor-pointer">☰</label></h1>
                <a href="{{ url('') }}"><img class="tablet:h-8 h-4 object-cover" src="{{asset('minemax/MineMax.png')}}"></a>
            </div>
            @if (Auth::check())
                <div class="hidden mobile:flex items-center">@include('form.main-search', ['member' => Auth::user()->persistentUser->member])</div>
                <ul id="navbar-right" class="items-center flex">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div id="notification-button" class="link relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd"/>
                        </svg>
                        <span id="redDot" class="bg-red rounded-full w-2 h-2 absolute top-0 right-0 hidden"></span>
                        
                    </div>
                        @if (Auth::user()->persistentUser->type_ === 'Member' || Auth::user()->persistentUser->type_ === 'Blocked') 
                            <a id="profile" class="desktop:mx-0 mx-3" href="{{ url('members/' . Auth::user()->username) }}">
                                <img class="h-10 w-10" src="{{ Auth::user()->persistentUser->member->getProfileImage() }}" alt="{{ Auth::user()->username }} profile picture">
                            </a>
                        {{-- @elseif (Auth::check() && Auth::user()->persistentUser->type_=='Administrator') --}}
                        {{--    <a href="/admin" class="button mr-3 desktop:mr-0">Admin Page</a> --}}
                        @endif
                        <a id="logout" class="link desktop:flex hidden text-red" href="{{ url('/logout') }}"> Logout </a>
                </ul>                     
                @else
                    <ul id="navbar-right" class="items-center flex mx-5">
                        <a id="login" class="button" href="{{ url('/login') }}"> Login </a>
                    </ul>
            @endif
        </nav>
        <input id="show-menu" type="checkbox" class="hidden peer"/>
        @if(Auth::check())
        <ul id="menu" class="fixed bg-black text-white list-none text-center items-center flex flex-col justify-start top-16 bottom-5 py-3 w-0 peer-checked:mobile:w-80 peer-checked:w-full transition-width duration-500 overflow-x-hidden overflow-y-auto z-10">
            <li class="mobile:hidden visible flex flex-col w-full items-center"> @include('form.main-search', ['member' => Auth::user()->persistentUser->member])<hr class="underline text-white/60 w-2/3 my-3"> </li>
            <li class="menu-item"><a href="/">Home Page</a></li>
            <li class="menu-item"><a href="/worlds">All Worlds</a></li>
            @if (Auth::check() && Auth::user()->persistentUser->type_ === 'Member')
                <li class="menu-item"><a href="/myworlds">My Worlds</a></li>
                <li class="menu-item"><a href="/myprojects">My Projects</a></li>
                <li class="menu-item"><a href="/mytasks">My Tasks</a></li>
                <li class="menu-item"><a href="/members/{{Auth::User()->username}}">Profile</a></li>
                <li class="menu-item"><a href="/create-world">Create World</a></li>
            @endif
            @if (Auth::check())
                <li class="button visible desktop:hidden w-fit"><a href="{{ url('/logout') }}"> Logout </a></li>
            @endif
        </ul>
        @endif
        <div id="notificationArea" class="fixed hidden z-10 bg-dark right-36 top-16 p-1">
            <div class="flex justify-between">
                <h2 class="text-white py-1 mx-5">Notifications</h2>
                <a id="clearNotifications" class="link">Clear Notifications</a>
            </div>
            <ul id="notificationList" class ="max-h-96 max-w-xs overflow-y-auto break-words"></ul>
        </div>
        <main class="bg-black bg-opacity-40 pb-10 pt-24 tablet:px-10 px-2 z-0">
            <section id="content">
                @yield('content')
            </section>
        </main>
        <nav id="footer" class="fixed bottom-0 w-full bg-black flex justify-between px-3 py-1">
            <p> @ 2023 MineMax, Inc. </p>
            <div class="flex space-x-3">
            <p> <a href="/about">About </a></p>
            <p> | </p>
            <p> <a href="/contacts">Contact Us </a></p>
            </div>
        </nav>
    </body>
</html>