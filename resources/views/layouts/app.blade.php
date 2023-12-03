<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Roboto:wght@100;400&display=swap" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/minecraft-4" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        @vite('public/css/app.css')
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script src="https://js.pusher.com/7.0/pusher.min.js" defer></script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    </head>
    <body class="min-h-full min-w-full bg-mine text-white font-roboto">
        <nav id="navbar" class="z-10 fixed top-0 w-full h-28 bg-opacity-90 bg-black flex flex-wrap items-center justify-between my-0 p-4 transition-transform duration-300 transform translate-y-0">
                <div class="items-start flex">
                <label for="show-menu" class="cursor-pointer sm:text-big text-bigPhone sm:m-3 m-2">☰</label>
                <h1 class="font-bold sm:text-superBig text-superBigPhone sm:m-0 mt-1"><a href="{{ url('') }}">MineMax!</a></h1>
                </div>
                @if (Auth::check())
                    @include('form.main-search', ['member' => Auth::user()->persistentUser->member])
                    <ul class="items-center md:flex md:visible hidden m-0">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    
                        <div class="relative button z-10 m-6 inline-flex w-fit" id="notification-button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
                                
                            </svg>
                        </div>
                        <a class="button" @if (Auth::user()->persistentUser->type_ === 'Member') href="{{ url('members/' . Auth::user()->username) }}" @endif> {{ Auth::user()->username }} </a>
                        <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
                    </ul>
                                        
                @else
                    <ul class="items-center md:flex md:visible hidden m-0">
                        <a class="button" href="{{ url('/login') }}"> Login </a>
                    </ul>
                @endif
                
        </nav>
        <input type="checkbox" id="show-menu" class="hidden peer"/>
        <div class="fixed bg-opacity-90 bg-black text-white top-28 h-full w-0 peer-checked:sm:w-1/4 peer-checked:w-full transition-width duration-500 overflow-hidden z-10">
            <ul id="menu-items" class="list-none text-center flex flex-col h-full">
                <li class="menu-item"><a href="/">Home Page</a></li>
                <li class="menu-item"><a href="#">All Worlds</a></li>
                @if (Auth::check() && Auth::user()->persistentUser->type_ === 'Member')
                    <li class="menu-item"><a href="/myworlds">My Worlds</a></li>
                    <li class="menu-item"><a href="/myprojects">My Projects</a></li>
                    <li class="menu-item"><a href="/mytasks">My Tasks</a></li>
                    <li class="menu-item"><a href="/members/{{Auth::User()->username}}">Profile</a></li>
                    <li class="menu-item"><a href="/create-world">Create World</a></li>
                @endif
                @if (Auth::check())
                    <ul class="md:hidden visible my-5">
                        <a class="button" @if (Auth::user()->persistentUser->type_ === 'Member') href="{{ url('members/' . Auth::user()->username) }}" @endif> {{ Auth::user()->username }} </a>
                        <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
                    </ul>
                @else
                    <ul class="md:hidden visible my-10"> 
                        <a class="button" href="{{ url('/login') }}"> Login </a>
                    </ul>
                @endif
            </ul>
        </div>

        <div id="notificationArea" class="hidden bg-white bg-opacity-50 pb-4 pt-4 sm:mx-10 sm:px-10 px-2 absolute right-40 top-20 mt-2 flex flex-col items-center transition-opacity rounded-lg ease duration-900" style="z-index: 999;">
            <ul id="notificationList" class ="text-center  max-h-[400px] overflow-y-auto overflow-x-hidden">
            </ul>
            <a id="clearNotifications" class="button rounded-lg text-white text-center w-full ">Clear Notifications</a>
        </div>
        <main class="bg- bg-opacity-50 pb-10 pt-32 sm:mx-10 sm:px-10 px-2 z-0">
            <section id="content">
                @yield('content')
            </section>
            </main>
            <nav id="footer" class="fixed bottom-0 w-full bg-black flex justify-between px-3 py-1 md:text-medium text-mediumPhone">
                <p> @ 2023 MineMax, Inc. </p>
                <div class="flex space-x-3">
                <p> About </p>
                <p> | </p>
                <p> Contact Us </p>
                </div>
            </nav>
        </main>
    </body>
</html>