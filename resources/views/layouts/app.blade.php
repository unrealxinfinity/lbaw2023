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
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/sweetalert.minimal.css') }}" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="512x512" href="/favicon/android-chrome-512x512.png">
        <link rel="manifest" href="/favicon/site.webmanifest">
        @vite('public/css/app.css')
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script src={{ url('js/pusher.js') }} defer></script>
        <script src={{ url('js/sweetalert.js') }}></script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
        
    </head>
    <body id="main-body" class="min-h-full min-w-full bg-mine text-white font-roboto" data-auth="{{ Auth::check() && (Auth::user()->persistentUser->type_ === 'Member') ? 'true' : 'false' }}">
        <nav id="navbar" class="z-20 fixed w-full py-2 h-16 bg-opacity-90 bg-black flex justify-between transition-transform duration-300 transform translate-y-0">
            <div id="navbar-left" class="items-center flex p-1 child:mx-2">
                <h1><label tabindex=0 for="show-menu" class="cursor-pointer" role="button" aria-controls="menu" aria-expanded="false">☰</label></h1>
                <a href="{{ url('') }}"><img class="tablet:h-8 h-4 object-cover" src="{{asset('minemax/MineMax.png')}}" alt="MineMax logo. Reads MINEMAX in minecraft font"></a>
            </div>
            <div class="hidden mobile:flex items-center">@include('form.main-search')</div>
            @if (Auth::check())
                <ul id="navbar-right" class="items-center flex">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @if(Auth::user()->persistentUser->type_ === 'Member')
                        <div id="notification-button" class="link relative" tabindex="0" role="button" aria-controls="notifications" aria-expanded="false" aria-label="Open notifications">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <title>Notification Icon</title>
                                <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd"/>
                            </svg>
                            <span id="redDot" class="bg-red rounded-full w-2 h-2 absolute top-0 right-0 hidden"></span>
                            <div id="notificationArea" class="absolute hidden z-10 bg-dark right-0 top-10 p-1 rounded-lg">
                                <div class="flex justify-between">
                                    <h2 class="text-white py-1 mx-5">Notifications</h2>
                                    <button id="clearNotifications" class="link">Clear Notifications</button>
                                </div>
                                <ul id="notificationList" class ="max-h-96 max-w-xs overflow-y-auto break-words"></ul>
                            </div>
                        </div>
                    @endif
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
                        <div class="hidden mobile:flex items-center">@include('form.main-search')</div>
                        <a id="login" class="button" href="{{ url('/login') }}"> Login </a>
                    </ul>
            @endif
        </nav>
        @if (Auth::check() && Auth::user()->persistentUser->type_ == "Blocked")
            <div id="session-message" class="z-20 fixed items-center w-full bg-mine-red py-2 flex justify-between transition-transform duration-300 transform translate-y-0 top-16 mx-auto">
                <h2 class="mx-3">You are blocked, check your profile for details</h2>
                <h1 class="cursor-pointer mx-3" id="session-close">&times;</h1>
            </div>
        @elseif (session('success'))
            <div id="session-message" class="z-20 fixed items-center w-full bg-mine-lime py-2 flex justify-between transition-transform duration-300 transform translate-y-0 top-16 mx-auto">
                <h2 class="text-darkGreen mx-3">{{ session('success') }}</h2>
                <h1 class="text-darkGreen cursor-pointer mx-3" id="session-close">&times;</h1>
            </div>
        @endif
        <input id="show-menu" tabindex=0 role="button" aria-controls="menu" aria-expanded="false" type="checkbox" class="sr-only peer"/>
        <ul id="menu" class="fixed bg-black text-white list-none text-center items-center flex flex-col justify-start top-16 bottom-5 py-3 w-0 peer-checked:mobile:w-80 peer-checked:w-full transition-width duration-500 overflow-x-hidden overflow-y-auto z-10">
            <li class="mobile:hidden visible flex flex-col w-full items-center"> @include('form.main-search')<hr class="underline text-white/60 w-2/3 my-3"> </li>
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
            <p> | </p>
            <p> <a href="{{route('show-faqs')}}">FAQs</a></p>
            </div>
        </nav>
    </body>
</html>