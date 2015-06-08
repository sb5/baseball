var baseball = angular.module('baseball', [ ]);

baseball.factory('dataService', function($http) {

url = "http://www.stephenbreighner.com/bball/?";

 return {
  getStats:  function(type){

  	return $http.get(url+type)
}



};

});




baseball.controller('mainController', function($scope, dataService) {
$scope.data = false;
$scope.left_filter = false;
$scope.loading = false;
var type;
$scope.submit = function(){
$scope.loading = true;

console.log($scope.left_filter);
switch($scope.list){

	case "list_pitchers": type = "list_pitchers=1";
	break;
	case "list_games": type = "list_games=1";
	break;
	case "list_pitchers_by_id": type = "list_pitchers_by_id="+$scope.mlbid;
	break;



}
if($scope.left_filter){


type +="&left_filter=1";

}

dataService.getStats(type).success(function(data) {
	$scope.loading = false;
$scope.data = data;

});


}

});
