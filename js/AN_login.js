
BaziPhoto.controller('BaziPhotoLogin',['$scope','$http', '$interval', '$timeout', function BaziPhotoChatting($scope,$http,$interval,$timeout){

	$scope.login = function(){
		//userName, password
		var loginObj = { "method":"login" };
		$http({
			method:'POST',
			url:'server/accountAjax.php',
			data: $.param(loginObj),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			if(json.result == "success"){
				location.reload();
			}
		}).
		error(function(json){
			console.warn(json);
		});
	}

}]);