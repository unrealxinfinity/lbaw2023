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
        @vite('node_modules/tailwindcss/tailwind.css')
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
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
        <main class="bg-black bg-opacity-50 pb-10 pt-32 sm:mx-10 sm:px-10 px-2 z-0">
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