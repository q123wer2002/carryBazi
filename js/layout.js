var BaziPhoto = angular.module('BaziPhoto',['ngWebSocket']);

//right click
BaziPhoto.directive('ngRightClick', function($parse) {
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
BaziPhoto.directive('ngEnter', function() {
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

BaziPhoto.directive('fileOnChange', function() {
  return {
    restrict: 'A',
    link: function (scope, element, attrs) {
      var onChangeFunc = scope.$eval(attrs.fileOnChange);
      element.bind('change', onChangeFunc);
    }
  };
});