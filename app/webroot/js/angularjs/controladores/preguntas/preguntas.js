app.controller('Preguntas', ['$scope', '$http', '$window', 'preguntas', 'Flash', function($scope, $http, $window, preguntas, Flash) {
    $scope.loader = true
    $scope.cargador = loader;

    $scope.formulario = {
        status: '',
        url: '',
        porcentaje: '',
        calificacion: '',
        messageTest: ''
    };
    var dataLength = 0;

    preguntas.listaPreguntas().success(function(dataPreguntas) {

        $scope.loader = false;
        $scope.contenido = true;
        $scope.preguntasList = dataPreguntas;
        $scope.dataTest1 = [];
        $scope.titleQuiz = null;
        $scope.descriptionQuiz = null;
        $scope.urlAprobado = null;
        $scope.urlReprobado = null;
        $scope.pruebaID = null;
        var dataTest3 = [];
        for (var i in $scope.preguntasList) {
            if ($scope.preguntasList[i].prueba_id.id == 1) {
                $scope.titleQuiz = $scope.preguntasList[i].prueba_id.titulo;
                $scope.descriptionQuiz = $scope.preguntasList[i].prueba_id.descripcion;
                $scope.urlAprobado = host + 'files/videos/gestion_personas/story.html';
                $scope.urlReprobado = host + 'files/videos/mapa_estrategico/story.html';
                $scope.pruebaID = 1;
                $scope.dataTest1.push({
                    id: $scope.preguntasList[i].id,
                    pregunta: $scope.preguntasList[i].pregunta,
                    prueba_id: $scope.preguntasList[i].prueba_id,
                    numero_pregunta: $scope.preguntasList[i].numero_pregunta,
                    respuesta: $scope.preguntasList[i].respuesta,
                    respuesta_id: $scope.preguntasList[i].respuesta_id,
                });

            } else if ($scope.preguntasList[i].prueba_id.id == 2) {
                $scope.titleQuiz = $scope.preguntasList[i].prueba_id.titulo;
                $scope.descriptionQuiz = $scope.preguntasList[i].prueba_id.descripcion;
                $scope.urlAprobado = host + 'files/videos/Examen';
                $scope.urlReprobado = host + 'files/videos/relaciones_laborales/story.html';
                $scope.pruebaID = 2;
                $scope.dataTest1.push({
                    id: $scope.preguntasList[i].id,
                    pregunta: $scope.preguntasList[i].pregunta,
                    prueba_id: $scope.preguntasList[i].prueba_id,
                    numero_pregunta: $scope.preguntasList[i].numero_pregunta,
                    respuesta: $scope.preguntasList[i].respuesta,
                    respuesta_id: $scope.preguntasList[i].respuesta_id,
                });

            } else if ($scope.preguntasList[i].prueba_id.id == 3) {
                $scope.titleQuiz = $scope.preguntasList[i].prueba_id.titulo;
                $scope.descriptionQuiz = $scope.preguntasList[i].prueba_id.descripcion;
                $scope.urlReprobado = host + 'files/videos/Examen';
                $scope.urlAprobado = host + 'files/videos/Completados';
                $scope.pruebaID = 3;
                $scope.dataTest1.push({
                    id: $scope.preguntasList[i].id,
                    pregunta: $scope.preguntasList[i].pregunta,
                    prueba_id: $scope.preguntasList[i].prueba_id,
                    numero_pregunta: $scope.preguntasList[i].numero_pregunta,
                    respuesta: $scope.preguntasList[i].respuesta,
                    respuesta_id: $scope.preguntasList[i].respuesta_id,
                });
            } else {
                Flash.create('danger', dataPreguntas.mensaje, 'customAlert');
            }
        }

        $scope.dataLength = dataPreguntas.length;

        if (dataPreguntas.length > 0) {
            $scope.preguntasRespuestas = $scope.dataTest1;
        } else {
            Flash.create('danger', dataPreguntas.mensaje, 'customAlert');
        }

    });

    $scope.enviaRespuestas = function(data) {
        var puntajeInc = 1;
        var puntajeApro = 1;

        for (var i in $scope.dataTest1) {
            if ($scope.dataTest1[i].respuesta == data[i]) {
                var totalBuenas = puntajeApro++;
            } else {
                $scope.formulario.porcentaje = 0;
                $scope.formulario.calificacion = 0;
                $scope.formulario.status = 2;
                $scope.formulario.urlVideo = $scope.urlReprobado;
                $scope.formulario.pruebaId = $scope.pruebaID;
                var totalMalas = puntajeInc++;
            }
        }
        if (totalMalas < $scope.dataLength && $scope.dataLength == $scope.dataTest1[i].prueba_id.numero_preguntas &&
            $scope.dataTest1[i].prueba_id.numero_preguntas < 12) {
            console.log('por aqui', totalMalas, totalBuenas, $scope.dataTest1[i].respuesta);
            $scope.formulario.messageTest = 'Vas bien, sin embargo tienes algunas respuestas incorrectas. Te recomendamos repasar las lecciones y volver a intentarlo';
        } else if (totalBuenas == $scope.dataTest1[i].prueba_id.numero_preguntas && $scope.dataLength == $scope.dataTest1[i].prueba_id.numero_preguntas) {

            if ($scope.pruebaID == 1) {
                $scope.formulario.messageTest = 'Muy bien, has contestado correctamente todas las preguntas! Puedes continuar el curso.';
            } else {
                $scope.formulario.messageTest = 'Muy bien, has contestado correctamente todas las preguntas! Puedes continuar con la evaluación final del curso. ¡Adelante!'
            }
            $scope.formulario.porcentaje = 100;
            $scope.formulario.calificacion = 7;
            $scope.formulario.status = 2;
            $scope.formulario.urlVideo = $scope.urlAprobado;
            $scope.formulario.pruebaId = $scope.pruebaID;
        } else if (totalBuenas > $scope.dataTest1[i].prueba_id.punt_min) {

            var suma = (totalBuenas + 1) / $scope.dataTest1.length;
            $scope.formulario.porcentaje = suma.toFixed(4) * 100;
            $scope.formulario.calificacion = totalBuenas + 1;
            $scope.formulario.status = 3;
            $scope.formulario.urlVideo = $scope.urlAprobado;
            $scope.formulario.pruebaId = $scope.pruebaID;
            $scope.formulario.messageTest = $scope.formulario.calificacion + ' de ' + $scope.dataTest1.length + ' respuestas correctas (' + $scope.formulario.porcentaje + '% de rendimiento). \
            <br> Has finalizado exitosamente el Programa de Inducción Corporativa CDF. \
            <br>Muchas gracias por tu compromiso!';

        } else if (totalBuenas < $scope.dataTest1[i].prueba_id.punt_min && $scope.dataLength == $scope.dataTest1[i].prueba_id.numero_preguntas) {

            var suma = (totalBuenas + 1) / $scope.dataTest1.length;
            $scope.formulario.porcentaje = suma.toFixed(4) * 100;
            $scope.formulario.calificacion = totalBuenas + 1;
            $scope.formulario.status = 2;
            $scope.formulario.urlVideo = $scope.urlReprobado;
            $scope.formulario.pruebaId = $scope.pruebaID;
            $scope.formulario.messageTest = $scope.formulario.calificacion + ' de ' + $scope.dataTest1.length + ' respuestas correctas (' + $scope.formulario.porcentaje + '% de rendimiento). \
            <br> Debes contestar nuevamente el cuestionario para finalizar exitosamente el Programa de Inducción Corporativa CDF.\
            <br> Muchas gracias por tu compromiso!';
        } else {
            $scope.formulario.messageTest = 'Vas mal,tienes todas las respuestas incorrectas. Te recomendamos repasar las lecciones y vuelve a intentarlo.';
        }
        preguntas.addCalificaciones({ Pregunta: $scope.formulario }).success(function(data) {
            console.log('data');
            if (data.status == 1) {
                Flash.create('success', data.mensaje, 'customAlert', duration = "5000");
            } else {
                $window.location = host + "videos/video";
            }
        });
    }
}]);