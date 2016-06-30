
var app = angular.module('myApp', []);
app.controller('sharksCtrl', function ($scope, $http) {
	$http.get("php_script/comboBoxSharksSpecies.php")
	.then(function (response) {
		$scope.sharks = response.data.records;
	});
});
