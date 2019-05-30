// <input type="text" number-format decimals="2" negative="false"/>

app.directive('numberFormat', ['$filter', '$parse', function ($filter, $parse) {
  return {
    require: 'ngModel',
    link: function (scope, element, attrs, ngModelController) {
      
      var decimals = (!angular.isDefined($parse(attrs.decimals)(scope))) ? 0 : $parse(attrs.decimals)(scope);
      var negative = (!angular.isDefined($parse(attrs.negative)(scope))) ? true : $parse(attrs.negative)(scope);

      ngModelController.$parsers.push(function (data) {
        var parsed = parseFloat(data);                              // Attempt to convert user input into a numeric type to store
        return !isNaN(parsed) ? parsed : undefined;
      });
     
     ngModelController.$formatters.push(function (data) {
        return $filter('number')(data, decimals);                   //convert data from model format to view format
      });

      element.bind('focus', function () {        
        element.val(ngModelController.$modelValue);
      });

      element.bind('keyup', function () {
        if(angular.isDefined(ngModelController.$modelValue)){

          if(!negative&&ngModelController.$modelValue<0){
            element.val(ngModelController.$modelValue*-1);
            ngModelController.$setViewValue(element.val());
            ngModelController.$render();
          }
          
          if(ngModelController.$modelValue!=null){
            var partes = ngModelController.$modelValue.toString().split('.');
            if(angular.isDefined(partes[1])){
              if (partes[1].length > decimals){
                var valor = parseFloat(ngModelController.$modelValue);
                if(valor>0)
                  element.val(Math.floor(valor * Math.pow(10,decimals) ) / Math.pow(10,decimals));
                else
                  element.val( (Math.floor( -1 * valor * Math.pow(10,decimals) ) / Math.pow(10,decimals)) * -1 );

                ngModelController.$setViewValue(element.val());
                ngModelController.$render();
              }
            }
          }
        }
      });

      element.bind('blur', function () {
        var formatted = $filter('number')(ngModelController.$modelValue, decimals);   // Apply formatting on the stored model value for display
        element.val(formatted);
      });
    }
  }
}]);


/*
app.directive('format', ['$filter', function ($filter) {
    return {
        require: '?ngModel',
        link: function (scope, elem, attrs, ctrl) {
            if (!ctrl) return;            
            ctrl.$formatters.unshift(function (a) {
                console.log(a);
                return $filter(attrs.format)(ctrl.$modelValue);
            });
            ctrl.$parsers.unshift(function (viewValue) {
                var plainNumber = viewValue.replace(/[\-+|\.+|\,+]/g, '');
                elem.val($filter('number')(plainNumber));
                return plainNumber;
            });
        }
    };
}]);
*/