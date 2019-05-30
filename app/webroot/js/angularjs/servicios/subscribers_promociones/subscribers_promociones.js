app.service('subscribersPromocionesService', function($http){
	this.add = function (data) {
		return $http({
			method : "POST",
			url : host+"subscribers_promociones/add",
			data : data,
			headers : {
				'X-Requested-With': 'XMLHttpRequest'
			}
		});
	}
	this.subsPromo = function (companyId, yearId, monthId, channelId, signalId){
		return $http({
			method : "GET",
			url : host+"subscribers_promociones/subs_promo/"+companyId+"/"+yearId+"/"+monthId+"/"+channelId+"/"+signalId,
		});
	}
})