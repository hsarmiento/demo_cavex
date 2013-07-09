<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
	// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
	require_once($aRoutes['paths']['config'].'bs_model.php');
?>

<div class="container container-body">
	<h2>TEST</h2>
	<div class="hidrociclon"><img height="400" width="400" src="assets/img/Overview_2.png"></div>

	<div id="gauge1" class="gauge"></div>
	<div id="gauge2" class="gauge"></div>
	<div id="gauge3" class="gauge"></div>
	<div id="gauge4" class="gauge"></div>
	<div id="gauge5" class="gauge"></div>
	<div id="gauge6" class="gauge"></div>
</div>



<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>/modules/exporting.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts-more.js"></script>

<script type="text/javascript">

	$(function () {
      $(document).ready(function() {
      	setInterval(function() {
	          var json = $.ajax({
	           url: 'json_test_dynamic.php', // make this url point to the data file
	           dataType: 'json',
	           async: false
	          }).responseText;

          	  obj = JSON.parse(json);
      	  	  var div = 1;
          	  for (var i in obj){
          	  	// $('#rms'+div.toString()).text(obj[i].value);
          	  	$('#gauge'+div.toString()).highcharts({  
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
			            text: 'Gauge_'+div.toString()
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
			            min: 0,
			            max: <?php echo 1024;?>,
			            
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
			                from: 0,
			                to: 600,
			                color: '#55BF3B' // green
			            }, 
			            // {
			            //     from: <?php echo $rms;?>,
			            //     to: <?php echo $limite?>,
			            //     color: '#DDDF0D' // yellow
			            // }, 
			            {
			                from: 600,
			                to:  1024,
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
			      		  y_data = obj[i].value; 
			              var point = chart.series[0].points[0],
			                  newVal,
			                  inc = y_data;
			                  console.log(obj[i].value);
			              
			              newVal = inc;
			              
			              point.update(newVal);
			      }
			    });
          	  	div = div +1;
          	  	// console.log(obj[i].id);
          	  }
	      }, 1000);
      });
  });


</script>