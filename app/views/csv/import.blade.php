
<h1></h1>
@extends('layout')
@section('content')
	<body ng-controller="CsvController">
	<main>
		<section class="container">
			<ul>
				<form id="uploadForm" ng-submit="uploadCsvImage()" method="post" enctype="multipart/form-data">
					{{Form::file('uploadCsvImage')}}
					<input type="submit" id="update" value="送信" />
				</form>
			</ul>
		</section>
		<div>
		</div>
	</main>
	</body>

	<script>
		angular.module('myApp', ['ui.bootstrap'])
				.config(function() {
					//...
				});

		angular.module('myApp').
				controller('CsvController',
				['$scope', '$modal', '$http', '$timeout', function($scope, $modal, $http, $timeout) {

					$scope.uploadCsvImage = function(id) {
						var fd = new FormData($('#uploadForm').get(0));
						fd.append('id', id);
						$http.post('/csv/updateCsvImage',fd,{
							headers:{"Content-type":undefined}
							,transformRequest: null
						})
						.success(function(res){
						});
					};
				}]);

	</script>
@stop