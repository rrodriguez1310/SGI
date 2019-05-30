<style>
.container{width: 97%;}
.select2-container .select2-choice > .select2-chosen{margin-right: 14px !important;}
</style>
<div class="col-xs-12 col-sm-12 col-md-12 hide" id="vista">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Registrar Partidos</h3>
        </div>
        <div class="panel-body" id="menu">
            <?php echo $this->Form->create('FixturePartido', array('class' => 'form-horizontal')); ?>
            <div id="fixture">
                <div class="table-responsive partidos">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Campeonato</th>
                                <th>Categoría</th>
                                <th>Subcategoría</th>
                                <th>Día Partido</th>
                                <th>Hora</th>
                                <th>Estadio</th>
                                <th>Local</th>
                                <th>Visita</th>
                                <th>TV</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style='width:200px'><?php echo $this->Form->input('FixturePartido.0.campeonato_id', array("type"=>"select", "class"=>"form-control requerido campeonatoFase", "empty"=>"","id"=> "Torneo-0", "label"=>false, 'style'=>'width:230px'));?></td>
                                <td style='width:150px'><?php echo $this->Form->input('FixturePartido.0.campeonatos_categoria_id',  array("type"=>"select", "class"=>"form-control requerido faseFecha", "id"=> "FaseTorneo-0", "label"=>false, 'style'=>'width:160px'));?></td> 
                                <td style='width:100px'><?php echo $this->Form->input('FixturePartido.0.campeonatos_subcategoria_id', array("type"=>"select", "class"=>"form-control", "id"=> "FechaTorneo-0", "label"=>false, 'style'=>'width:160px'));?></td>
                                <td style='width:90px'> <?php echo $this->Form->input('FixturePartido.0.fecha_partido', array("type"=> 'text' , "class"=>"form-control requerido readonly-pointer-background sube", "label"=>false, "id"=> "Fecha-0", 'style'=>'width:100px'));?></td>
                                <td style='width:50px'> <?php echo $this->Form->input('FixturePartido.0.hora_partido',  array("type"=> 'text' , "class"=>"form-control requerido sube", "label"=>false, "id"=> "Hora-0", 'style'=>'width:65px'));?></td>
                                <td style='width:210px'><?php echo $this->Form->input('FixturePartido.0.estadio_id', array("type"=>"select", "class"=>"form-control requerido estadiosRelacion", "label"=>false, "id"=> "Estadio-0", 'style'=>'width:220px'));?></td>
                                <td style='width:200px'><?php echo $this->Form->input('FixturePartido.0.local_equipo_id', array("type"=>"select", "class"=>"form-control requerido", "options"=> $equipos, "id"=> "Local-0", "label"=>false, 'style'=>'width:220px'));?></td>
                                <td style='width:200px'><?php echo $this->Form->input('FixturePartido.0.visita_equipo_id', array("type"=>"select", "class"=>"form-control requerido", "options"=> $equipos, "id"=> "Visita-0", "label"=>false, 'style'=>'width:220px'));?></td>
                                <td><?php echo $this->Form->input('FixturePartido.0.transmite_cdf', array("type"=>"select", "class"=>"form-control requerido", "options"=> array("-","CDF"), "id"=> "Transmision-0", "label"=>false, 'style'=>'width:81px'));?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-right botones">                
                <button type="button" class="btn btn-warning nuevoPartido sube"><i class="fa fa-plus"></i> Partido</button>
            </div>
            <div class="text-center">
                <button type="submit" id="submit" class="btn btn-primary btn-lg btn-disabled-on-click"><i class="fa fa-pencil"></i> Guardar</button>
                <button type="submit" id="safe" class="hide">enviar</button>
            </div>
            <br>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<?php 
echo $this->Html->css('bootstrap-clockpicker.min');
echo $this->Html->script(array( 
  'bootstrap-datepicker',
  'bootstrap-clockpicker.min'
  ));
?>
<script>

$(function() {  

    $("#Torneo-0, #FaseTorneo-0, #FechaTorneo-0, #Estadio-0, #Local-0, #Visita-0, #Transmision-0").select2();
    $("#Torneo-0, #FaseTorneo-0, #FechaTorneo-0, #Estadio-0, #Local-0, #Visita-0, #Transmision-0").select2('data', null);  
    $("#vista").removeClass("hide");
    $("#Fecha-0").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        weekStart:1,
        orientation: "top auto"
    });
    $('#Hora-0').clockpicker({
        placement:'bottom',
        align: 'top',
        autoclose:true
    });

    var path = (window.location.href).split("fixture_partidos");
    var host = path[0];
    
    $(".campeonatoFase").live("change", function() {
        var idArr = $(this).attr("id").split("-");
        var nid = idArr.slice(-1)[0];
        $("#FechaTorneo-"+nid).select2('data', null).find("option").remove();
        $("#FaseTorneo-"+nid).select2('data', null).find("option").remove();

        var idCampeonato = $(this).val();
        if(idCampeonato){
            $.getJSON(host+"fixture_partidos/listaCategorias", {id: idCampeonato}).done(function(data) {
                if(data.categorias){
                    $('#FaseTorneo-'+nid).append('<option value=""></option>');
                    $.each( data.categorias, function( index, value ){                         
                        $('#FaseTorneo-'+nid).append('<option value="'+index+'">'+value+'</option>') 
                    });
                }
            }).fail(function( jqxhr, textStatus, error ) {
                console.log(textStatus + ", " + error);
                alert( "Error, intentelo nuevamente." );
            });
        }
    });
    
    var estadiosRelacionJson = $.parseJSON('<?php echo $estadiosRelacion; ?>');    
    $(".estadiosRelacion").live("change", function(){

        var estadioId = $(this).val();
        var idArr = $(this).attr("id").split("-");
        var nid = idArr.slice(-1)[0];

        $.each(estadiosRelacionJson, function(key,estadio){
          if(estadio.id == estadioId) $("#Local-"+nid).select2("val", estadio.localia_equipo_id);
       });

    });

    $(".faseFecha").live("change", function() {
        var idArr = $(this).attr("id").split("-");
        var nid = idArr.slice(-1)[0];
        $("#FechaTorneo-"+nid).select2('data', null).find("option").remove();

        var idCampeonato = $("#Torneo-"+nid).val();
        var ids = $(this).val().split("*");

        if(ids){        
            $.getJSON(host+"fixture_partidos/listaSubCategorias", {idDependencia: ids[1], idCampeonato:idCampeonato}).done(function(data) {
                if(data.subCategorias){
                    $.each( data.subCategorias, function( index, value ){
                        $('#FechaTorneo-'+nid).append('<option value="'+index+'">'+value+'</option>') 
                    });
                }
            }).fail(function( jqxhr, textStatus, error ) {
                console.log(textStatus + ", " + error);
                alert( "Error, intentelo nuevamente." );
            });
        }
    });

    var next_id = 0;
    $('.nuevoPartido').click(function(){

        if (hayDuplicados(obtienePartidos())) {
            alert("Error: No puede ingresar partidos repetidos al Fixture.");
        }

        next_id = next_id+1;
        var clone_tr = $('div.table-responsive table tbody tr:last').clone();

        clone_tr.find('input').val('');
        clone_tr.find('#Fecha-'+eval(next_id-1)).attr({'name':'data[FixturePartido][' + next_id + '][fecha_partido]', 'id':'Fecha-'+next_id});
        clone_tr.find('#Hora-'+eval(next_id-1)).attr({'name':'data[FixturePartido][' + next_id + '][hora_partido]', 'id':'Hora-' + next_id});
        clone_tr.find('select:eq(0)').attr({'name':'data[FixturePartido][' + next_id + '][campeonato_id]', 'id':'Torneo-' + next_id});
        clone_tr.find('select:eq(1)').attr({'name':'data[FixturePartido][' + next_id + '][campeonatos_categoria_id]', 'id':'FaseTorneo-' + next_id});
        clone_tr.find('select:eq(2)').attr({'name':'data[FixturePartido][' + next_id + '][campeonatos_subcategoria_id]', 'id':'FechaTorneo-' + next_id});
        clone_tr.find('select:eq(3)').attr({'name':'data[FixturePartido][' + next_id + '][estadio_id]', 'id':'Estadio-' + next_id});
        clone_tr.find('select:eq(4)').attr({'name':'data[FixturePartido][' + next_id + '][local_equipo_id]', 'id':'Local-' + next_id});
        clone_tr.find('select:eq(5)').attr({'name':'data[FixturePartido][' + next_id + '][visita_equipo_id]', 'id':'Visita-' + next_id}); 
        clone_tr.find('select:eq(6)').attr({'name':'data[FixturePartido][' + next_id + '][transmite_cdf]', 'id':'Transmision-' + next_id});
        clone_tr.find("#Torneo-"+next_id).val($('#Torneo-'+eval(next_id-1)).val());
        clone_tr.find("#FaseTorneo-"+next_id).val($('#FaseTorneo-'+eval(next_id-1)).val());
        clone_tr.find("#FechaTorneo-"+next_id).val($('#FechaTorneo-'+eval(next_id-1)).val());
        clone_tr.find('div.input.select>div').remove();                                 // campos duplicados select2      

        $('div.partidos table tbody').append(clone_tr);       
        
        $("#Torneo-"+next_id+", #FaseTorneo-"+next_id+", #FechaTorneo-"+next_id+", #Estadio-"+next_id+", #Local-"+next_id+", #Visita-"+next_id+", #Transmision-"+next_id).select2();
        $("#Estadio-"+next_id+", #Local-"+next_id+", #Visita-"+next_id+", #Transmision-"+next_id).select2('data', null);

        $("#Fecha-"+next_id).datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            multidate: false,
            autoclose: true,
            required: true,
            weekStart:1,
            orientation: "top auto"
        });
        $("#Hora-"+next_id).clockpicker({
            placement:'bottom',
            align: 'top',
            autoclose:true
        });
        return false;
    });  

    var obtienePartidos = function (){
        var partidosSerie = decodeURIComponent($("#FixturePartidoAddFixturesForm").serialize());
        var partidosArr = partidosSerie.split("&");
        var partidos = {};
        partidosArr.forEach(function(item, index){
            let arrProp = (item.split('=')[0].substring(20)).split("][");
            if (arrProp.length>1) {
                let id = arrProp[0].substring(1);
                let prop = arrProp[1].slice(0, -1);
                if (typeof partidos[id] == 'undefined') 
                    partidos[id] = {};
                
                partidos[id][prop] = item.split('=')[1];
            }
        });
        //toArray
        partidos = $.map(partidos, function(value, index) {
            if (typeof value.fecha_partido !== 'undefined' && typeof value.hora_partido !== 'undefined' && typeof value.estadio_id !== 'undefined' && typeof value.local_equipo_id !== 'undefined' && typeof value.visita_equipo_id !== 'undefined')
                return [value];
        });

        return partidos;
    };
    
    var hayDuplicados = function(array) {
        return array.map(function(value) {
            return value.fecha_partido + value.hora_partido + value.estadio_id + value.local_equipo_id + value.visita_equipo_id;
        }).some(function(value, index, array) { 
            return array.indexOf(value) !== array.lastIndexOf(value);  
        })
    }

    $("#submit").on("click",function(e){        
        if (hayDuplicados(obtienePartidos())) {
            alert("Error: No puede ingresar partidos repetidos al Fixture.");
            e.preventDefault();
        }else {            
            $(this).prop("disabled",true);
            $("#safe").click();
        }
    });

});
jQuery.fn.extend({
    live: function (event, callback) {
       if (this.selector) {
            jQuery(document).on(event, this.selector, callback);
        }
    }
});
jQuery.extend({
      getValues: function(url, vars) {
         var result = null;
         $.ajax({
            data: vars,
            url: url,
            type: 'get',
            async: false,
            success: function(data) {
               result = data;
            }
         });
         return result;
       }
   });

</script>