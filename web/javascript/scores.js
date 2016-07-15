
var scoresApp = angular.module('scoresApp', []);
scoresApp.controller('scoresCtrl', function ($scope, $http) {
	$http.get("php_script/dbScores.php")
	.then(function (response) {
		$scope.scoresTable = response.data.records;
	});
});
