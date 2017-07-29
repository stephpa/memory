<!DOCTYPE HTML>
<html>
<head>
    <title>RM Rep</title>
    <style>
           body { font-family: Arial, sans-serif; }
           td { padding: 0px 5px; }
    </style>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var jsonData5 = $.ajax({
          url: "test7getdata.php",
          dataType:"json",
          async: false
          }).responseText;

      var options = {
          title: 'IP Distribution',
          is3D: true,
        };


      var data5 = new google.visualization.DataTable(jsonData5);
      var chart5 = new google.visualization.PieChart(document.getElementById('chart_div_5'));
      chart5.draw(data5, options);
   
      var jsonData6 = $.ajax({
          url: "test8getdata.php",
          dataType:"json",
          async: false
          }).responseText;

      var options = {
          title: 'OS Distribution',
          is3D: true,
        };

      var data6 = new google.visualization.DataTable(jsonData6);
      var chart6 = new google.visualization.PieChart(document.getElementById('chart_div_6'));
      chart6.draw(data6, options);


      var jsonData7 = $.ajax({
          url: "test9getdata.php",
          dataType:"json",
          async: false
          }).responseText;


    var options = {
          title: 'Browser Distribution',
          is3D: true,
        };

      var data7 = new google.visualization.DataTable(jsonData7);
      var chart7 = new google.visualization.PieChart(document.getElementById('chart_div_7'));
      chart7.draw(data7, options);

      var jsonData8 = $.ajax({
          url: "test10getdata.php",
          dataType:"json",
          async: false
          }).responseText;


    var options = {
          title: 'Click Distribution',
          hAxis: {title: 'Clicks', minValue: 24, maxValue: 100},
          vAxis: {title: 'Times', minValue: 0, maxValue: 20},
          legend: 'none'
        };

      var data8 = new google.visualization.DataTable(jsonData8);
      var chart8 = new google.visualization.ScatterChart(document.getElementById('chart_div_8'));
      chart8.draw(data8, options);

    var jsonData9 = $.ajax({
          url: "test11getdata.php",
          dataType:"json",
          async: false
          }).responseText;


    var options = {
          title: 'Language Distribution',
          is3D: true,
        };

      var data9 = new google.visualization.DataTable(jsonData9);
      var chart9 = new google.visualization.PieChart(document.getElementById('chart_div_9'));
      chart9.draw(data9, options);
    }

    </script>
</head>
<body>

<?php

$server = "localhost";
$username = "****";
$password = "*****";
$database = "****";

$conn = mysql_connect($server, $username, $password);

if (!$conn)
{
        die('Could not connect: ' . mysql_error());
}
mysql_select_db($database, $conn);

// Get all the results for issues matching the chosen status id.
$result = mysql_query("SELECT DTE, IP, GAME, CNT, TIME_TO_SEC(TIMEDIFF(DTE,DTB)) TD, LNG FROM srlog ORDER BY DTE DESC LIMIT 10" , $conn);

if ( !$result )
{
        echo("<p>Error performing query: " . mysql_error() . "</p>");
        exit();
}

mysql_close($conn);
?>
        <title>RM Rep</title>
        <style>
                body { font-family: Arial, sans-serif; }
                td { padding: 0px 5px; }
        </style>

	<table>
	<col width="50%">
	<col width="50%">
        <tr><td><div id="chart_div_5"></div></td><td><div id="chart_div_6"></div><td></tr>
        <tr><td><div id="chart_div_7"></div></td><td><div id="chart_div_9"></div></td></tr>
	<tr><td><div id="chart_div_8"></div></td>
        <td align="center">
	<table>
        <?php
                // Print results.
		echo("<tr><th>Finishdate</th><th>IP</th><th>Game</th><th>Clicks</th><th>SEC</th><th>LNG</th></tr>");
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
                {
                        echo("<tr>");
			echo("<td>" . $row['DTE'] . "</td>");
                        echo("<td>" . $row['IP'] . "</td>");
                        echo("<td>" . $row['GAME'] . "</td>");
                        echo("<td>" . $row['CNT'] . "</td>");
			echo("<td>" . $row['TD'] . "</td>");
	                echo("<td>" . $row['LNG'] . "</td>"); 
			echo("</tr>");
                }
        ?>
        </table>
	</td></tr>
	</table>
</body>
</html>
