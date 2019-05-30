app.filter('capitalize', function() {
	return function(input, all) {
		return (!!input) ? input.replace(/([^\W_]+[^\s-]*) */g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();}) : '';
	}
});

app.filter('parseInt', function() {
	return function(input){
		return parseInt(input);
	}
});

app.filter('isNan', function() {
	return function(input){
		if(isNaN(input)){
			input = 0;
		}
		return input;
	}
});

app.filter('isFinity', function() {
	return function(input){
		if(!isFinite(input)){
			input = 0;
		}
		return input;
	}
});

app.filter('ceroNada', function() {
	return function(input) {
		if(angular.isDefined(input))
		{
			numero = input.replace(",",".");
	        if(parseFloat(numero)==0)
	        {        	
	            input = "";
	        }	
		}
        return input;
  	};
});

app.filter('porcentajeNada', function() {
  return function(input) {
  		numero = input.replace(",",".");
  		input = input+"%";
        if(parseFloat(numero)==0 || numero=="")
        {        	
            input = "";
        }
        return input;
  };
});

app.filter('objectToString', function() {
  return function(array, separador) {
  		dato = "";
  		i = 1;
  		if(angular.isObject(array)){
  			if(Object.keys(array).length>0){
  				angular.forEach(array, function (data){
  					if(Object.keys(array).length == i){
  						dato += data;	
  					}else{
  						dato += data+separador;
  					}
  					i++;
  				});
  			}
  		}
        return dato;
  };
});

app.filter("ordenaXOtroArreglo",function(){
    return function(input,sortBy) {
      if(angular.isDefined(input)){
        var ordered = [];
        for (var key in sortBy) {
            ordered.push(input[sortBy[key]]);
        }
        return ordered;
      }
    };
});

app.filter("undefinedPorValor",function(){
    return function(input,valor) {
        if(angular.isUndefined(input)){
            if(angular.isDefined(valor)){
                input = valor;
            } 
        }
        return input;
    };
});

app.filter("sortArray", function(){
    return function(input){
        input.sort();
        return input;
    }
})

/*Transforma contenido html*/
app.filter('html',function($sce){
    return function(html){
        return $sce.trustAsHtml(html)
    }
})
