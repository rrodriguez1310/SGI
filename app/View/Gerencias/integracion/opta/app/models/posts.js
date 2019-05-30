"use strict";
var Sequelize = require('sequelize');
var db = require('../../config').optaDb;
module.exports = db.define('posts', {
	headers: {
		type: Sequelize.JSON
	},
	body: {
		type: Sequelize.JSON
	}
}, {
	freezeTableName: true
});
