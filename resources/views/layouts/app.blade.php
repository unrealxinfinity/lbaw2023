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
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    </head>
    <body>
        <main>
            <header>
                <input type="checkbox" id="menu-toggle">
                <label for="menu-toggle" class="label-toggle"></label>
                <ul class="menu">
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
                <h1><a href="{{ url('') }}">MineMax!</a></h1>
                @if (Auth::check())
                @include('form.main-search', ['member' => Auth::user()->persistentUser->member])
                <ul> 
                    <a class="button" @if (Auth::user()->persistentUser->type_ === 'Member') href="{{ url('members/' . Auth::user()->username) }}" @endif> {{ Auth::user()->username }} </a>
                    <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
                @else
                    <a class="button" href="{{ url('/login') }}"> Login </a>
                </ul>
                @endif
            </header>
            <section id="content">
                @yield('content')
                
            </section>
            <footer>
                <div> @ 2023 MineMax, Inc. </div>
                <div> About </div>
                <div> | </div>
                <div> Contact Us </div>  
            </footer>
        </main>
    </body>
</html>