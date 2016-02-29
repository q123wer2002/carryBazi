
BaziPhoto.factory('SocketData', function($websocket) {
  // Open a WebSocket connection
  var ws = $websocket('ws://localhost:8000');
  
  var serverPushMsg = [];
  

  ws.onMessage(function(message) {
    var Mesage = JSON.parse(message.data);
    
    switch(Mesage.type){
        case "finishOpen":
          if(Mesage.data == "doRegistering"){
            ws.send("register",{name:ws.myName, receiver:ws.receiver});
          }
        break;

        case "onliners":
          var onlineUserList = [];

          angular.forEach( Mesage.data, function(userName, userResourceID){
            if( userName != "" && userName != ws.myName ){
              onlineUserList.push(userName);
            }
          });

          for(var i=0; i<onlineUserList.length; i++){
            var isUserSignYet = false;
            
            for(var j=0; j<ws.userLists.length; j++){
              if( onlineUserList[i] == ws.userLists[j].name ){
                ws.userLists[j].isOnline = true;
                isUserSignYet = true;
                continue;
              }
            }

            if( isUserSignYet == false ){
              var userObj = {'name':onlineUserList[i], 'isOnline':true, 'numOfNoReadMsg':0};
              ws.userLists.push(userObj);
            }
          }

        break;

        case "fetchMessage":
          ws.messages.push(Mesage.data);
        break;

        case "single":
          if(Mesage.data.type == "more_messages"){
            //console.log(Mesage.data);
            ws.messages.unshift(Mesage.data);
            break;
          }
          //console.log(Mesage.data);
          ws.messages.push(Mesage.data);
        break;

        case "readYet":
          for(var i=0; i<ws.userLists.length; i++){
            if(ws.userLists[i].name == Mesage.data.sender){
              
              if(ws.receiver == Mesage.data.sender){
                ws.messages.push(Mesage.data);
              }else{
                ws.userLists[i].numOfNoReadMsg++;
              }
              
              break;
            }
          }
        break;

        default:
        break;
    }
    
    //serverPushMsg.push(Mesage);
  });

  var methods = {
      serverPushMsg: serverPushMsg,
      //userLists:ws.userLists,
      connect: function(userName, userLists, messages){
        ws.myName = userName;
        
        ws.userLists = userLists;
        ws.messages = messages;

        ws._connect();
      },
      status: function() {
        return ws.readyState;
      },
      send: function(type, data) {
        if( data.receiver != null && data.receiver != "" ){
          ws.receiver = data.receiver;
        }

        ws.send( type ,data );
      }
    };

  return methods;
});

BaziPhoto.controller('BaziPhotoChatting',['$scope','$http', '$interval', '$timeout', 'SocketData', function BaziPhotoChatting($scope,$http,$interval,$timeout,SocketData){
	
	$scope.myName = "";
	$scope.receiver = "";
	$scope.errorMsg = "";

  $scope.isLogin = false;
  $scope.userLists = [];
  $scope.messages = [];

  $scope.messageInput = "";

  //debug
  $scope.serverPushMsg = SocketData.serverPushMsg;

  $scope.isUserLogin = function(){
    if($scope.myName != ""){
      $scope.goChatting();
    }
  }
	
	$scope.goChatting = function(){
		if($scope.myName == ""){
			$scope.errorMsg = "請輸入暱稱";
			return;
		}

		$scope.errorMsg = "";
		var loginObj = {"action" : "login", "myName": $scope.myName};
		$http({
			method:'POST',
			url:'server/talkUpload.php',
			data: $.param(loginObj),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(result){
			if(result == "success"){
        $scope.isLogin = true;        		
    		$scope.initUserList();
      }
		}).
		error(function(json){
			console.warn(json);
		});
	}
	$scope.initUserList = function(){
		var userListObj = {"action" : "initUserList"};
		$http({
			method:'POST',
			url:'server/talkUpload.php',
			data: $.param(userListObj),
			headers: {'Content-type': 'application/x-www-form-urlencoded'},
		}).
		success(function(result){
      //console.log(result);
			$scope.getEachUser(result);
		}).
		error(function(json){
			console.warn(json);
		});
	}
	$scope.getEachUser = function( userListJSON ){
		for(var i=0; i<userListJSON.length; i++){
      //get the count of no read msg
      var userListObj = {"action" : "getNumOgNoReadMsg", "receiver": userListJSON[i]};
      $http({
        method:'POST',
        url:'server/talkUpload.php',
        data: $.param(userListObj),
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
      }).
      success(function(json){
        if(json.result == "success"){
          var userObj = {'name': json.user, 'isOnline':false, 'numOfNoReadMsg': json.num};
          $scope.userLists.push( userObj );
        }
      }).
      error(function(json){
        console.warn(json);
      });
		}

		jQuery(".chatDiv").css('display','block');
		SocketData.connect( $scope.myName, $scope.userLists, $scope.messages );

	}

  $scope.sendMsg = function(){
    if($scope.messageInput == ""){
      $scope.errorMsg = "null";
      return;
    }
    SocketData.send("send", {"type" : "text", "msg": $scope.messageInput, "user":$scope.myName, "receiver": $scope.receiver});
    $scope.messageInput = "";
  }
  $scope.sendPhoto = function(){
    var files = event.target.files;
    //console.log( files );
    
    for(var i=0; i<files.length; i++){
      fd = new FormData();
      fd.append('file', files[i]);

      $http.post("server/talkUpload.php", fd, {
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined}
      })
      .success(function(fileName){
        //console.log(fileName);
        SocketData.send("send", {"type" : "img", "file_name": fileName, "user":$scope.myName, "receiver": $scope.receiver});
      })
      .error(function(error){
        console.warn(error);
      });

    }

  }

  $scope.btnMoreMsg_Click = function(){
    $scope.messages.splice( 0, $scope.messages.length );
    SocketData.send("fetch",{"user":$scope.myName, "receiver": $scope.receiver});
  }

  $scope.talkTo = function( user ){
    $scope.messages.splice( 0, $scope.messages.length );
    $scope.receiver = user.name;

    var userListObj = {"action" : "clearNoReadMsg", "receiver": user.name};
    $http({
      method:'POST',
      url:'server/talkUpload.php',
      data: $.param(userListObj),
      headers: {'Content-type': 'application/x-www-form-urlencoded'},
    }).
    success(function(json){
      if(json == "success"){
        user.numOfNoReadMsg = 0;
        SocketData.send("getTalking",{"user":$scope.myName, "receiver": $scope.receiver});
      }
    }).
    error(function(json){
      console.warn(json);
    });
  }

  $scope.showImgView = function( imgSrc ){
    $scope.ViewImgSrc = "images/talk/uploads/" + imgSrc;
    console.log($scope.ViewImgSrc);
    jQuery('.blackBG').css({'display':'block'});
  }
  $scope.clearImgView = function(){
    jQuery('.blackBG').css({'display':'none'});
  }

}]);

