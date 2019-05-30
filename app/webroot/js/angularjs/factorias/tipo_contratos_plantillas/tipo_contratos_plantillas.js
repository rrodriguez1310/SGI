app.factory('tipoContratosPlantillasFactory', function(){
	return {
		plantillasPorContrato : function(tipoContratosPlantillas, tipoContratoId){
			plantillas = [];
			angular.forEach(tipoContratosPlantillas, function (plantilla){
				if(plantilla.TipoContratosPlantilla.tipo_contrato_id == tipoContratoId){
					plantillas.push(plantilla);
				}
			});
			return plantillas;
		},
		plantilla : function(plantillas, tipoDocumentoId){
			respuesta = "";
			angular.forEach(plantillas, function (plantilla){
				if(plantilla.TipoContratosPlantilla.tipos_documento_id == tipoDocumentoId){
					respuesta = plantilla.TipoContratosPlantilla.plantilla;
				}
			});
			return respuesta;
		}
	};
})