<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
	// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
	require_once($aRoutes['paths']['config'].'bs_model.php');
?>

<div class="container container-body">
	<h2>TEST</h2>
	<div id="rms1"></div>
	<div id="rms2"></div>
	<div id="rms3"></div>
	<div id="rms4"></div>
	<div id="rms5"></div>
</div>




<script type="text/javascript">
	$(function () {
      $(document).ready(function() {
      	setInterval(function() {
	          var json1 = $.ajax({
	           url: 'ajax_test_rms.php?radio_id=1', // make this url point to the data file
	           dataType: 'json',
	           async: false
	          }).responseText;

	          var dataJson1 = eval(json1);
	          for (var i in dataJson1){
	             y_data1 = dataJson1[i].value;                            
	          }
	          console.log(y_data1);
	          $('#rms1').text(y_data1);

	          var json2 = $.ajax({
	           url: 'ajax_test_rms.php?radio_id=2', // make this url point to the data file
	           dataType: 'json',
	           async: false
	          }).responseText;

	          var dataJson2 = eval(json2);
	          for (var i in dataJson2){
	             y_data2 = dataJson2[i].value;                            
	          }
	          console.log(y_data2);


          	$('#rms2').text(y_data2);
             // console.log(y_data);


             var json3 = $.ajax({
	           url: 'ajax_test_rms.php?radio_id=3', // make this url point to the data file
	           dataType: 'json',
	           async: false
	          }).responseText;

	          var dataJson3 = eval(json3);
	          for (var i in dataJson3){
	             y_data3 = dataJson3[i].value;                            
	          }
	          console.log(y_data3);


          	$('#rms3').text(y_data3);
             // console.log(y_data);

             var json4 = $.ajax({
	           url: 'ajax_test_rms.php?radio_id=4', // make this url point to the data file
	           dataType: 'json',
	           async: false
	          }).responseText;

	          var dataJson4 = eval(json4);
	          for (var i in dataJson4){
	             y_data4 = dataJson4[i].value;                            
	          }
	          console.log(y_data4);


          	$('#rms4').text(y_data4);
             // console.log(y_data);

             var json5 = $.ajax({
	           url: 'ajax_test_rms.php?radio_id=5', // make this url point to the data file
	           dataType: 'json',
	           async: false
	          }).responseText;

	          var dataJson5 = eval(json5);
	          for (var i in dataJson5){
	             y_data5 = dataJson5[i].value;                            
	          }
	          console.log(y_data5);


          	$('#rms5').text(y_data5);
             // console.log(y_data);


	      }, 1000);
      });
  });


</script>