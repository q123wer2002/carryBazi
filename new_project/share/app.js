
    var CarryBaziPhoto = angular.module('CarryBaziPhoto', ['ngRoute']);

    CarryBaziPhoto.config(['$routeProvider', function ($routeProviders) {
        
        //Change default views and controllers directory using the following:
        //routeResolverProvider.routeConfig.setBaseDirectories('/app/views', '/app/controllers');


        //Define routes - controllers will be loaded dynamically

        /*$routeProvider
        .when('/customers', route.resolve('Customers'))
        .when('/customerorders/:customerID', route.resolve('CustomerOrders'))
        .when('/orders', route.resolve('Orders'))
        .otherwise({ redirectTo: '/customers' });*/

        //$routeProvider
        //.when('/', route.resolve('indexController'))
        //.when('/userInfo', route.resolve());

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

        $scope.Draw = function()
        {
            var ctx = document.getElementById("draw").getContext("2d");
            ctx.strokeStyle = "000000000000000000";
            ctx.rect(10, 10 ,100, 100);
            ctx.stroke();
            console.log(element);
        }

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


/*CarryBaziPhoto.controller('MainController',['$scope','$http', '$interval', '$route', '$routeParams', '$location',function SyntecRemote($scope,$http,$interval,$route,$routeParams,$location){

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

}]);*/
