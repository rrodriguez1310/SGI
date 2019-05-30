<div ng-controller="PromocionesGraficos">
    <div class="col-md-12">
        <highchart id="evolucionSubscribers" config="evolucionSubscribers"></highchart>
    </div>
</div>


<?php 
    echo $this->Html->script(array(
        "highcharts-no-data-to-display",
        'angularjs/controladores/app',
        'angularjs/controladores/logProgramas/logProgramas.js',
    ));
?>