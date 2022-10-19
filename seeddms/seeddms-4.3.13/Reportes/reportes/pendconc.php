<?php

				require_once("conexion/conexion.php");

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#estatus').highcharts({
		colors: ['#04B431','#B40404'], 
        chart: {
            type: 'column'
        },
        title: {
            text: 'Solicitudes por estatus'
        },
        subtitle: {
            text: 'Comparativo'
        },
        xAxis: {
            categories: ['Estatus'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cantidad'
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
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Concluidas',			
            data: [<?php
						$sql=mysql_query("
											SELECT
											Count(*) AS CONCLUIDAS,
											tblDocuments.folder
											FROM
											tblDocuments
											Inner Join tblFolders ON tblDocuments.folder = tblFolders.id
											WHERE
											tblFolders.id = '22' and YEAR( FROM_UNIXTIME( tblDocuments.date ) )=2015
											GROUP BY
											'PENDIENTES'
										");
						while($res=mysql_fetch_array($sql)){			
						?>			
									[<?php echo $res['CONCLUIDAS'] ?>],
								
						<?php
						}
					?>]
        },{
            name: 'Pendientes',
            data: [
				
				<?php
						$sql=mysql_query("
											SELECT
											Count(*) AS PENDIENTES,
											tblDocuments.folder
											FROM
											tblDocuments
											Inner Join tblFolders ON tblDocuments.folder = tblFolders.id
											WHERE
											tblFolders.id != '22' and YEAR( FROM_UNIXTIME( tblDocuments.date ) )=2015
											GROUP BY
											'PENDIENTES'
										");
						while($res=mysql_fetch_array($sql)){			
						?>			
									[<?php echo $res['PENDIENTES'] ?>],
								
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

<div id="estatus" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
