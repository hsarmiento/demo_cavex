<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
require_once($aRoutes['paths']['config'].'bs_model.php');

$oModel = new BSModel();
$query_rms = "SELECT valor, fecha_hora from rms where radio_id = 5  order by fecha_hora asc limit 3000;";
echo $query_rms;
$aResult = $oModel->Select($query_rms);

// print_r($aResult);

$aRms = array();
// $aDatetime = array();
$aTime = array();
foreach ($aResult as $value) {
	$aRms[] = $value['valor']/1;
    // $aTime[] = "[".$value['valor']."]";
    echo strtotime($value['fecha_hora']);
    echo '<br>';
    echo date("Y", strtotime($value['fecha_hora']));
     echo '<br>';
     echo date("m", strtotime($value['fecha_hora']));
     echo '<br>';
     echo date("d", strtotime($value['fecha_hora']));
     echo '<br>';

    $aTime[] = "[".(mktime(date("H", strtotime($value['fecha_hora']))-4, date("i", strtotime($value['fecha_hora'])), date("s", strtotime($value['fecha_hora'])), date("m", strtotime($value['fecha_hora'])), date("d", strtotime($value['fecha_hora'])), date("Y", strtotime($value['fecha_hora'])))*1000).",".$value['valor']."]";
	// $aDatetime[] = date("Y", strtotime($value['fecha_hora']));
}
// echo mktime(10,10,10,10+1,10,2013);
// echo count($aTime);
// print_r($aRms);
// echo join($aTime, ",");

// print_r($aTime);
// print_r($aDatetime);
// echo mktime(0, 0, 0, 1, 22, 1985)*1000;

// $aData = "[Date.UTC(1970,  9, 27),0]";
// echo $aDatetime[0];
// var_dump($aDatetime);
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
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
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
                // data: [<?php echo join($aRms, ",");?>]
                data: [<?php echo join($aTime, ",");?>]
            	// pointStart: <?php echo $aDatetime[0];?>
                
            }]
        });
    });
    var seconds = new Date(2013, 10, 10, 10, 10, 10, 0).getTime() / 1000;
    console.log(seconds);
</script>