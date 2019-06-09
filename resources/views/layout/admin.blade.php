<!DOCTYPE html>
<!--
* CoreUI Pro - Bootstrap Admin Template
* @version v2.1.10
* @link https://coreui.io/pro/
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* License (https://coreui.io/pro/license)
-->

<html lang="en">
  <head>
   @include('cms.includes.head')
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
      @include('include.navbar')
    <div class="app-body">
        @include('include.sidebar')
      <main class="main">
          @include('include.breadcrumb')
          @yield('admin.home')
      </main>
      <aside class="aside-menu">
        Aside
      </aside>
    </div>
    @include('include.footer')
  </body>
</html>
