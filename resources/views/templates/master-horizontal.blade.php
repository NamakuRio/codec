<!DOCTYPE html>
<html lang="id">
    <head>
        @include('templates._partials.horizontal._head')
        @include('templates._partials.horizontal._styles')
    </head>
    <body>
        <!-- Navigation Bar-->
        <header id="topnav">
            @include('templates._partials.horizontal._topbar')
            @include('templates._partials.horizontal._nav-horizontal')
        </header>
        <!-- End Navigation Bar-->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
            <div class="wrapper">
                <div class="container-fluid">
                    @yield('content')
                    @include('templates._partials.horizontal._footer')
                    <!-- ============================================================== -->
                    <!-- End Right content here -->
                    <!-- ============================================================== -->
                </div> <!-- end wrapper -->
            </div>
            <!-- end wrapper -->
        @include('templates._partials.horizontal._scripts')
    </body>
</html>
