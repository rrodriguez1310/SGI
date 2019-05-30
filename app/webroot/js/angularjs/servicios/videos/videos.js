app.service('Videos', ['$http', 'Upload', function($http, Upload) {



    this.videosPath = function() {
        var data = $http({
            method: 'GET',
            url: host + 'videos/videoRest'
        });
        return data;
    };
    this.addVideos = function(formulario) {
        var data = $http({
            method: 'POST',
            url: host + 'videos/video_add',
            data: $.param(formulario)
        });
        return data;
    };
    this.upload_file = function(archivo) {
        var data = Upload.upload({
            method: 'POST',
            url: host + 'videos/upload_file',
            file: archivo
        });
        return data;
    };
    /* this.uploadFotoTrabajador = function(idTrabajadore, archivo) {
         var data = Upload.upload({
             url: host + 'trabajadores/upload_foto_trabajador',
             fields: { id: idTrabajadore },
             file: archivo
         });
         return data;
     };*/
}]);