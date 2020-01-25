<!DOCTYPE html>
<html lang="id">
    <head>
        @include('templates._partials.vertical._head')
        @include('templates._partials.vertical._styles')
    </head>
    <body>
        <!-- Begin page -->
        <div id="wrapper">
            @include('templates._partials.vertical._topbar')
            @include('templates._partials.vertical._sidebar')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    @yield('content')
                </div> <!-- content -->
                @include('templates._partials.vertical._footer')
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        @include('templates._partials.vertical._scripts')
    </body>
</html>
