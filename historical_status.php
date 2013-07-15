<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
require_once($aRoutes['paths']['config'].'bs_model.php');

$oModel = new BSModel();
$query_rms = "SELECT valor, fecha_hora from rms where radio_id = 1 order by fecha_hora asc;";
$aResult = $oModel->Select($query_rms);

$aRms = array();
$aDatetime = array();
foreach ($aResult as $value) {
	$aRms[] = $value['valor']/1;
	$aDatetime[] = date("Y-m-d", strtotime($value['fecha_hora']));
}
echo $aDatetime[0];
var_dump($aDatetime);
// var_dump($aRms);
// echo join($aDatetime, ",");
// print_r($aRms);
// echo $aRms[0]['valor'];




?>

<div id="container"></div>


<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>/modules/exporting.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts-more.js"></script>



<script type="text/javascript">
	
	$(function () {
        $('#container').highcharts({
            title: {
                text: 'Monthly Average Temperature',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: WorldClimate.com',
                x: -20
            },
            xAxis: {
            	type: 'datetime',
            },
            yAxis: {
                title: {
                    text: 'Temperature (°C)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '°C'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Tokyo',
                data: [<?php echo join($aRms, ",");?>],
            	pointStart: <?php echo $aDatetime[0];?>
            }]
        });
    });
</script>