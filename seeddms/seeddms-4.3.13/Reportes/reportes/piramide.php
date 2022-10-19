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

    $('#container4').highcharts({
        chart: {
            type: 'pyramid',
            marginRight: 250
        },
        title: {
            text: 'Solicitudes por unidad',
            x: -50
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> ({point.y:,.0f})',
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    softConnector: true
                }
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Total',
            data: [
						<?php
						$sql=mysql_query("  
											SELECT
												tblworkflowactions.name as UNIDAD,
												count(*) as 'TOTALDESOLICITUDES'
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id

												LEFT JOIN  ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 13) AS t ON tblDocuments.id = t.document

												WHERE
												tblworkflowlog.userid =  '63'
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014 
												group by tblworkflowactions.name

										");
						while($res=mysql_fetch_array($sql)){			
						?>			
									['<?php echo $res['UNIDAD'] ?>', <?php echo $res['TOTALDESOLICITUDES'] ?> ],
									
								
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
<script src="Highcharts-4.1.5/js/modules/funnel.js"></script>
<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container4" style="min-width: 410px; max-width: 600px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
