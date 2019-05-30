"use strict";
var express = require('express');
var app = express();
var morgan = require('morgan');
var bodyParser = require('body-parser');
var xmlparser = require('express-xml-bodyparser');
var OptaController = require('./app/controllers/opta');

var port = 8080 || process.env.PORT || 5000; // se verifica el puerto donde se firma el token

app.set('port', port);


app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app.use(morgan('dev'));
app.use(function (req, res, next) {
	if(typeof req.headers['x-meta-mime-type'] !== 'undefined' && req.get('Content-Type') !== 'text/xml') {
		req.headers['content-type'] ='text/xml';
	}
  	next();
}); 
app.use(xmlparser());

app.post('/opta', OptaController.optaPush);
app.get('/opta/:feed/:campeonato_id/:temporada_id/carga-archivo', OptaController.optaCargaArchivo);
app.get('/opta/:feed/:campeonato_id/:temporada_id', OptaController.optaF01);
app.get('/paises', OptaController.paises)

app.listen(port, function () {
  console.log('Example app listening on port '+port+'!');
});
