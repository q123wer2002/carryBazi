
var CarryBaziPhoto = angular.module('CarryBaziPhoto', ['ngRoute']);

CarryBaziPhoto.config(['$routeProvider', function ($routeProvider) {

    $routeProvider
    .when('/',
        {
            controller: 'indexController',
            templateUrl: 'index/index.html'
        })
    .when('/case',
        {
            controller: 'caseController',
            templateUrl: 'case/case.html'
        })
    .when('/theme',
        {
            controller: 'themeController',
            templateUrl: 'theme/theme.html'
        })
    .when('/special',
        {
            controller: 'specialController',
            templateUrl: 'special/special.html'
        })
    .when('/userInfo',
        {
            controller: 'userInfoController',
            templateUrl: 'userInfo/index.html'
        })

    .otherwise({ redirectTo: '/' });

}]);


CarryBaziPhoto.controller('MainController',['$scope','$http', '$interval', '$route', '$routeParams', '$location',function SyntecRemote($scope,$http,$interval,$route,$routeParams,$location){

    //template url
    $scope.templates = {
        TOP    : "share/top.html",
        BODY   : "",
        FOOTER : "share/footer.html",
    };
    
    $scope.AllJavascripts = [
        {"folderName":"index", "jsName":"index.js"},
        {"folderName":"userInfo", "jsName":"userInfo.js"},
    ];


}]);

CarryBaziPhoto.filter('round', function() {
    return function(input) {
        return Math.round(input*100)/100;
    };
});

//right click
CarryBaziPhoto.directive('ngRightClick', function($parse) {
    return function(scope, element, attrs) {
        var fn = $parse(attrs.ngRightClick);
        element.bind('contextmenu', function(event) {
            scope.$apply(function() {
                event.preventDefault();
                fn(scope, {$event:event});
            });
        });
    };
});

//press enter
CarryBaziPhoto.directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if(event.which === 13) {
                scope.$apply(function(){
                        scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
