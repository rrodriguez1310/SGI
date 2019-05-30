"use strict";
var request = require('request');
var extras = {
	"prot": "http://",
	"urlProd": 'www.cdf.cl/app_campeonatos/cpan/campeonatos/set_programacion/',
	"urlDev": '200.91.40.246/app_campeonatos/cpan/campeonatos/set_programacion/',
	"passDev": encodeURIComponent("fdt%$bhr4f")
};
 
exports.pushFixture = function (data) {
	return new Promise(function (resolve, reject) {
		request.put({
			url: extras.prot + 'cdf:' + extras.passDev + '@' + extras.urlDev,	//dev
			//url: extras.prot + extras.urlProd,	//prod
			body: data,
			json: true,			
			agentOptions: {
				keepAlive: true
			} 
		}, function (err, response, body){
			if (err){
				reject('Problemas en request a ' + extras.urlDev);
			} else if (String(response.statusCode).charAt(0) != 2){
				console.log('Campeonato altavoz no ingresado')
				reject('Campeonato altavoz no ingresado');
			} else {
				console.log(JSON.stringify("exito: "+body.exito,null,2));
				resolve(body.exito);
			}
		});
	});
}

	/*return Promise.resolve()
        .then(function() {
            //return pushFixtureAv(extras.prot + extras.urlProd);	//prod
	    	return pushFixtureAv(extras.prot + 'cdf:' + extras.passDev + '@' + extras.urlDev);
        }).catch(function(reason){
			return Promise.reject(reason);
		});*/