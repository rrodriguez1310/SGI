app.service('documentosService', function ($http, Upload){
	
	this.documentosTrabajador = function(idTrabajador){
		var data = $http({
			method: 'GET',
			url: host+'documentos/documentos_trabajador',
			params : { trabajadore_id : idTrabajador }
		});		
		return data;
	};

	this.documentoDelete = function(idDocumento){
		var data = $http({
			method: 'POST',
			url: host+'documentos/delete',
			data: $.param({ id : idDocumento })
		});		
		return data;
	};

	this.uploadArchivoTrabajador = function(archivo){
		console.log(archivo);
		var data = Upload.upload({
            url: host+'documentos/upload_archivo_trabajador',
            fields: { id : archivo.id },
            file: archivo.file
        });
        return data;
	}
	this.uploadDocumentoTrabajador = function(documentos){
		var data = Upload.upload({
            url: host+'documentos/upload_documento_trabajador',
            fields: documentos.Documento,
            file: documentos.archivo
        });
        return data;
	}

	this.trabajadadoresConDocumentoContrato = function(){
		var data = $http({
			method: 'GET',
			url: host+'documentos/trabajadadores_con_documento_contrato',
		});		
		return data;
	};

	this.contratosTrabajadores = function(){
		return $http({
			method : "GET",
			url : host+"documentos/contratos_trabajadores"
		});
	};
});