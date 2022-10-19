<?php
/*
en este código se muestra la gráfica de total por mes
*/
?>

<?php

				require_once("conexion/conexion.php");

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Graficas del GDD</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Total de solicitudes'
        },
            xAxis: {
            categories: [
							<?php
							$sql=mysql_query("SELECT date_format( FROM_UNIXTIME( DATE ),'%M' ) AS Mes,  count(*) as TOTALMES 
															FROM tblDocuments
															WHERE MONTH( FROM_UNIXTIME( DATE ) ) BETWEEN 1 AND 12														
															AND YEAR( FROM_UNIXTIME( DATE ) ) =2015
															GROUP BY
															MONTH( FROM_UNIXTIME( DATE ) )
															ORDER BY
															MONTH( FROM_UNIXTIME( DATE ) )");
							while($res=mysql_fetch_array($sql)){			
							?>
										
										['<?php echo $res['Mes'] ?>'],
										
							<?php
							}
							?>
			
			],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' '
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Total',
            data: [
					<?php
						$sql=mysql_query("SELECT date_format( FROM_UNIXTIME( DATE ),'%M' ) AS Mes,  count(*) as TOTALMES 
														FROM tblDocuments
														WHERE MONTH( FROM_UNIXTIME( DATE ) ) BETWEEN 1 AND 12														
														AND YEAR( FROM_UNIXTIME( DATE ) ) =2014
														GROUP BY
														MONTH( FROM_UNIXTIME( DATE ) )
														ORDER BY
														MONTH( FROM_UNIXTIME( DATE ) )");
						while($res=mysql_fetch_array($sql)){			
						?>			
									[<?php echo $res['TOTALMES'] ?>],
								
						<?php
						}
					?>			
			]
        }]
    });
});
		</script>
	</head>
	<body>
<script src="Highcharts-4.1.5/js/highcharts.js"></script>
<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<br><br>
<center><a href="index.php">regresar</a></center>
	</body>
</html>
