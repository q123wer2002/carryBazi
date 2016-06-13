var CarryBaziPhoto = angular.module('CarryBaziPhoto',['ngRoute', 'luegg.directives']);

CarryBaziPhoto.config(['$routeProvider', '$locationProvider',function($routeProvider, $locationProvider) {
    $routeProvider
    .when('/',{
    })
    .when('/search', {
    templateUrl : 'templates/web/content/search.html',
    });
}]);

CarryBaziPhoto.controller('MainController',['$scope','$http', '$interval', '$route', '$routeParams', '$location',function SyntecRemote($scope,$http,$interval,$route,$routeParams,$location){
    this.$route = $route;
    this.$location = $location;
    this.$routeParams = $routeParams;

    //template url
    $scope.templates = {
        TOP    : "share/top.html",
        BODY   : "",
        FOOTER : "share/footer.html",
    };


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
