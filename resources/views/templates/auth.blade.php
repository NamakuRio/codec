<!DOCTYPE html>
<html lang="id">
    <head>
        @include('templates._partials.vertical._head')
        @include('templates._partials.vertical._styles')
    </head>
    <body class="authentication-bg @yield('body-class')">
        @yield('content')

        @include('templates._partials.vertical._scripts')
    </body>
</html>
