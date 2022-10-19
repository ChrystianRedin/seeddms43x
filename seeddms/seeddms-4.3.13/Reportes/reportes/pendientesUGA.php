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
    $('#container6').highcharts({
		colors: ['#DF0101'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes pendientes para Unidad Geografico-Ambiental'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                			<?php
								$sql=mysql_query("	
												SELECT	
												Count(*) AS TOTAL,
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes
												FROM
												tblDocuments																		
												Inner Join tblFolders ON tblFolders.id = tblDocuments.folder														
												WHERE																			
												(tblDocuments.folder !=  '22') and 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
												and
												tblfolders.id=8
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 
						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>',<?php echo $res['TOTAL'] ?>],
											
								<?php
								}
							?>
						],
						
						
						
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color.red};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
					{
						name: 'UGA', 
						data: [<?php
								$sql=mysql_query("	SELECT	
												Count(*) AS TOTAL,
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes
												FROM
												tblDocuments																		
												Inner Join tblFolders ON tblFolders.id = tblDocuments.folder														
												WHERE																			
												(tblDocuments.folder !=  '22') and 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
												and
												tblfolders.id=8
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 
												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											['<?php echo $res['Mes']; ?>',<?php echo $res['TOTAL'] ?>],
											//['<?php echo $res['Mes']; ?>',<?php echo $res['Unidad'] ?>],
											
								<?php
								}
							?>]

					
					}
					
				]
    });
});
		</script>
	</head>
	<body>
<script src="Highcharts-4.1.5/js/highcharts.js"></script>
<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container6" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
