app.factory('documentosFactory', function () {

	return {
		documentosContratos : function(documentos) {
			documentosArray = [];
			if(documentos.length != 0){
				angular.forEach(documentos, function (documento){
					switch(documento.Documento.tipos_documento_id){
						case 1:
						case 3:
						case 4:
						case 23:
						case 24:
						case 25:
							documentosArray.push(documento);
							break;
					}
				})	
			}
			
			return documentosArray;
		}
	}
});