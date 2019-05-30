app.factory('usersFactory', function(){
	return {
		usersPorId : function(users){
			respuesta = {};
			if(users.length!=0){
				angular.forEach(users, function (user){
					respuesta[user.UsuarioId] = user;
				});
			}
			return respuesta;
		}
	};
})