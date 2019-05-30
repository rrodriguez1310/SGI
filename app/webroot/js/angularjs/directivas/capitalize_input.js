app.directive('capitalizeDirective', function($parse) {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, modelCtrl) {
            var capitalize = function(inputValue) {
                var capitalized = '';
                if (angular.isDefined(inputValue)){
                    capitalizeArray = [];
                    inputArray = inputValue.split(' ');
                    angular.forEach(inputArray, function (value){
                        capitalizeArray.push(value.charAt(0).toUpperCase() + value.substring(1));   
                    });
                    capitalized = capitalizeArray.join(" ");
                }
                modelCtrl.$setViewValue(capitalized);
                modelCtrl.$render();      
                return capitalized;
            }
            modelCtrl.$parsers.push(capitalize);
        }
    };
});