app.service('promocionesService', function ($http){
	this.promoListCompChannel = function (companyId, channelId){
		return $http({
			method : "GET",
			url : host+"promociones/promo_list_compa_channel/"+companyId+"/"+channelId,
			headers : {
				'X-Requested-With': 'XMLHttpRequest'
			}
		});
	}

	this.promociones = function (){
		return $http({
			method : "GET",
			url : host+"promociones/promociones",
			headers : {
				'X-Requested-With': 'XMLHttpRequest'
			}
		});	
	}

	this.delete = function (id){
		return $http({
			method : "POST",
			url : host+"promociones/delete/"+id,
			headers : {
				'X-Requested-With': 'XMLHttpRequest'
			}
		});	
	}
});