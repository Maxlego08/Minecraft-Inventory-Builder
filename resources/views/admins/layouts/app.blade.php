<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <title>{{ env('APP_NAME') }} | @yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Shreethemes" name="Minecraft Inventory Builder"/>

    <meta name="author" content="GROUPEZ.XYZ [contact@groupez.dev]">
    <meta name="publisher" content="GROUPEZ.XYZ [contact@groupez.dev]">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@GroupeZ_">
    <meta name="twitter:creator" content="@GroupeZ_">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="GroupeZ | Studio de développement">
    <meta name="twitter:image" content="{{ asset('images/zcenter.png') }}">
    <meta property="og:title" content="GroupeZ | Studio de développement">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="GroupeZ">
    <meta property="og:image" content="{{ asset('images/groupez.png') }}">
    <meta property="og:url" content="{{url('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" crossorigin>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    @vite(['resources/sass/admins/admin.scss', 'resources/js/admins/admin.js'])

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

@include('admins.layouts.sidebar')

<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('admins.layouts.header')
            @yield('content')

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Minecraft Inventory Builder {{ \Carbon\Carbon::now()->year }}</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="toast-container"></div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@if(isset($toast))
    <script>
        window.addEventListener('load', function () {
            window.toast('{{ $toast['type'] }}', '{{ $toast['title'] }}', '{{ $toast['description'] }}', {{ $toast['duration'] }})
        })
    </script>
@endif
@if(Session::has('toast'))
    <script>
        window.addEventListener('load', function () {
            window.toast('{{ Session::get('toast')['type'] }}', '{{ Session::get('toast')['title'] }}', '{{ Session::get('toast')['description'] }}', {{ Session::get('toast')['duration'] }})
        })
    </script>
@endif

@yield('js')
@yield('script')
</body>
</html>
