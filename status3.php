<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'st_model.php');

?>


<div class="container container-body">		
	<h2>Status</h2>

	<div id="chart_div" style="width: 900px; height: 500px;"></div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>


<script type="text/javascript">
  	function Timer(){this.t={};this.tick=function(a,b){this.t[a]=[(new Date).getTime(),b]};this.tick("start")}var loadTimer=new Timer;window.jstiming={Timer:Timer,load:loadTimer};if(window.external&&window.external.pageT)window.jstiming.pt=window.external.pageT;if(window.jstiming)window.jstiming.report=function(g,d){var c="";if(window.jstiming.pt){c+="&srt="+window.jstiming.pt;delete window.jstiming.pt}if(window.external&&window.external.tran)c+="&tran="+window.external.tran;var a=g.t,h=a.start;delete a.start;var i=[],e=[];for(var b in a){if(b.indexOf("_")==0)continue;var f=a[b][1];if(f)a[f][0]&&e.push(b+"."+(a[b][0]-a[f][0]));else h&&i.push(b+"."+(a[b][0]-h[0]))}if(d)for(var j in d)c+="&"+j+"="+d[j];(new Image).src=["http://csi.gstatic.com/csi?v=3","&s=gviz&action=",g.name,e.length?"&it="+e.join(",")+c:c,"&rt=",i.join(",")].join("")};

	google.load('visualization', '1', {packages:['gauge']});
    google.setOnLoadCallback(drawChart);
    var csi_timer = new window.jstiming.Timer();
	csi_timer.name = 'docs_gauge';

	function drawChart() {
		csi_timer.tick('load');
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Label');
	  	data.addColumn('number', 'Value');
	  	data.addRows(1);
	  	data.setValue(0, 0, 'VALORES');
  		data.setValue(0, 1, 0);

  		csi_timer.tick('data');

  		var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

  		csi_timer.tick('new');

  		var options = {width: 400, height: 120, redFrom: 5, redTo: 7,
      	yellowFrom:3, yellowTo: 5, minorTicks: 5, greenFrom: 1, greenTo: 3, max:7};
		chart.draw(data, options);

		csi_timer.tick('draw');
		window.jstiming.report(csi_timer);

		setInterval(function() {
			var json = $.ajax({
		     url: 'json_pure.php', // make this url point to the data file
		     dataType: 'json',
		     async: false
		    }).responseText;

		    var obj = jQuery.parseJSON(json);
		    // console.log(obj.value);
		    data.setValue(0, 1, obj.value);
		    chart.draw(data, options);
		  }, 1000);	    
	}

</script>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>