app.controller('VideosPath', ['$scope', '$http', '$timeout', 'Videos', 'Upload', 'Flash', 'uiGridConstants', '$filter', '$window', '$location', function($scope, $http, $timeout, Videos, Upload, Flash, uiGridConstants, $filter, $window, $location) {


    $scope.path = null;
    Videos.videosPath().success(function(path) {

        var pathVideo = [
            host + 'files/videos/bienvenida/story.html',
            host + 'files/videos/historia/story.html',
            host + 'files/videos/negocio_clientes/story.html',
            host + 'files/videos/realizacion_servicio/story.html',
            host + 'files/videos/mapa_estrategico/story.html',
            host + 'files/videos/gestion_personas/story.html',
            host + 'files/videos/relaciones_laborales/story.html'
        ];

        $scope.ultimo = host + 'files/videos/Examen';

        if (angular.isUndefined(path)) {
            $window.location = host + "videos/video";
        }
        $scope.pathEstado = path.Calificacione.estado;
        $scope.pathValidate = false;

        $scope.pathBienvenida = pathVideo[0];
        $scope.path2 = pathVideo;
        var url1 = $scope.pathBienvenida.split("/");

        var url2 = path.Calificacione.video.split("/");
        var i = 0;
        //console.log(url1, url2);

        if (url1[5] != url2[5] && url2[5] == 'relaciones_laborales') {
            $scope.path = path.Calificacione.video;
            $scope.title = 'Lección 7: Compensaciones, Beneficios y Plan de Seguridad CDF';
            $scope.textButton = 'Realizar Quiz 2';
            var i = 6;

        } else if (url2[5] == 'bienvenida') {
            $scope.path = path.Calificacione.video;
            $scope.title = 'Saludo de Bienvenida';
            var i = 0;
            $scope.previ = i;
        } else if (url2[5] == 'historia') {
            $scope.path = path.Calificacione.video;
            $scope.title = 'Lección 1: La Historia de CDF';
            var i = 1;

        } else if (url2[5] == 'negocio_clientes') {
            $scope.path = path.Calificacione.video;
            $scope.title = 'Lección 2: El Negocio y sus Clientes';
            var i = 2;

        } else if (url2[5] == 'mapa_estrategico') {
            $scope.path = path.Calificacione.video;
            $scope.title = 'Lección 4: Valores y Mapa Estratégico';
            var i = 4;
            $scope.textButton = 'Realizar Quiz 1';

        } else if (url2[5] == 'gestion_personas') {
            $scope.path = path.Calificacione.video;
            $scope.title = 'Lección 6: La Gestión de Personas en CDF';
            var i = 5;

        } else if (url2[5] == 'realizacion_servicio') {
            $scope.path = path.Calificacione.video;
            $scope.title = 'Lección 3: La Realización del Servicio';
            var i = 3;

        } else if (url2[5] == 'relaciones_laborales' && path.Calificacione.porcentaje == 0) {
            $scope.path = path.Calificacione.video;
            $scope.title = 'Lección 7: Compensaciones, Beneficios y Plan de Seguridad CDF';
            $scope.textButton = 'Realizar Quiz 2';

        } else {
            $scope.validate = true;
            i = 7;
        }

        $scope.abrirTest = function() {

            var landingUrl = host + "preguntas";
            $window.location.href = landingUrl;

        };

        $scope.previousVideo = function() {
            $scope.first = i;
            i--;
            $scope.posicion = i;
            $scope.pathValidate = true;
            $scope.path = $scope.path2[i];
            $scope.title = 'Video N° ' + i;
            $scope.textButton = null;

            if ($scope.posicion == 0) {
                $scope.title = 'Saludo de Bienvenida';
            }
            if ($scope.posicion == 1) {
                $scope.title = 'Lección 1: La Historia de CDF';
            }
            if ($scope.posicion == 2) {
                $scope.title = 'Lección 2: El Negocio y sus Clientes';
            }
            if ($scope.posicion == 3) {
                $scope.title = 'Lección 3: La Realización del Servicio';
            }
            if ($scope.posicion == 4) {
                $scope.title = 'Lección 4: Valores y Mapa Estratégico';
            }
            if ($scope.posicion == 5) {
                $scope.title = 'Lección 6: La Gestión de Personas en CDF';
            }
            if ($scope.posicion == 6) {
                $scope.title = 'Lección 7: Compensaciones, Beneficios y Plan de Seguridad CDF';
            }
        };

        $scope.nextVideo2 = function() {
            $scope.first = i;
            i++;
            $scope.posicion = i;
            $scope.last = path.Calificacione.video;

            $scope.textButton = null;


            if ($scope.last == pathVideo[6] && $scope.path == pathVideo[5] || $scope.last == $scope.ultimo) {
                $scope.pathValidate = false;
                $scope.textButton = 'Realizar Quiz 2';
            }
            if ($scope.path == pathVideo[3] && $scope.last == pathVideo[6]) {
                $scope.pathValidate = true;
            }
            if ($scope.path == pathVideo[3] && $scope.last == pathVideo[3] || $scope.last == pathVideo[2] ||
                $scope.last == pathVideo[1] || $scope.last == pathVideo[0] || $scope.last == pathVideo[4]) {
                $scope.pathValidate = false;
                $scope.textButton = 'Realizar Quiz 1';

            }
            if ($scope.path == pathVideo[0] || $scope.path == pathVideo[1] || $scope.path == pathVideo[2] || $scope.path == pathVideo[3] &&
                $scope.last == pathVideo[6] || $scope.last == $scope.ultimo) {
                $scope.pathValidate = true;
                $scope.textButton = null;
            }
            if ($scope.last == pathVideo[5] && $scope.path == pathVideo[4]) {
                $scope.pathValidate = false;
            }
            if ($scope.last == pathVideo[5] && $scope.path == pathVideo[5]) {
                $scope.pathValidate = false;
            }
            if ($scope.path == pathVideo[5] && $scope.last == $scope.ultimo) {
                $scope.pathValidate = true;
                $scope.textButton = 'Evaluación Final';
            }

            $scope.path = $scope.path2[i];
            $scope.title = 'Video N° ' + i;
            if ($scope.posicion == 0) {
                $scope.title = 'Saludo de Bienvenida';
            }
            if ($scope.posicion == 1) {
                $scope.title = 'Lección 1: La Historia de CDF';
            }
            if ($scope.posicion == 2) {
                $scope.title = 'Lección 2: El Negocio y sus Clientes';
            }
            if ($scope.posicion == 3) {
                $scope.title = 'Lección 3: La Realización del Servicio';
            }
            if ($scope.posicion == 4) {
                $scope.title = 'Lección 4: Valores y Mapa Estratégico';
            }
            if ($scope.posicion == 5) {
                $scope.title = 'Lección 6: La Gestión de Personas en CDF';
            }
            if ($scope.posicion == 6) {
                $scope.title = 'Lección 7: Compensaciones, Beneficios y Plan de Seguridad CDF';
            }

        };
        $scope.repetir = function() {

            $scope.path = $scope.path2[0];
            $scope.validate = false;
            i = 0;
            $scope.title = ' Saludo de Bienvenida';
            $scope.pathValidate = true;
        }

        $scope.nextVideo = function() {

            $scope.formulario2 = {
                video: $scope.path
            };
            $scope.first = i;
            i++;
            $scope.path = $scope.path2[i];
            $scope.title = 'Video N° ' + i;
            $scope.posicion = i;

            if ($scope.posicion == 0) {
                $scope.title = 'Saludo de Bienvenida';
            }
            if ($scope.posicion == 1) {
                $scope.title = 'Lección 1: La Historia de CDF';
            }
            if ($scope.posicion == 2) {
                $scope.title = 'Lección 2: El Negocio y sus Clientes';
            }
            if ($scope.posicion == 3) {
                $scope.title = 'Lección 3: La Realización del Servicio';
            }
            if ($scope.posicion == 4) {
                $scope.title = 'Lección 4: Valores y Mapa Estratégico';
            }
            if ($scope.posicion == 5) {
                $scope.title = 'Lección 6: La Gestión de Personas en CDF';
            }
            if ($scope.posicion == 6) {
                $scope.title = 'Lección 7: Compensaciones, Beneficios y Plan de Seguridad CDF';
            }

            if ($scope.posicion == 4) {
                $scope.textButton = 'Realizar Quiz 1';
            } else if ($scope.posicion == 6) {
                $scope.textButton = 'Realizar Quiz 2';
            } else {
                $scope.textButton = null;
            }

            Videos.addVideos({ Video: $scope.path }).success(function(data) {
                if (data.estado == 0) {
                    $scope.path3 = data.data2;
                    //$window.location = host + "videos/video";
                } else {

                }
            });
        };

    })
}])