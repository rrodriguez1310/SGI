<style>input {margin-top: 0px;}</style>
<div ng-controller="ListaAprobadores">
  <p ng-bind-html="cargador" ng-show="loader"></p>
  <div ng-show="tablaDetalle" class="col-md-7">
    <?php echo $this->element('botonera'); ?>
    <div>
      <br>  
      <div ui-grid="gridOptions" ui-grid-selection class="grid"></div>
    </div>
  </div>
  <div class="col-md-5" ng-show="formulario">
    <h3>{{tituloBoton}}</h3>
    <form name="userForm" ng-submit="submitForm()" method="post">
      <div class="form-group">
        <input type="hidden" class="form-control" id="exampleInputEmail1" ng-model="form.id" required>
        <label for="exampleInputEmail1">Año</label>
        <ui-select class="abajo" ng-model="selectAgno.selectedOption" name="AnioPresupuesto" id="exampleInputEmail1" ng-change="agnoSeleccionado()" required>
          <ui-select-match placeholder=" Buscar año">
              <span>{{$select.selected.nombre}}</span>
          </ui-select-match>
          <ui-select-choices repeat="option in selectAgno.availableOptions | filter: $select.search">
            <div ng-bind-html="option.nombre | highlight: $select.search"></div>
          </ui-select-choices>
        </ui-select>
      </div>
      <!--div class="form-group">
        <input type="hidden" class="form-control" id="exampleInputEmail1" ng-model="form.id" required>
        <label for="exampleInputEmail1">Año</label>
        <select class="form-control" name="mySelect" id="mySelect" 
          ng-options="option.nombre for option in selectAgno.availableOptions track by option.id " 
          ng-model="selectAgno.selectedOption" required 
          ng-change="agnoSeleccionado()"> 
        </select>
      </div-->  

      <div class="form-group">
        <label for="exampleInputEmail2">Código presupuestario</label>
        <ui-select class="abajo" ng-model="selectCodigoPresupuesto.selectedOption" name="AnioPresupuesto" id="exampleInputEmail1" required>
          <ui-select-match placeholder=" Buscar código ">
              <span>{{$select.selected.nombre}}</span>
          </ui-select-match>
          <ui-select-choices repeat="option in selectCodigoPresupuesto.availableOptions | filter: $select.search">
            <div ng-bind-html="option.nombre | highlight: $select.search"></div>
          </ui-select-choices>
        </ui-select>
      </div>      
      <!--div class="form-group">
        <label for="exampleInputPassword1">Codigo presupuestario</label>
        <select class="form-control" name="mySelect" id="mySelectCodigo" ng-options="option.nombre for option in selectCodigoPresupuesto.availableOptions track by option.id" ng-model="selectCodigoPresupuesto.selectedOption" required> </select>
      </div-->
      <button type="submit" class="{{clase}}">{{tituloBoton}}</button>
    </form>
  </div>
</div>
<?php 
  echo $this->Html->script(array(
    'angularjs/controladores/app',
    'angularjs/servicios/compras/compras',
    'angularjs/servicios/years/years',
    'angularjs/servicios/codigos_presupuestos/codigos_presupuestos',
    'angularjs/controladores/compras/editar_codigo_presupuestario',
    'angularjs/directivas/confirmacion',
  ));
?>