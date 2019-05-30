app.service('subscribersService', function ($http){
	this.add = function (data) {
		return $http({
			method : "POST",
			url : host+"subscribers/add",
			data : $.param(data),
			headers : {
				'X-Requested-With': 'XMLHttpRequest'
			}
		});
	}

	this.subscribersTreceMeses = function (yearId, monthId){
		return $http({
			method : "GET",
			url : host+"subscribers/subscribers_trece_meses/"+yearId+"/"+monthId,
			headers : {
				'X-Requested-With': 'XMLHttpRequest'
			}
		});
	}

	this.companiesSubscribers = function (){
		return $http({
			method : "GET",
			url : host+"subscribers/companies_subscribers",
			headers : {
				'X-Requested-With': 'XMLHttpRequest'
			}
		});
	}
});