"use strict";
var Sequelize = require('sequelize');
var db = require('../../config').optaDb;
module.exports = db.define('f40s', {
	type : {
		type: Sequelize.STRING
	},
	competition_code: {
		type: Sequelize.STRING
	},
	competition_id: {
		type: Sequelize.STRING
	},
	competition_name: {
		type: Sequelize.STRING
	},
	season_id: {
		type: Sequelize.STRING
	},
	season_name: {
		type: Sequelize.STRING
	},
	update_opta: {
		type: Sequelize.DATE
	},
	teams: {
		type: Sequelize.JSON
	},
	playerchanges: {
		type: Sequelize.JSON
	}
}, {
	freezeTableName: true
});
