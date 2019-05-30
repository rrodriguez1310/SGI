"use strict";
var request = require('request');
var extras = {
	url: 'http://api.stg.cdf.fs.cl.nedp.io/', // https://api.cdf.firesport.io/  - http://apifs.estadiocdf-s.nedmedia.io // api.stg.cdf.fs.cl.nedp.io 
	header: {
		//"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IiIsImFwcElkIjoiIiwicHJvZmlsZSI6ImV0bCIsInRpbWUiOiIyMDE2LTEwLTE5VDE2OjQ5OjMyLjA4OFoiLCJpYXQiOjE0NzY4OTU3NzIsImlzcyI6Im5lZG1lZGlhLmlvIn0.xtekutnCkWb_KtKVhIuFVjle7N9g8t45OYN3CBcsCiQ"
		"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IiIsImFwcElkIjoiIiwicHJvZmlsZSI6Im1hbmFnZXIiLCJ0aW1lIjoiMjAxNi0xMC0wN1QxODo1MjoyNS41NDFaIiwiaWF0IjoxNDc1ODY2MzQ1LCJpc3MiOiJuZWRtZWRpYS5pbyJ9.i0L3rDDGM86J2Rv_sRpPNeZ0e-xoRgkFTdu9CO-IGvs"
		//"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjA0ODc0Y2RhLWM2N2EtNGRkMC04NzRiLTQ1NTQ4MTlkYWZlNSIsImFwcElkIjoiZWNkZiIsInByb2ZpbGUiOiJtb2JpbGUiLCJjaGFtcGlvbnNoaXBzIjpbIjM3MC0yMDE2IiwiNjM5LTIwMTYiXSwidGltZSI6IjIwMTYtMTItMTZUMTk6MzI6MTQuMDczWiIsImlhdCI6MTQ4MTkxNjczNCwiaXNzIjoibmVkbWVkaWEuaW8ifQ.vJX9xq3443mVMcu_MWG6Dkj14mJjkYpJBqaUFiVH2w4"
	},
	headerGet: {
		"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjA0ODc0Y2RhLWM2N2EtNGRkMC04NzRiLTQ1NTQ4MTlkYWZlNSIsImFwcElkIjoiZWNkZiIsInByb2ZpbGUiOiJtb2JpbGUiLCJjaGFtcGlvbnNoaXBzIjpbIjM3MC0yMDE2IiwiNjM5LTIwMTYiXSwidGltZSI6IjIwMTYtMTItMTZUMTk6MzI6MTQuMDczWiIsImlhdCI6MTQ4MTkxNjczNCwiaXNzIjoibmVkbWVkaWEuaW8ifQ.vJX9xq3443mVMcu_MWG6Dkj14mJjkYpJBqaUFiVH2w4"
	}
}; 
exports.championshipPush = function (campeonatoId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['championship', campeonatoId].join('/');
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {						
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {				
				console.log(body);
				reject('Ingresado campeonato ned con problemas');
			} else {
				resolve(body);
			}
		});
	});
}

exports.teamsPush = function (campeonatoId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['championship', campeonatoId, 'team'].join('/');		
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {				
				reject(body);
			} else {
				resolve(body);
			}
		});
	});
}

exports.playersPush = function (campeonatoId, teamId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['championship', campeonatoId, 'team', teamId, 'player'].join('/');				
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {			
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
				throw new Error(err);
			} else if (String(response.statusCode).charAt(0) != 2) {				
				reject(body);
			} else {				
				resolve(body);
			}
		});
	});
}

exports.matchDatesPush = function (campeonatoId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['championship', campeonatoId, 'matchdate'].join('/');						
		
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {				
			if (err) {
				console.log(err)				
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {				
				//console.log(response)
				reject(body);
			} else {
				resolve(body);
			}
		});
	});
}

exports.matchDatesMatchsPush = function (matchId, data) {
	return new Promise(function (resolve, reject) {	

		var url = extras.url + ['matchdate', matchId, 'match'].join('/');						
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {				
				reject(body);
			} else {				
				resolve(body);
			}
		});
	});
}

exports.matchDatesMatchPush = function (matchDateId, matchId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['matchdate', matchDateId, 'match', matchId].join('/');			
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {			
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {				
				reject(body);
			} else {				
				resolve(body);
			}
		});
	});
}

exports.teamGet = function (campeonatoId, teamId) {
	return new Promise(function (resolve, reject) {		
		var url = extras.url + ['championship', campeonatoId, 'team', teamId, 'squad'].join('/');						
		request.get({
			url: url,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {
				reject(body);
			} else {
				resolve(body);
			}
		});
	});
}

exports.matchGet = function (matchId) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['match', matchId].join('/');		
		request.get({
			url: url,
			json: true,
			headers: extras.headerGet,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {			
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {
				reject(body);
			} else {
				resolve(body);
			}

		});
	});
};

exports.matchDateGet = function (championshipId){
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['championship', championshipId, 'matchdate'].join('/');						
		request.get({
			url: url,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {			
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {
				reject(body);
			} else {
				resolve(body);
			}
		});
	});
}

exports.incidencePush = function (matchId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['match', matchId, 'incidence'].join('/');
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			}
			if (String(response.statusCode).charAt(0) != 2) {				
				reject(body);
			} else {
				resolve(body);
			}
		});	
	});
}

exports.championshipMatchStatPush = function (championshipId, teamId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['championship', championshipId, 'team', teamId, 'stat'].join('/');
		
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {			
			console.log("body " + JSON.stringify(body,null,2));
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			}
			if (String(response.statusCode).charAt(0) != 2) {				
				reject(body);
			} else {				
				resolve(body);
			}
		});
	});
}

exports.positionsIdPush = function (campeonato, levelId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['championship', campeonato, 'position',  'level', levelId ].join('/');						
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {									
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
				throw new Error(err);
			} else if (String(response.statusCode).charAt(0) != 2) {
				reject(body);
			} else {				
				resolve(body);
			}
		});		
	});
}

exports.positionsPush = function (positionId, teamId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + ['position', positionId, 'team', teamId].join('/');		
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {									
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
				throw new Error(err);				
			} else if (String(response.statusCode).charAt(0) != 2) {				
				reject(body);				
			} else {				
				resolve(body);				
			}			
		});
	});
}

exports.matchTeamPlayerPush = function (championshipId, matchId, teamId, playerId, data) {
	return new Promise(function (resolve, reject) {
		var url = extras.url + [ 'championship', championshipId, 'match', matchId, 'team', teamId, 'player', playerId].join('/');		
		request.put({
			url: url,
			body: data,
			json: true,
			headers: extras.header,
			agentOptions: {
				keepAlive: true
			}
		}, function (err, response, body) {				
			if (err) {
				console.log(err)
				reject('Problemas en request a ' + url);
			} else if (String(response.statusCode).charAt(0) != 2) {				
				reject(body);
			} else {				
				resolve(body);
			}
		});
	});
}