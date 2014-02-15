<!DOCTYPE html>
<html data-ng-app>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @section('title')
            Customer Portal
        @show
    </title>

    <!-- Core CSS - Include with every page -->
    {{ HTML::style('/css/bootstrap.min.css') }}
    {{ HTML::style('/font-awesome/css/font-awesome.css') }}

    <!-- Page-Level Plugin CSS - Dashboard -->
    {{ HTML::style('/css/plugins/morris/morris-0.4.3.min.css') }}
    {{ HTML::style('/css/plugins/timeline/timeline.css') }}

    <!-- SB Admin CSS - Include with every page -->
    {{ HTML::style('/css/sb-admin.css') }}


    @yield('styles')

</head>

<body>

<div id="wrapper">

    @include('portal.layouts.header')

    @include('portal.layouts.side')

    <div id="page-wrapper">
    @yield('content')
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- Core Scripts - Include with every page -->
{{ HTML::script('/js/jquery-1.10.2.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js') }}
{{ HTML::script('/js/bootstrap.min.js') }}
{{ HTML::script('/js/plugins/metisMenu/jquery.metisMenu.js') }}

<!-- Page-Level Plugin Scripts - Dashboard -->
{{ HTML::script('/js/plugins/morris/raphael-2.1.0.min.js') }}
{{ HTML::script('/js/plugins/morris/morris.js') }}

<!-- SB Admin Scripts - Include with every page -->
{{ HTML::script('/js/sb-admin.js') }}

<!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
{{ HTML::script('/js/demo/dashboard-demo.js') }}

@yield('scripts')

</body>

</html>
