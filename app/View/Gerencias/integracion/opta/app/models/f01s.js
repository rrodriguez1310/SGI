"use strict";
var Sequelize = require('sequelize');
var db = require('../../config').optaDb;
module.exports = db.define('f01s', {
	campeonato_id: {
		type: Sequelize.INTEGER
	},
	campeonato_nombre: {
		type: Sequelize.STRING
	},
	temporada_id: {
		type: Sequelize.INTEGER
	},
	temporada_nombre: {
		type: Sequelize.STRING
	},
	timestamp: {
		type: Sequelize.DATE
	},
	matchs: {
		type: Sequelize.JSON
	},
	teams: {
		type: Sequelize.JSON
	}
}, {
	freezeTableName: true
});
