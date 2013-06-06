<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'st_model.php');

?>

<div id='chart_div'></div>

<script type='text/javascript' src='http://www.google.com/jsapi'></script>
<script type='text/javascript'>
  google.load('visualization', '1', {packages:['gauge']});
  google.setOnLoadCallback(drawChart);
</script>

<script type="text/javascript">
	function Timer(){this.t={};this.tick=function(a,b){this.t[a]=[(new Date).getTime(),b]};this.tick("start")}var loadTimer=new Timer;window.jstiming={Timer:Timer,load:loadTimer};if(window.external&&window.external.pageT)window.jstiming.pt=window.external.pageT;if(window.jstiming)window.jstiming.report=function(g,d){var c="";if(window.jstiming.pt){c+="&srt="+window.jstiming.pt;delete window.jstiming.pt}if(window.external&&window.external.tran)c+="&tran="+window.external.tran;var a=g.t,h=a.start;delete a.start;var i=[],e=[];for(var b in a){if(b.indexOf("_")==0)continue;var f=a[b][1];if(f)a[f][0]&&e.push(b+"."+(a[b][0]-a[f][0]));else h&&i.push(b+"."+(a[b][0]-h[0]))}if(d)for(var j in d)c+="&"+j+"="+d[j];(new Image).src=["http://csi.gstatic.com/csi?v=3","&s=gviz&action=",g.name,e.length?"&it="+e.join(",")+c:c,"&rt=",i.join(",")].join("")};
	var csi_timer = new window.jstiming.Timer();
	csi_timer.name = 'docs_gauge';

	google.setOnLoadCallback(drawChart);

	function drawChart() {

	  csi_timer.tick('load');

	  var data = new google.visualization.DataTable();
	  data.addColumn('string', 'Label');
	  data.addColumn('number', 'Value');
	  data.addRows(3);
	  data.setValue(0, 0, 'Memory');
	  data.setValue(0, 1, 80);

	  csi_timer.tick('data');

	  var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

	  csi_timer.tick('new');

	  var options = {width: 400, height: 120, redFrom: 90, redTo: 100,
	      yellowFrom:75, yellowTo: 90, minorTicks: 5};
	  chart.draw(data, options);

	  csi_timer.tick('draw');
	  window.jstiming.report(csi_timer);  

	  setInterval(function() {
	    data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
	    chart.draw(data, options);
	  }, 2000);
	}
</script>



<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>