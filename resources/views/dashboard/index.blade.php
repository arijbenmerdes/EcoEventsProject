<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/font-awesome/css/font-awesome.min.css') }}">

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/favicon.png') }}" />

  </head>

  <body>
    <div class="container-scroller">

      <!-- Navbar -->
      @include('dashboard.partials.navbar')

      <div class="container-fluid page-body-wrapper">

        <!-- Sidebar -->
        @include('dashboard.partials.sidebar')

        <!-- Main Panel -->
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>
          <!-- content-wrapper ends -->

          <!-- Footer -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.
              </span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i>
              </span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller ends -->

    <!-- Scripts dans le bon ordre -->
    <!-- jQuery (une seule fois) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Vendor scripts -->
    <script src="{{ asset('dashboard/assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin js for this page -->
    <script src="{{ asset('dashboard/assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <!-- Core scripts -->
    <script src="{{ asset('dashboard/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/misc.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/settings.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/todolist.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/jquery.cookie.js') }}"></script>

    <!-- Feature scripts -->
    <script src="{{ asset('dashboard/assets/js/jquery-file-upload.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/file-upload.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/select2.js') }}"></script>

    <!-- Dashboard script -->
    <script src="{{ asset('dashboard/assets/js/dashboard.js') }}"></script>

    <!-- SECTION POUR LES SCRIPTS SPÉCIFIQUES AUX PAGES -->
    @yield('scripts')

  </body>
</html>
