<?php 
  pr($logPrograma)

?>
<!--?php echo $this->Html->script(array('angularjs/controladores/lista_log'));?>
<div ng-controller="listaLog">
  <?php echo $this->element("exportar_csv"); ?>
  <table ng-table="tableParams" show-filter="true" class="table table-hover table-condensed table-bordered" export-csv="csv">
      <tr ng-repeat="log in $data | orderBy:'fecha'" >
          <td data-title="'Señal'" sortable="'segnal'" filter="{ 'segnal': 'text' }">{{log.segnal}}</td>
          <td data-title="'Fecha'" sortable="'fecha'" filter="{ 'fecha': 'text' }">{{log.fecha}}</td>
          <td data-title="'Hora inicio'" sortable="'hora_inicio'" filter="{ 'hora_inicio': 'text' }">{{log.hora_inicio}}</td>
          <td data-title="'duracion'" sortable="'duracion'" filter="{ 'duracion': 'text' }">{{log.duracion}}</td>
          <td data-title="'Programa'" sortable="'programa'" filter="{ 'programa': 'text' }">{{log.programa}}</td>
         
          <td data-title="'Estado'" sortable="'estado_programa'" filter="{ 'estado_programa': 'text' }">
            <span class="label label-success" ng-show="log.estado_programa === 'OK'">{{log.estado_programa}}</span>
            <span class="label label-danger" ng-show="log.estado_programa === 'ERROR'">{{log.estado_programa}}</span>
          </td>
      </tr>
  </table>
</div-->