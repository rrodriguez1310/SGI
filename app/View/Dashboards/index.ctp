<style>
    
.cuerpo
{
    height: 450px;
}


</style>
<div class="cuerpo"></div>
<!--style type="text/css">${demo.css}</style>
<br/>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            spacingBottom: 30
        },
        title: {
            text: 'Abonados CDF Básicos'
        },
        subtitle: {
            text: false,
           // floating: true,
            align: 'right',
            verticalAlign: 'bottom',
            y: 15
        },
        xAxis: {
        	
            categories: [
	        	<?php
					foreach($meses as $mes)
					{
						echo "'".substr($mes["Month"]["nombre"], 0, 3)."'"   .',';
					}
	            ?>
            ]
        },
        yAxis: {
        	minRange: 100,
            title: {
                text: 'Cantidad de Abonados'
            },
            labels: {
                formatter: function () {
                   return Highcharts.numberFormat(this.value,0);
                }
            }
        },
        tooltip: {
        	/*
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.x + ': ' + this.y;
            }*/
        },
        plotOptions: {
            area: {
                fillOpacity: 0.5
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Real',
            data: [
            	<?php
					foreach($agnos as $agno)
					{
						if(isset($abonadosMesesBasicos[1][$agno["Year"]["id"]]))
						{
							foreach($meses as $mes)
							{
								if(isset($abonadosMesesBasicos[1][$agno["Year"]["id"]][$mes["Month"]["id"]]))
								{
									if(isset($mesesClonadosBasicos[1][$agno["Year"]["id"]][$mes["Month"]["id"]]))
									{
										echo array_sum($abonadosMesesBasicos[1][$agno["Year"]["id"]][$mes["Month"]["id"]]) + $mesesClonadosBasicos[1][$agno["Year"]["id"]][$mes["Month"]["id"]] .',';
									}
									else
									{
										echo array_sum($abonadosMesesBasicos[1][$agno["Year"]["id"]][$mes["Month"]["id"]]) .',';
									}
								}
							}
						}
							
					}
				?>
            ],
            color: '#90ED7D'
        }, {
            name: 'Presupuestado',
            data: [
            	<?php
					foreach($agnos as $agno)
					{
						if(isset($presupuestadosBasicos[$agno["Year"]["id"]]))
						{
							foreach($meses as $mes)
							{
								if(isset($presupuestadosBasicos[$agno["Year"]["id"]][$mes["Month"]["id"]]))
								{
									echo array_sum($presupuestadosBasicos[$agno["Year"]["id"]][$mes["Month"]["id"]]) .',';	
								}
							}
						}
							
					}
				?>
            ],
            color: '#434348'
        }]
    });
});
    
$(function () {
    $('#premium').highcharts({
        chart: {
            type: 'column',
            spacingBottom: 30
        },
        title: {
            text: 'Abonados CDF Premium'
        },
        subtitle: {
            text: false,
           // floating: true,
            align: 'right',
            verticalAlign: 'bottom',
            y: 15
        },
        xAxis: {
            categories: [
	        	<?php
					foreach($meses as $mes)
					{
						echo "'".substr($mes["Month"]["nombre"], 0, 3)."'"   .',';
					}
	            ?>
            ]
        },
        yAxis: {
            title: {
                text: 'Cantidad de Abonados'
            },
            labels: {
                formatter: function () {
                   return Highcharts.numberFormat(this.value,0);
                }
            }
        },
        tooltip: {
        	/*
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.x + ': ' + this.y;
            }*/
        },
        plotOptions: {
            area: {
                fillOpacity: 0.5
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Real',
            data: [
            	<?php
					foreach($agnos as $agno)
					{
						if(isset($abonadosMesesBasicos[2][$agno["Year"]["id"]]))
						{
							foreach($meses as $mes)
							{
								if(isset($abonadosMesesBasicos[2][$agno["Year"]["id"]][$mes["Month"]["id"]]))
								{
									if(isset($mesesClonadosBasicos[2][$agno["Year"]["id"]][$mes["Month"]["id"]]))
									{
										echo array_sum($abonadosMesesBasicos[2][$agno["Year"]["id"]][$mes["Month"]["id"]]) + $mesesClonadosBasicos[2][$agno["Year"]["id"]][$mes["Month"]["id"]] .',';
									}
									else
									{
										echo array_sum($abonadosMesesBasicos[2][$agno["Year"]["id"]][$mes["Month"]["id"]]) .',';
									}
								}
							}
						}
							
					}
				?>
            ],
            color : '#F7A35C'
        }, {
            name: 'Presupuestado',
            data: [
            	<?php
					foreach($agnos as $agno)
					{
						if(isset($presupuestadosPremium[$agno["Year"]["id"]]))
						{
							foreach($meses as $mes)
							{
								if(isset($presupuestadosPremium[$agno["Year"]["id"]][$mes["Month"]["id"]]))
								{
									echo array_sum($presupuestadosPremium[$agno["Year"]["id"]][$mes["Month"]["id"]]) .',';	
								}
							}
						}
					}
				?>
            ],
            color: '#434348'
        }]
    });
});
    
$(function () {
    $('#hd').highcharts({
        chart: {
            type: 'column',
            spacingBottom: 30
        },
        title: {
            text: 'Abonados CDF HD'
        },
        subtitle: {
            text: false,
           // floating: true,
            align: 'right',
            verticalAlign: 'bottom',
            y: 15
        },
        xAxis: {
            categories: [
	        	<?php
					foreach($meses as $mes)
					{
						echo "'".substr($mes["Month"]["nombre"], 0, 3)."'"   .',';
					}
	            ?>
            ]
        },
        yAxis: {
            title: {
                text: 'Cantidad de Abonados'
            },
            labels: {
                formatter: function () {
                  return Highcharts.numberFormat(this.value,0);
                }
            }
        },
        tooltip: {
        	/*
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.x + ': ' + this.y;
            }*/
        },
        plotOptions: {
            area: {
                fillOpacity: 0.5
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Real',
            data: [
            	<?php
					foreach($agnos as $agno)
					{
						if(isset($abonadosMesesBasicos[3][$agno["Year"]["id"]]))
						{
							foreach($meses as $mes)
							{
								if(isset($abonadosMesesBasicos[3][$agno["Year"]["id"]][$mes["Month"]["id"]]))
								{
									if(isset($mesesClonadosBasicos[3][$agno["Year"]["id"]][$mes["Month"]["id"]]))
									{
										echo array_sum($abonadosMesesBasicos[3][$agno["Year"]["id"]][$mes["Month"]["id"]]) + $mesesClonadosBasicos[3][$agno["Year"]["id"]][$mes["Month"]["id"]] .',';
									}
									else
									{
										echo array_sum($abonadosMesesBasicos[3][$agno["Year"]["id"]][$mes["Month"]["id"]]) .',';
									}
								}
							}
						}
							
					}
				?>
            ]
        }, {
            name: 'Presupuestado',
            data: [
            	<?php
					foreach($agnos as $agno)
					{
						if(isset($presupuestadosHd[$agno["Year"]["id"]]))
						{
							foreach($meses as $mes)
							{
								if(isset($presupuestadosHd[$agno["Year"]["id"]][$mes["Month"]["id"]]))
								{
									echo array_sum($presupuestadosHd[$agno["Year"]["id"]][$mes["Month"]["id"]]) .',';	
								}
							}
						}
							
					}
				?>
            ]
        }]
    });
});
</script>
<h3 class="text-center">Abonados año 2014<?php //echo $agno["Year"]["nombre"]; ?></h3>
<br/>
<div class="row">
  <div class="col-md-6">
  	<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  </div>
  <div class="col-md-6">
  	<div id="premium" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  </div>
  <div class="col-md-6">
  	<div id="hd" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  </div>
</div-->