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
    $('#container5').highcharts({
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes por Unidad'
        },
        subtitle: {
            text: 'comparativo'
        },
        xAxis: {
            categories: [
                			<?php
								$sql=mysql_query("	
												SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblworkflowactions.name) as TOTAL
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
												WHERE
												tblworkflowlog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
												AND tblworkflowtransitions.action=19
												GROUP BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												ORDER BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )							
								");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											['<?php echo $res['Mes'] ?>'],
											
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
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
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
						name: 'USD', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblworkflowactions.name) as TOTAL
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
												WHERE
												tblworkflowlog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
												AND tblworkflowtransitions.action=7
												GROUP BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												ORDER BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )	
												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											[<?php echo $res['TOTAL'] ?>],
											
								<?php
								}
							?>]

					} , {
						name: 'UEF', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblworkflowactions.name) as TOTAL
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
												WHERE
												tblworkflowlog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
												AND tblworkflowtransitions.action=19
												GROUP BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												ORDER BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )	

												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											[<?php echo $res['TOTAL'] ?>],
											
								<?php
								}
							?>]
					} , {
						name: 'UGA', 
						data: [<?php
								$sql=mysql_query("	
												SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblworkflowactions.name) as TOTAL
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
												WHERE
												tblworkflowlog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
												AND tblworkflowtransitions.action=19
												GROUP BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												ORDER BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )	
												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											[<?php echo $res['TOTAL'] ?>],
											
								<?php
								}
							?>]
					} , {
						name: 'UGSJ', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblworkflowactions.name) as TOTAL
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
												WHERE
												tblworkflowlog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
												AND tblworkflowtransitions.action=19
												GROUP BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												ORDER BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )	

												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											[<?php echo $res['TOTAL'] ?>],
											
								<?php
								}
							?>]
					} , {
						name: 'UTI', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblworkflowactions.name) as TOTAL
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
												WHERE
												tblworkflowlog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
												AND tblworkflowtransitions.action=19
												GROUP BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												ORDER BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )	

												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											[<?php echo $res['TOTAL'] ?>],
											
								<?php
								}
							?>]
					} , {
						name: 'UAJ', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblworkflowactions.name) as TOTAL
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
												WHERE
												tblworkflowlog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
												AND tblworkflowtransitions.action=19
												GROUP BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												ORDER BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )	

												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											[<?php echo $res['TOTAL'] ?>],
											
								<?php
								}
							?>]
					}, {
						name: 'UA', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblworkflowactions.name) as TOTAL
												FROM
												tblworkflowlog
												Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
												Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
												Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
												Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
												Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
												WHERE
												tblworkflowlog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
												AND tblworkflowtransitions.action=19
												GROUP BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												ORDER BY
												MONTH( FROM_UNIXTIME( tblDocuments.date ) )	

												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											[<?php echo $res['TOTAL'] ?>],
											
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

<div id="container5" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
