app.directive('modal', function() {
  var getHtml = "";
      getHtml+= '<div class="modal fade" data-backdrop="static" data-keyboard="false">';
      getHtml+= '<div class="modal-dialog {{tamanioModal}}">'; 
      getHtml+= '<div class="modal-content">'; 
      getHtml+= '<div class="modal-header">'; 
      getHtml+= '<h4 class="modal-title">{{ titulo }}</h4>';
      getHtml+= '</div>';
      getHtml+= '<div class="modal-body" ng-transclude></div>'; 
      getHtml+= '</div>';
      getHtml+= '</div>'; 
      getHtml+= '</div>';
  return {
    template: getHtml,
    restrict: 'E',
    transclude: true,
    replace:true,
    scope:true,
    link: function postLink(scope, element, attrs) {
      scope.title = attrs.title;
      scope.$watch(attrs.visible, function(value){
        if(value == true)
          $(element).modal('show');
        else
          $(element).modal('hide');
      });

      $(element).on('shown.bs.modal', function(){
        scope.$apply(function(){
          scope.$parent[attrs.visible] = true;
        });
      });

      $(element).on('hidden.bs.modal', function(){
        scope.$apply(function(){
          scope.$parent[attrs.visible] = false;
        });
      });
    }
  }
});


