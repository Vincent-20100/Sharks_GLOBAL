
var sharksApp = angular.module('sharksApp', []);
sharksApp.controller('sharksCtrl', function ($scope, $http) {
	$http.get("php_script/comboBoxSharksSpecies.php")
	.then(function (response) {
		$scope.sharks = response.data.records;
	});
});
