<?php
/*
en este código se muestra la gráfica de total por estatus (concluidas y pendientes)
*/
?>

<?php

				require_once("conexion/conexion.php");

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>PIE</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container2').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Solicitudes por estatus'
        },
        subtitle: {
            text: 'Concluidas y pendientes'
        },
        plotOptions: {
            pie: {
                innerSize: 0,
                depth: 30
            }
        },
        series: [{
            name: 'Total',
            data: [
                
				<?php
						$sql=mysql_query("
						SELECT
							Count(*) AS TOTAL,
							tbldocuments.folder,
							tblfolders.name as NOMBRE
							FROM
							tbldocuments
							Inner Join tblfolders ON tbldocuments.folder = tblfolders.id
							WHERE
							tblfolders.id =  '22' OR
							tblfolders.id =  '2'
							GROUP BY
							tbldocuments.folder
							ORDER BY
							tbldocuments.folder ASC
						");
						while($res=mysql_fetch_array($sql)){			
						?>			
						//['<?php echo $res['Mes']; ?>', <?php echo $res['TOTAL'] ?>],
						['<?php echo $res['NOMBRE']; ?>',<?php echo $res['TOTAL'] ?>],
								
						<?php
						}

					?>	
            ]
        }]
    });
	
	//
}


);
		</script>
	</head>
	<body>

<script src="Highcharts-4.1.5/js/highcharts.js"></script>
<script src="Highcharts-4.1.5/js/highcharts-3d.js"></script>
<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container2" style="height: 400px"></div>
<br><br>
<center><a href="index.php">regresar</a></center>
	</body>
</html>
