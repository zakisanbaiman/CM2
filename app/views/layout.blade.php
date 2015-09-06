<!doctype html>
<html lang="jp" ng-app="myApp">
<head>
<meta charset="UTF-8">
<link href="/css/base.css" rel="stylesheet" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="">
<meta name="description" content="">
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="viewport" content="width=device-width,initial-scale=1.0" />

<script type="text/javascript" src="/js/lib/jquery-1.10.2.min.js"></script>
<link href="/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" />
<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script src="/bootstrap/js/bootstrap.min.js"></script>


{{--<link href="/css/lib/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />--}}
{{--<script src="/js/lib/jquery-ui-1.10.4.custom.min.js"></script>--}}
{{--<script src="/js/lib/jquery.ui.datepicker-ja.js"></script>--}}

<script src="/js/lib/angular.min.js"></script>
<script src="/js/lib/ui-bootstrap-tpls-0.13.2.min.js"></script>

    {{--<script src="./bower_components/angular/angular.js"></script>--}}
    <script src="/packages/ng-file-upload/ng-file-upload.js"></script>
    <script src="/packages/ng-file-upload/ng-file-upload-shim.js"></script>

    {{--<!-- concatenated flow.js + ng-flow libraries -->--}}
    {{--<script src="/js/lib/ng-flow/dist/ng-flow-standalone.min.js"></script>--}}
    {{--<!-- or include the files separately -->--}}
    {{--<script src="/js/lib/flow.js/dist/flow.min.js"></script>--}}
    {{--<script src="/js/lib/ng-flow/dist/ng-flow.min.js"></script>--}}

    {{--<script src="/packages/ng-file-upload-bower-6.0.4/ng-file-upload-shim.min.js"></script> <!-- for no html5 browsers support -->--}}
    {{--<script src="/packages/ng-file-upload-bower-6.0.4/ng-file-upload.min.js"></script>--}}

    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-animate.js"></script>
    <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.3.js"></script>

    <link href="/css/style.css" rel="stylesheet" />

<!--[if lt IE 9]> -->
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<!-- [endif] -->

</head>
@include('header')
@yield('content')
@include('footer')
</html>