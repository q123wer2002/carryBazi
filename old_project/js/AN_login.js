
BaziPhoto.controller('BaziPhotoLogin',['$scope','$http', '$interval', '$timeout', function BaziPhotoChatting($scope,$http,$interval,$timeout){

	$scope.login = function()
	{
		$scope.user = "test@carrybazi.com.tw";
		$scope.password = "123456";
		//userName, password
		var loginObj = { "method":"login", "userEmail":$scope.user, "userPwd":$scope.password};
		$http({
			method:'POST',
			url:'server/accountAjax.php',
			data: $.param(loginObj),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(json){
			console.log(json);
			if(json.result == "success"){
				location.reload();
			}
		}).
		error(function(json){
			console.warn(json);
		});
	}

}]);