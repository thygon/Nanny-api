<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicon.png')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nanny</title>
    
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\vendor\toastr\toastr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/linearicons/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist-custom.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css')}}">
    <style>

     .btn-primary{
        background-color:#2bb673 !important;
        border-color: #2bb673 !important;
     }
     .sidebar .nav li>a.active{
        border-left-color: #2bb673;
     }
     .sidebar .nav li>a.active i{
        color: #2bb673;
     }
     .sidebar .nav li>a:hover{
        border-left-color: #2bb673;
     }
     .sidebar .nav li>a:hover i{
        color: #2bb673;
     }
     .sidebar .nav li>a:focus{
        border-left-color: #2bb673;
     }
     .sidebar .nav li>a:focus i{
        color: #2bb673;
     }
     .metric .icon{
        background-color: #2bb673;
     }
     .ct-series-a .ct-point, .ct-series-a .ct-line, .ct-series-a .ct-bar, .ct-series-a .ct-slice-donut {
            stroke: #2bb673;
    }
     .ct-series-a .ct-slice-pie, .ct-series-a .ct-area {
        fill: #2bb673;
    } 
    .layout-fullwidth #wrapper .btn-toggle-fullwidth {
            color: #2bb673;
        }  

    .html5buttons{
        float:right;
    }
    .dataTables_length {
        float: left;
    }
    </style>
    @yield('topstyles');
</head>
<body>
    <div id="wrapper" >
        @section('topnav')
          @include('layouts.header')
        @show
        @section('sidenav')
          @include('layouts.sidenav')
        @show

        <div class="main" >
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- END MAIN -->
        <div class="clearfix"></div>
        <footer>
            <div class="container-fluid">
                <p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
            </div>
        </footer>
    </div>
    <div class="clearfix"></div>

   
    <!-- Javascript -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.min.js')}}" ></script>
    <script src="{{ asset('js/datatables.min.js')}}" ></script>

    @yield('scripting')

    <script>
        var status = '{{Session::get('status')}}';

        switch(status){
            case 'success':
              toastr.success('{{Session::get('message')}}','{{Session::get('title')}}');
              break;
            case 'error':
              toastr.warning('{{Session::get('message')}}','{{Session::get('title')}}');
              break;
            case 'info':
              toastr.info('{{Session::get('message')}}');
              break;
        }


    </script>


    <script src="{{ asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/chartist/js/chartist.min.js')}}"></script>
    <script src="{{ asset('assets/scripts/klorofil-common.js')}}"></script>

    <script>
         $(function() {
            var data, options;

            // headline charts
            data = {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                series: [
                    [23, 29, 24, 40, 25, 24, 35],
                    [14, 25, 18, 34, 29, 38, 44],
                ]
            };

            options = {
                height: 300,
                showArea: true,
                showLine: false,
                showPoint: false,
                fullWidth: true,
                axisX: {
                    showGrid: false
                },
                lineSmooth: false,
            };

            new Chartist.Line('#headline-chart', data, options);

            var data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                series: [
                    [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
                ]
            };

                // line chart
            options = {
                height: "300px",
                showPoint: true,
                axisX: {
                    showGrid: false
                },
                lineSmooth: false,
            };

            new Chartist.Line('#demo-line-chart', data, options);


                // area chart
            options = {
                height: "270px",
                showArea: true,
                showLine: false,
                showPoint: false,
                axisX: {
                    showGrid: false
                },
                lineSmooth: false,
            };

            new Chartist.Line('#demo-area-chart', data, options);

        });

         function mySpy(){
          var current = window.location.href;

          var links = $('.sidebar#sidebar-nav nav .nav>li a');
            for (var i = links.length - 1; i >= 0; i--) {
              $(links[i]).removeClass('active');
            }
           
          $.each(links,function(key , val){
            var href = $(val).attr('href');
            console.log('current'+current);
            console.log('href'+href);
            var isSim = href == current;
            if(isSim){
               $(val).addClass('active');
            }
          });

        }
        mySpy();
    </script>
</body>
</html>
