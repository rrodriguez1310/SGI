<?php 
	$nombreControllador = "";
	$nombreAccion = "";
	$tercerNivel = "";
	


	if($this->params->controller == "dimensiones")
	{
		$nombreControllador = "dimensiones";
	}

	if($this->params->controller == "dimensiones_areas")
	{
		$nombreControllador = "Dimensiones-Areas";
	}

	if($this->params->controller == "dimensiones_areas")
	{
		$nombreControllador = "Dimensiones-Areas";
	}

	if($this->params->controller == "companies")
	{
		$nombreControllador = "Empresas";
	}
	
	if($this->params->controller == "subscribers")
	{
		$nombreControllador = "Abonados";
	}
	
	if($this->params->controller == "users")
	{
		$nombreControllador = "Usuarios";
	}
    
    if($this->params->controller == "dashboards")
    {
        $nombreControllador = "Dashboard";
    }
	
	if($this->params->controller == "roles")
	{
		$nombreControllador = "Roles";
	}
	
	if($this->params->controller == "paginas")
	{
		$nombreControllador = "Páginas";
	}
	
	if($this->params->controller == "exportar")
	{
		$nombreControllador = "Exportar";
	}
	
	if($this->params->controller == "menus")
	{
		$nombreControllador = "Menús";
	}
	
	if($this->params->controller == "compras")
	{
		$nombreControllador = "Requerimientos de Compra";
	}

	if($this->params->controller == "trabajadores")
	{
		$nombreControllador = "Trabajadores";
	}

	if($this->params->controller == "areas")
	{
		$nombreControllador = "Áreas";
	}

	if($this->params->controller == "gerencias")
	{
		$nombreControllador = "Gerencias";
	}

	if($this->params->controller == "cargos")
	{
		$nombreControllador = "Cargos";
	}

	if($this->params->controller == "rating_programaciones" || $this->params->controller == "rating_minutos")
	{
		$nombreControllador = "Rating";
	}

	if($this->params->controller == "log_programas")
	{
		$nombreControllador = "Log";
	}
	if($this->params->controller == "lista_correos")
	{
		$nombreControllador = "Lista Correos";
	}
	if($this->params->controller == "lista_correos_tipos")
	{
		$nombreControllador = "Lista Correos Tipos";
	}
	if($this->params->controller == "evaluaciones_trabajadores")
	{
		$nombreControllador = "Evaluación de Desempeño";
	}
	if($this->params->controller == "evaluaciones_objetivos"){
		$nombreControllador = "Objetivos Clave de Desempeño";
	}
	if($this->params->controller == "compras_reportes"){
		$nombreControllador = "Reportes de Compras";	
	}
	if($this->params->controller == "fixture_partidos"){
		$nombreControllador = "Fixture Partidos";	
	}
	if( $this->params->controller == "produccion_partidos_transmisiones" || $this->params->controller =="produccion_partidos_chilefilms" || 
		$this->params->controller =="produccion_partidos_eventos" || $this->params->controller =="produccion_partidos" ){
		$nombreControllador = "Producción de Partidos";	
	}
	if( $this->params->controller == "catalogacion_r_tipos"){
		$nombreControllador = "Catalagación Tipo Requerimiento";
	}
	if( $this->params->controller == "produccion_partidos_optas"){
		$nombreControllador = "Partidos Opta";
	}
	if($this->params->controller == "produccion_contactos"){
		$nombreControllador = "Produccion Contactos";	
	}

	if($this->params->action =="listar_externos" || $this->params->action =="listar_responsables" || $this->params->action == "nombres_trabajadores"){
		$nombreAccion = "Lista";
	}

	if($this->params->action == "add_externos" || $this->params->action == "add_responsables_cdf")
	{
		$nombreAccion = "Registrar";
	}

	if($this->params->action == "add")
	{
		$nombreAccion = "Registrar";
	}
	
	if($this->params->action == "view")
	{
		$nombreAccion = "Detalle";
	}
	
	else if($this->params->action == "edit")
	{
		$nombreAccion = "Editar";
	}
	
	else if($this->params->action == "index")
	{
		$nombreAccion = "Lista";
	}
	
	else if($this->params->action == "genera_informe_abonado_pdf")
	{
		$nombreAccion = "Informe Abonados";
	}
	
	else if($this->params->action == "excel")
	{
		$nombreAccion = "Excel";
	}
	
	
	if($this->params->action == "index" && $this->params->controller == "dashboards")
    {
        //$nombreControllador = "Empresas";
        //$nombreAccion = "Abonados";
        $nombreAccion = "Graficos";
    }
	if($this->params->action == "bienvenida" && $this->params->controller == "dashboards")
    {
        $nombreAccion = "Bienvenida";
    }
	
	//Especiales//
	if($this->params->action == "index" && $this->params->controller == "subscribers")
	{
		$nombreControllador = "Empresas";
		$nombreAccion = "Abonados";
		$tercerNivel = "Lista";
	}

	if($this->params->action == "programa" && $this->params->controller == "rating_programaciones")
	{
		$nombreAccion = "Informe programas";
	}
	if($this->params->action == "diario" && $this->params->controller == "rating_programaciones")
	{
		$nombreAccion = "Informe diario";
	}
	if($this->params->action == "upload" && $this->params->controller == "rating_programaciones")
	{
		$nombreAccion = "Subir Programación";
	}
	if($this->params->action == "upload" && $this->params->controller == "rating_minutos")
	{
		$nombreAccion = "Subir Minutos";
	}
	if($this->params->action == "programa_minutos")
	{
		$nombreAccion = "Minuto a minuto";
	}
	if($this->params->action == "todos_sap")
	{
		$nombreAccion = "Buscar";
	}
	if($this->params->action == "trabajadores")
	{
		$nombreAccion = "Trabajadores";
	}

	if($this->params->action == "listar_contratos_empresas")
	{
		$nombreAccion = "Lista de contratos";
	}

	if($this->params->action == "contratos_add")
	{
		$nombreAccion = "Ingreso de contratos";
	}
	if($this->params->action == "calibrar")
	{
		$nombreAccion = "Calibrar";
	}
	if($this->params->action == "evaluar")
	{
		$nombreAccion = "Evaluar";
	}
	if($this->params->action == "calibrar_edit")
	{
		$nombreAccion = "Calibrar";
	}
	if($this->params->action == "desempeno" || $this->params->action == "confirmar")
	{
		$nombreAccion = "Mi desempeño";
	}
	if($this->params->action == "evaluaciones_actuales" || $this->params->action == "objetivos_consolidado"){
		$nombreAccion = "Consolidado";
	}	
	if($this->params->action == "evaluaciones_graficos"){
		$nombreAccion = "Gráficos";	
	}
	if($this->params->action == "index" && $this->params->controller == "evaluaciones_trabajadores"){
		$nombreAccion = "Bienvenida";
	}
	if($this->params->action == "presupuesto"){
		$nombreAccion = "Presupuestos";	
	}
	if($this->params->action == "presupuesto_general"){
		$nombreAccion = "Presupuesto General";	
	}
	if($this->params->controller == "videos")
	{
		$nombreControllador = "Videos";
	}
	if($this->params->controller == "calificaciones")
	{
		$nombreControllador = "Calificaciones";
	}
	if($this->params->controller == "respuestas")
	{
		$nombreControllador = "Respuestas";
	}
	if($this->params->controller == "archivos")
	{
		$nombreControllador = "Archivos";
	}
	if($this->params->controller == "pruebas")
	{
		$nombreControllador = "Pruebas";
	}
	if($this->params->controller == "preguntas")
	{
		$nombreControllador = "Preguntas";
	}
	if($this->params->controller == "sistemas_incidencias")
	{
		$nombreControllador = "Sistema Incidencias";
	}
	if($this->params->action == "induccion" && $this->params->controller == "videos")
    {
        $nombreAccion = "Inducción";
    }
	if($this->params->action == "video" && $this->params->controller == "videos")
    {
        $nombreAccion = "Lecciones";
    }
	
?>

<div class="row clearfix">
	<div class="col-md-12 column" id="miga">
		<ul class="breadcrumb">
			<li class="active"><a href="<?php echo $this->Html->url(array("controller"=>"dashboards", "action"=>"index"))?>">Inicio</a><span class="divider"></span>
			</li>
			<?php if($this->params->controller != "dashboards") : ?>
			<li class="active">
				<?php echo $nombreControllador ?>
					<span class="divider"> </span>
			</li>
			<?php endif; ?>
			<li class="active">
				<?php echo $tercerNivel  . ' ' .$nombreAccion; ?>
			</li>
		</ul>
	</div>
</div>
