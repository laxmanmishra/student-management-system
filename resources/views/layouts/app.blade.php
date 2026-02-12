<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
       {{ $page ?? 'Dashboard' }} | Student Management System
    </title>
    @vite(['resources/css/tailadmin.css', 'resources/js/app.js'])

  </head>
  <body
    x-data="{ page: '{{ $page ?? 'dashboard' }}', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false, @stack('alpine-data') }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    @include('partials.preloader')
    <!-- ===== Preloader End ===== -->
    @yield('content')
     <!-- ===== Page Wrapper End ===== -->

     <!-- BEGIN MODAL -->
    @if($page == 'Profile')
    @include('partials.profile.profile-info-modal')
    @include('partials.profile.profile-address-modal')
    @endif
    <!-- END MODAL -->
  </body>
</html>