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
        @vite('node_modules/tailwindcss/tailwind.css')
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    </head>
    <body class="min-h-full min-w-full bg-mine text-white font-roboto">
        <nav id="navbar" class="bg-opacity-0 text-white flex flex-wrap items-center justify-between mx-auto p-4">
                <div class="items-start flex">
                <label for="show-menu" class="cursor-pointer sm:text-big text-bigPhone m-3">☰</label>
                <h1 class="font-bold sm:text-superBig text-superBigPhone"><a href="{{ url('') }}">MineMax!</a></h1>
                </div>
                @if (Auth::check())
                @include('form.main-search', ['member' => Auth::user()->persistentUser->member])
                <div class="items-end flex">
                    <ul> 
                        <a class="button" @if (Auth::user()->persistentUser->type_ === 'Member') href="{{ url('members/' . Auth::user()->username) }}" @endif> {{ Auth::user()->username }} </a>
                        <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
                    @else
                        <a class="button" href="{{ url('/login') }}"> Login </a>
                    </ul>
                </div>
                @endif
        </nav>
        <input type="checkbox" id="show-menu" class="hidden peer"/>
        <div class="fixed bg-black text-white h-full w-0 peer-checked:sm:w-1/4 peer-checked:w-full transition-width duration-500 overflow-hidden">
            <ul id="menu-items" class="list-none text-center block">
                <li><a href="/">Home Page</a></li>
                <li><a href="#">All Worlds</a></li>
                @if (Auth::check() && Auth::user()->persistentUser->type_ === 'Member')
                    <li><a href="/myworlds">My Worlds</a></li>
                    <li><a href="/myprojects">My Projects</a></li>
                    <li><a href="/mytasks">My Tasks</a></li>
                    <li><a href="/members/{{Auth::User()->username}}">Profile</a></li>
                    <li><a href="/create-world">Create World</a></li>
                @endif
            </ul>
        </div>
            <main>
            <section id="content">
                @yield('content')
            </section>
            </main>
            <nav class="absolute bottom-0 w-full bg-black flex justify-between px-3">
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