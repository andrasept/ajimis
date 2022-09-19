<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJI MIS - Manufacturing Integration System</title>
    <!-- bootstrap -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- font awesome -->
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <!-- Morris -->
    <link href="{{asset('css/plugins/morris/morris-0.4.3.min.css')}}" rel="stylesheet">
    <!-- CSS -->
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    @stack('stylesheets')
  </head>
  <body>
    <div id="wrapper">
      <!-- navbar -->
      @auth
        @include('layouts.nav-master')
      @endauth
      <div id="page-wrapper" class="gray-bg">
        <!-- top navbar -->
        @include('layouts.nav-top-master')
        <!-- content -->
        <div class="wrapper wrapper-content">
          @yield('content')
        </div>
        <!-- footer -->
        <div class="footer">
          <div class="float-right">
          </div>
          <div>
            <strong>Copyright</strong> PT Astra Juoku Indonesia &copy; 2022
          </div>
        </div>
      </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('js/inspinia.js')}}"></script>
    <script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
    
    @stack('scripts')

    @section("scripts")

    @show
  </body>
  </html>
