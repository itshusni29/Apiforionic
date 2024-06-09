<!doctype html>
<html lang="en" class="minimal-theme">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('skodash/assets/images/favicon-32x32.png') }}" type="image/png" />
  
  <!-- Plugins CSS -->
  <link href="{{ asset('skodash/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
  
  <!-- Bootstrap CSS -->
  <link href="{{ asset('skodash/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/icons.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

  <!-- Loader CSS -->
  <link href="{{ asset('skodash/assets/css/pace.min.css') }}" rel="stylesheet" />

  <!-- Theme Styles -->
  <link href="{{ asset('skodash/assets/css/dark-theme.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/light-theme.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/semi-dark.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/header-colors.css') }}" rel="stylesheet" />

  <title>@yield('title')</title>
</head>

<body>

  <!-- Start wrapper -->
  <div class="wrapper">
    <!-- Start top header -->
    @include('layouts.navbar')
    <!-- End top header -->

    <!-- Start sidebar -->
    @include('layouts.sidebar')
    <!-- End sidebar -->

    <!-- Start content -->
    <main class="page-content">
      @yield('content')
    </main>
    <!-- End page main -->

    <!-- Start Back To Top Button -->
    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!-- End Back To Top Button -->

  </div>
  <!-- End wrapper -->

  <!-- Bootstrap bundle JS -->
  <script src="{{ asset('skodash/assets/js/bootstrap.bundle.min.js') }}"></script>
  
  <!-- Plugins JS -->
  <script src="{{ asset('skodash/assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/easyPieChart/jquery.easypiechart.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/peity/jquery.peity.min.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('skodash/assets/js/pace.min.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('skodash/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
  
  <!-- App JS -->
  <script src="{{ asset('skodash/assets/js/app.js') }}"></script>
  <script src="{{ asset('skodash/assets/js/index.js') }}"></script>

  <script>
    new PerfectScrollbar(".best-product")
    new PerfectScrollbar(".top-sellers-list")
  </script>

  @stack('scripts')

</body>

</html>
