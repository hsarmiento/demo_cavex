
<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'st_model.php');

$oModel = new STModel();
$query = "SELECT * FROM parametros order by id desc limit 1;";
$aParametros = $oModel->Select($query);

$rms = $aParametros[0]['rms'];
$limite = ($rms)*(1+$aParametros[0]['porcentaje']/100);

echo $limite;


?>

<div class="container container-body">		
	<h2>Status</h2>
  <div class="row">
      <h3>R.M.S</h3>
      <div class="span3">
        <div id="gauge_rms" style="width: 300px; height: 200px; margin: 0 auto"></div>
        <span id="status"></span>
      </div>
      <div class="span6"><div id="line_rms" class="offset1" style="width: 500px; height: 400px; margin-bottom: 100px;"></div>
      </div>
  </div>
  <div class="row">
      <h3>Standard Desviation</h3>
      <div class="span3">
        <div id="gauge_sd" style="width: 300px; height: 200px; margin: 0 auto"></div>
        <span id="status"></span>
      </div>
      <div class="span6"><div id="line_sd" class="offset1" style="width: 500px; height: 400px; margin-bottom: 100px;"></div>
      </div>
  </div>
</div>


<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>/modules/exporting.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts-more.js"></script>

<!-- <script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script> -->


<script type="text/javascript">
  $(function () {
      $(document).ready(function() {
          Highcharts.setOptions({
              global: {
                  useUTC: false
              }
          });
      
          var chart;
          $('#line_rms').highcharts({
              credits:{
                enabled: false
              },
              chart: {
                  type: 'spline',
                  borderWidth: 1,
                  animation: Highcharts.svg, // don't animate in old IE
                  marginRight: 10,
                  events: {
                      load: function() {
      
                          // set up the updating of the chart each second
                          var series = this.series[0];
                          setInterval(function() {
                              var json = $.ajax({
                               url: 'json_status_rms.php', // make this url point to the data file
                               dataType: 'json',
                               async: false
                              }).responseText;

                              var dataJson = eval(json);
                              for (var i in dataJson){
                                 y_data = dataJson[i].value;                            
                              } 
                              var x = (new Date()).getTime(), // current time
                                  y = y_data;
                              series.addPoint([x, y], true, true);
                          }, 1000);
                      }
                  }
              },
              title: {
                  text: 'Live data'
              },
              xAxis: {
                  type: 'datetime',
                  tickPixelInterval: 150
              },
              yAxis: {
                  title: {
                      text: 'Value'
                  },
                  min: 0,
                  max: 1024,
                  plotLines: [{
                      value: 0,
                      width: 1,
                      color: '#808080'
                  }]
              },
              tooltip: {
                  formatter: function() {
                          return '<b>'+ this.series.name +'</b><br/>'+
                          Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
                          Highcharts.numberFormat(this.y, 2);
                  }
              },
              legend: {
                  enabled: false
              },
              exporting: {
                  enabled: false
              },
              series: [{
                  name: 'Random data',
                  data: (function() {
                      // generate an array of random data
                      var data = [],
                          time = (new Date()).getTime(),
                          i;
                      var json = $.ajax({
                               url: 'json_status_rms.php', // make this url point to the data file
                               dataType: 'json',
                               async: false
                              }).responseText;

                              var dataJson = eval(json);
                              for (var i in dataJson){
                                 y_data = dataJson[i].value;                            
                              } 
                      for (i = -19; i <= 0; i++) {
                          data.push({
                              x: time + i * 1000,
                              y: y_data
                          });
                      }
                      return data;
                  })()
              }]
          });
      });
      
  });


  $(function () {
    
      $('#gauge_rms').highcharts({
    
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
            text: 'Gauge'
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
                to: <?php echo $rms;?>,
                color: '#55BF3B' // green
            }, {
                from: <?php echo $rms;?>,
                to: <?php echo $limite?>,
                color: '#DDDF0D' // yellow
            }, {
                from: <?php echo $limite?>,
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
          setInterval(function () {
              var json = $.ajax({
               url: 'json_status_rms.php', // make this url point to the data file
               dataType: 'json',
               async: false
              }).responseText;

              var dataJson = eval(json);
              for (var i in dataJson){
                
                 y_data = dataJson[i].value;                         
              }
              if ((y_data > <?php echo $rms;?>) && (y_data <= <?php echo $limite;?>)){
                    $("#status").text('splash').css("color","yellow").show();
                }else if(y_data > <?php echo $limite;?>){
                    console.log('roping');
                    $("#status").hide();
                    $("#status").text('roping').css("color","red").show();
                }else{
                    $("#status").text('normal').css("color","green").show();
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
</script>

<!-- STATUS DESVIACION -->


<script type="text/javascript">
  $(function () {
      $(document).ready(function() {
          Highcharts.setOptions({
              global: {
                  useUTC: false
              }
          });
      
          var chart;
          $('#line_sd').highcharts({
              credits:{
                enabled: false
              },
              chart: {
                  type: 'spline',
                  borderWidth: 1,
                  animation: Highcharts.svg, // don't animate in old IE
                  marginRight: 10,
                  events: {
                      load: function() {
      
                          // set up the updating of the chart each second
                          var series = this.series[0];
                          setInterval(function() {
                              var json = $.ajax({
                               url: 'json_status_sd.php', // make this url point to the data file
                               dataType: 'json',
                               async: false
                              }).responseText;

                              var dataJson = eval(json);
                              for (var i in dataJson){
                                 y_data = dataJson[i].value;                            
                              } 
                              var x = (new Date()).getTime(), // current time
                                  y = y_data;
                              series.addPoint([x, y], true, true);
                          }, 1000);
                      }
                  }
              },
              title: {
                  text: 'Live data'
              },
              xAxis: {
                  type: 'datetime',
                  tickPixelInterval: 150
              },
              yAxis: {
                  title: {
                      text: 'Value'
                  },
                  min: 0,
                  max: 0.05,
                  plotLines: [{
                      value: 0,
                      width: 1,
                      color: '#808080'
                  }]
              },
              tooltip: {
                  formatter: function() {
                          return '<b>'+ this.series.name +'</b><br/>'+
                          Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
                          Highcharts.numberFormat(this.y, 2);
                  }
              },
              legend: {
                  enabled: false
              },
              exporting: {
                  enabled: false
              },
              series: [{
                  name: 'Random data',
                  data: (function() {
                      // generate an array of random data
                      var data = [],
                          time = (new Date()).getTime(),
                          i;
                      var json = $.ajax({
                               url: 'json_status_sd.php', // make this url point to the data file
                               dataType: 'json',
                               async: false
                              }).responseText;

                              var dataJson = eval(json);
                              for (var i in dataJson){
                                 y_data = dataJson[i].value;                            
                              } 
                      for (i = -19; i <= 0; i++) {
                          data.push({
                              x: time + i * 1000,
                              y: y_data
                          });
                      }
                      return data;
                  })()
              }]
          });
      });
      
  });


  $(function () {
    
      $('#gauge_sd').highcharts({
    
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
            text: 'Gauge'
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
                to: <?php echo 500;?>,
                color: '#55BF3B' // green
            }, {
                from: 500,
                to: 550,
                color: '#DDDF0D' // yellow
            }, {
                from: 550,
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
          setInterval(function () {
              var json = $.ajax({
               url: 'json_status_sd.php', // make this url point to the data file
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
</script>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>