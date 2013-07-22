<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
	require_once($aRoutes['paths']['config'].'bs_model.php');
	$oModel = new BSModel();
	$query_radios = "SELECT id from radios where estado = 1 order by id asc;";
	$aRadios = $oModel->Select($query_radios);
	$aRms = array();
	$aParametros = array();
	foreach ($aRadios as $radios) {
		$query_rms = "SELECT valor from rms where radio_id = ".$radios['id']." order by id asc;";
		$rms = $oModel->Select($query_rms);
		$aRms[] = array('radio_id' => $radios['id'],
						'valor' => $rms[0]['valor']
					);
		$query_parametros = "SELECT * from parametros where radio_id = ".$radios['id'].";";
		$par = $oModel->Select($query_parametros);
		$aParametros[] = array('rms_max_normal' => $par[0]['rms_normal'],
							   'rms_semi_ropping' => ($par[0]['rms_normal'])*(1+$par[0]['rms_max_normal_porcentaje']/100),
							   'rms_ropping' => ($par[0]['rms_normal'])*(1+$par[0]['rms_ropping_porcentaje']/100)
							);
	}
	$count_radios = count($aRms);
	$query_limite_gauge = "SELECT * from grafico_rms order by id desc limit 1;";
	$aLimiteGauge = $oModel->Select($query_limite_gauge);
	$gauge_minimo = $aLimiteGauge[0]['valor_minimo'];
	$gauge_maximo = $aLimiteGauge[0]['valor_maximo'];
?>

<div class="container container-body contenedor">
	<h2>Overview</h2>
	<div class="hidrociclon"><img height="400" width="400" src="assets/img/Overview_2.png"></div>

	<div id="gauge1" class="gauge"></div>
	<div id="msg1" class="overview-msg calibrate">Calibrando</div>
    <div id="link-status1" class="link-status">
    	<a href="status.php?radio_id=<?=$aRms[0]['radio_id']?>&n_radio=1">Show live status</a></div>
    </div>
	<div id="gauge2" class="gauge"></div>
	<div id="msg2" class="overview-msg calibrate">Calibrando</div>
	<div id="link-status2" class="link-status">
    	<a href="status.php?radio_id=<?=$aRms[1]['radio_id']?>&n_radio=2">Show live status</a></div>
    </div>
	<div id="gauge3" class="gauge"></div>
	<div id="link-status3" class="link-status">
    	<a href="status.php?radio_id=<?=$aRms[2]['radio_id']?>&n_radio=3">Show live status</a></div>
    </div>
	<div id="gauge4" class="gauge"></div>
	<div id="link-status4" class="link-status">
    	<a href="status.php?radio_id=<?=$aRms[3]['radio_id']?>&n_radio=4">Show live status</a></div>
    </div>
	<div id="gauge5" class="gauge"></div>
	<div id="link-status5" class="link-status">
    	<a href="status.php?radio_id=<?=$aRms[4]['radio_id']?>&n_radio=5">Show live status</a></div>
    </div>
	<div id="gauge6" class="gauge"></div>
	<div id="link-status6" class="link-status">
    	<a href="status.php?radio_id=<?=$aRms[5]['radio_id']?>&n_radio=6">Show live status</a></div>
    </div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>

<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>/modules/exporting.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts-more.js"></script>

<script type="text/javascript">
	<?php if($count_radios > 0){?>
		
		$(function () {
			  $('#link-status1').show();
		      $('#gauge1').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: 'Radio 1'
		        },
		        
		        pane: {
		            startAngle: -150,
		            endAngle: 150,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		        	min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            // min: <?=$gauge_minimo?>,
		            // max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[0]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[0]['rms_semi_ropping']?>,
		                to: <?=$aParametros[0]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[0]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[0]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }
		              if(y_data < <?=$aParametros[0]['rms_semi_ropping']?>){
		              	if($("#msg1").attr('class') == 'overview-msg calibrate'  || $("#msg1").attr('class') == 'overview-msg alert-warning' || $("#msg1").attr('class') == 'overview-msg alert-error'){
	              			$("#msg1").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").addClass("alert-success");	
	              			$('#msg1').fadeOut(100);
              				$('#msg1').text("Ideal").fadeIn(1000);
              			}
		              }else if(y_data > <?=$aParametros[0]['rms_semi_ropping']?> && y_data < <?=$aParametros[0]['rms_ropping']?>){
	              		if($("#msg1").attr('class') == 'overview-msg calibrate'  || $("#msg1").attr('class') == 'overview-msg alert-error' || $("#msg1").attr('class') == 'overview-msg alert-success'){
	              			$("#msg1").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").addClass("alert-warning");	
	              			$('#msg1').fadeOut(100);
              				$('#msg1').text("Semiropping").fadeIn(1000);
              			}     		
		              }else if(y_data > <?=$aParametros[0]['rms_ropping']?>){
	              		if($("#msg1").attr('class') == 'overview-msg calibrate'  || $("#msg1").attr('class') == 'overview-msg alert-warning' || $("#msg1").attr('class') == 'overview-msg alert-success'){
	              			$("#msg1").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").addClass("alert-error");	
	              			$('#msg1').fadeOut(100);
              				$('#msg1').text("Ropping").fadeIn(1000);
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });
	<?php } ?>	
	
	<?php if($count_radios > 1){?>
		$(function () {
			  $('#link-status2').show();
		      $('#gauge2').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: 'Radio 2'
		        },
		        
		        pane: {
		            startAngle: -150,
		            endAngle: 150,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		           plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[1]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[1]['rms_semi_ropping']?>,
		                to: <?=$aParametros[1]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[1]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[1]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;

		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }
		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              if(y_data < <?=$aParametros[0]['rms_semi_ropping']?>){
		              	if($("#msg2").attr('class') == 'overview-msg calibrate'  || $("#msg2").attr('class') == 'overview-msg alert-warning' || $("#msg2").attr('class') == 'overview-msg alert-error'){
	              			$("#msg2").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").addClass("alert-success");	
	              			$('#msg2').fadeOut(100);
              				$('#msg2').text("Ideal").fadeIn(1000);
              			}
		              }else if(y_data > <?=$aParametros[0]['rms_semi_ropping']?> && y_data < <?=$aParametros[0]['rms_ropping']?>){
	              		if($("#msg2").attr('class') == 'overview-msg calibrate'  || $("#msg2").attr('class') == 'overview-msg alert-error' || $("#msg2").attr('class') == 'overview-msg alert-success'){
	              			$("#msg2").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").addClass("alert-warning");	
	              			$('#msg2').fadeOut(100);
              				$('#msg2').text("Semiropping").fadeIn(1000);
              			}     		
		              }else if(y_data > <?=$aParametros[0]['rms_ropping']?>){
	              		if($("#msg2").attr('class') == 'overview-msg calibrate'  || $("#msg2").attr('class') == 'overview-msg alert-warning' || $("#msg2").attr('class') == 'overview-msg alert-success'){
	              			$("#msg2").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").addClass("alert-error");	
	              			$('#msg2').fadeOut(100);
              				$('#msg2').text("Ropping").fadeIn(1000);
              			}
		              }
		              newVal = inc;	              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>

	<?php if($count_radios > 2){?>
		$(function () {
			  $('#link-status3').show();
		      $('#gauge3').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: 'Radio 3'
		        },
		        
		        pane: {
		            startAngle: -150,
		            endAngle: 150,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[2]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[2]['rms_semi_ropping']?>,
		                to: <?=$aParametros[2]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[2]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[2]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }
		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>

	<?php if($count_radios > 3){?>
		$(function () {
			  $('#link-status4').show();	
		      $('#gauge4').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: 'Radio 4'
		        },
		        
		        pane: {
		            startAngle: -150,
		            endAngle: 150,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[3]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[3]['rms_semi_ropping']?>,
		                to: <?=$aParametros[3]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[3]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[3]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }
		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>

	<?php if($count_radios > 4){?>
		$(function () {
			  $('#link-status5').show();
		      $('#gauge5').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: 'Radio 5'
		        },
		        
		        pane: {
		            startAngle: -150,
		            endAngle: 150,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[4]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[4]['rms_semi_ropping']?>,
		                to: <?=$aParametros[4]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[4]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[4]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;

		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }
		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>

	<?php if($count_radios > 5){?>
		$(function () {
			  $('#link-status6').show();
		      $('#gauge6').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: 'Radio 6'
		        },
		        
		        pane: {
		            startAngle: -150,
		            endAngle: 150,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[5]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[5]['rms_semi_ropping']?>,
		                to: <?=$aParametros[5]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[5]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[5]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }
		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>


</script>