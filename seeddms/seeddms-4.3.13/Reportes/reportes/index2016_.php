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
	//barra horizontal
    $('#container').highcharts({
        chart: {
            //opara cambiar la orientación de la barra a horizontal se deja como
            //type: 'bar'
            type: 'column'
        },
        title: {
            text: 'Total de solicitudes por mes'
        },
            xAxis: {
            categories: [
<?php
/*$sql=mysql_query("SELECT date_format( FROM_UNIXTIME( DATE ),'%M' ) AS Mes,  count(*) as TOTALMES 
								FROM tblDocuments
								WHERE MONTH( FROM_UNIXTIME( DATE ) ) BETWEEN 1 AND 12														
								AND YEAR( FROM_UNIXTIME( DATE ) ) =2016
								GROUP BY
								MONTH( FROM_UNIXTIME( DATE ) )
								ORDER BY
								MONTH( FROM_UNIXTIME( DATE ) )");
while($res=mysql_fetch_array($sql)){			
?>
			
			['<?php echo $res['Mes'] ?>'],
			
<?php
}
?>*/

$sql=mysql_query("SELECT date_format( FROM_UNIXTIME( DATE ),'%M' ) AS Mes,  count(*) as TOTALMES 
								FROM tblDocuments
								WHERE MONTH( FROM_UNIXTIME( DATE ) ) BETWEEN 1 AND 12														
								AND YEAR( FROM_UNIXTIME( DATE ) ) =2016
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
														and YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
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
	
	//pie
	/*$('#container2').highcharts({
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
							tblDocuments.folder,
							tblFolders.name as NOMBRE
							FROM
							tblDocuments
							Inner Join tblFolders ON tblDocuments.folder = tblFolders.id
							WHERE
							(tblFolders.id !=  '22' or  tblFolders.id =  '22' and YEAR( FROM_UNIXTIME( tblDocuments.date ) )=2016) 
							GROUP BY
							tblDocuments.folder
							ORDER BY
							tblDocuments.folder ASC
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
    });*/
	
	
	//ESTATUS
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
											tblFolders.id = '22' and YEAR( FROM_UNIXTIME( tblDocuments.date ) )=2016
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
											tblFolders.id != '22' and YEAR( FROM_UNIXTIME( tblDocuments.date ) )=2016
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
	
	
	//gauge_total
	$('#container3').highcharts({

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: 'Total de solicitudes 2016'
        },

        pane: {
            startAngle: -150,
            endAngle: 150,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },

        // the value axis
        yAxis: {
            min: 0,
            max: 2000,

            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: '2016'
            },
            plotBands: [{
                from: 0,
                to: 666,
				color: '#DF5353'
                //color: '#55BF3B'  // green
            }, {
                from: 666,
                to: 1332,
                color: '#DDDF0D' // yellow
            }, {
                from: 1332,
                to: 2000,
				color: '#55BF3B' 
                //color: '#DF5353' // red 
            }]
        },

        series: [{
            name: 'Total',
            data: [
					<?php
						$sql=mysql_query("  
											SELECT count(*) as 'TOTAL'
											FROM tblDocuments
											WHERE MONTH( FROM_UNIXTIME( DATE ) )  between 1 and 12 
											and YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
										");
						while($res=mysql_fetch_array($sql)){			
						?>			
									[<?php echo $res['TOTAL'] ?>],
								
						<?php
						}
					?>			
			],			
            tooltip: {
                valueSuffix: ' Solicitudes'
            }
        }]

    },
        // Add some life
        function (chart) {
            if (!chart.renderer.forExport) {
                setInterval(function () {
                    var point = chart.series[0].points[0],
                        newVal,
                        inc = Math.round((Math.random() -0) * 0);

                    newVal = point.y + inc;
                    if (newVal < 0 || newVal > 1000) {
                        newVal = point.y - inc; 
                    }

                    point.update(newVal);

                }, 3000);
            }
        });
		
		//piramide
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
												tblWorkflowActions.name as UNIDAD,
												count(*) as 'TOTALDESOLICITUDES'
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												group by tblWorkflowActions.name

										");
						while($res=mysql_fetch_array($sql)){			
						?>			
									['<?php echo  utf8_encode ( $res['UNIDAD'] )?>', <?php echo $res['TOTALDESOLICITUDES'] ?> ],
									
								
						<?php
						}
					?>
                
				
				  ]
        }]
    });
	
	//barra
	
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
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=19
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
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=7
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
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=18
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
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=19
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
					}  /*{
						name: 'UGSJ', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=19
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
					}*/ , {
						name: 'UTI', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=21
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
					} /*, {
						name: 'UV', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=38
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
						name: 'UCV', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=63
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
					} */, {
						name: 'UAJ', 
						data: [<?php
								$sql=mysql_query("	SELECT
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes,
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=22
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
												count(tblWorkflowActions.name) as TOTAL
												FROM
												tblWorkflowLog
												Inner Join tblDocuments ON tblWorkflowLog.document = tblDocuments.id
												Inner Join tblUsers ON tblUsers.id = tblWorkflowLog.userid
												Inner Join tblWorkflowTransitions ON tblWorkflowTransitions.id = tblWorkflowLog.transition
												Inner Join tblWorkflowActions ON tblWorkflowActions.id = tblWorkflowTransitions.action
												Inner Join tblWorkflowStates ON tblWorkflowTransitions.state = tblWorkflowStates.id
												WHERE
												tblWorkflowLog.userid =  '63'
												AND MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12															
												AND YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2016
												AND tblWorkflowTransitions.action=23
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
	//fin barra
	
	//conclUSD
	$('#CONUSD').highcharts({
		colors: ['#DF0101'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes concluidas para Unidad Socio-Demográfica'
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
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												Inner Join tblFolders ON tblFolders.id = tblDocuments.folder
												where 
												(tblDocuments.folder !=  '22') and
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=6
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 

						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'USD', 
						data: [<?php
								$sql=mysql_query("	SELECT
												Count(*) AS TOTAL,
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes
												FROM
												tblDocuments
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=6
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
	//fin conclUSD
	
	//conclUEF
	$('#CONUEF').highcharts({
		colors: ['#848484'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes concluidas para Unidad Económico-Financiera'
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
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=8
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 

						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'UEF', 
						data: [<?php
								$sql=mysql_query("	SELECT
												Count(*) AS TOTAL,
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes
												FROM
												tblDocuments
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=8
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 
												");
								while($res=mysql_fetch_array($sql)){			
								?>
											
											['<?php echo $res['Mes']; ?>',<?php echo $res['TOTAL']/4 ?>],
											//['<?php echo $res['Mes']; ?>',<?php echo $res['Unidad'] ?>],
											
								<?php
								}
							?>]

					
					}
					
				]
    });
	//fin conclUEF
	
	//conclUGA
	$('#CONUGA').highcharts({
		colors: ['#2E9AFE'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes concluidas para Unidad Geográfico-Ambiental'
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
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=4
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 

						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=4
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
	//fin conclUEF
	
	//conclUGA
	$('#CONUTI').highcharts({
		colors: ['#A5DF00'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes concluidas para Unidad Tecnologías de Información'
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
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=1
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 

						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'UTI', 
						data: [<?php
								$sql=mysql_query("	SELECT
												Count(*) AS TOTAL,
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes
												FROM
												tblDocuments
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=1
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
	//fin conclUEF
	
	//conclUGA
	$('#CONUAJ').highcharts({
		colors: ['#DF7401'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes concluidas para Unidad Asuntos Jurídicos'
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
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=5
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 

						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'UAJ', 
						data: [<?php
								$sql=mysql_query("	SELECT
												Count(*) AS TOTAL,
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes
												FROM
												tblDocuments
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=5 
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
	//fin conclUEF
	
	//conclUGA
	$('#CONUA').highcharts({
		colors: ['#DF0101'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes concluidas para Unidad Administrativa'
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
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=2
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 

						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'UA', 
						data: [<?php
								$sql=mysql_query("	SELECT
												Count(*) AS TOTAL,
												date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes
												FROM
												tblDocuments
												Inner Join tblDocumentStatus ON tblDocuments.id = tblDocumentStatus.documentID
												Inner Join tblDocumentStatusLog ON tblDocumentStatus.statusID = tblDocumentStatusLog.statusID
												Inner Join tblUsers ON tblDocumentStatusLog.userID = tblUsers.id
												Inner Join tblGroupMembers ON tblUsers.id = tblGroupMembers.userID
												Inner Join tblGroups ON tblGroupMembers.groupID = tblGroups.id
												where 
												MONTH( FROM_UNIXTIME( tblDocuments.date ) ) BETWEEN 1 AND 12
												and 
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												AND
												tblGroups.id=2
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
	//fin conclUEF
	
	//INICIO PENDIENTES USD
	$('#PENUSD').highcharts({
		colors: ['#DF0101'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes pendientes para Unidad Socio-Demográfica'
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=8
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 
						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'USD', 
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=8
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
	//FIN PENDIENTES USD
	
	//INICIO PENDIENTES UEF
	$('#PENUEF').highcharts({
		colors: ['#848484'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes pendientes para Unidad Económico-Financiera'
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=9
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 
						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'UEF', 
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=9
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
	//FIN PENDIENTES USD
	
	//INICIO PENDIENTES UGA
	$('#PENUGA').highcharts({
		colors: ['#2E9AFE'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes pendientes para Unidad Geográfico-Ambiental'
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=10
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 
						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=10
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
	//FIN PENDIENTES USD
	
	//INICIO PENDIENTES UTI
	$('#PENUTI').highcharts({
		colors: ['#A5DF00'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes pendientes para Unidad Tecnologías de Información'
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=12
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 
						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'UTI', 
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=12
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
	//FIN PENDIENTES USD
	
	//INICIO PENDIENTES UAJ
	$('#PENUAJ').highcharts({
		colors: ['#DF7401'], 
        chart: {
            type: 'column' 
        },
        title: {
            text: 'Solicitudes pendientes para Unidad Asuntos Jurídicos'
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=13
												group by MONTH( FROM_UNIXTIME( tblDocuments.date ) )
												order by MONTH( FROM_UNIXTIME( tblDocuments.date ) ) 
						
								");
								while($res=mysql_fetch_array($sql)){			
								
								?>
											
											['<?php echo $res['Mes']; ?>'],
											
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
						name: 'UAJ', 
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
												YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2016
												and
												tblFolders.id=13
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
	//FIN PENDIENTES USD
	
});
		</script>
	</head>
	<body>
<script src="Highcharts-4.1.5/js/highcharts.js"></script>
<script src="Highcharts-4.1.5/js/highcharts-more.js"></script>
<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>
<script src="Highcharts-4.1.5/js/modules/funnel.js"></script>


<!--manda llamar a todos-->
		<!-- div que contendrá la gráfica a tiempo real --> 
        <div id="container3" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<!-- div que contendrá la gráfica lienal -->
        <div id="container" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>     
        <div style="border-top:1px solid #000000;margin:10px;padding:0;clear:both;"></div>		
		<div id="container5" style="height: 400px; margin: 0 auto;"></div>
		<div style="border-top:1px solid #000000;margin:10px;padding:0;clear:both;"></div>		
		<div id="estatus" style="width: 50%; height: 400px; margin: 0 auto;float:left;"></div> 
		<div id="container4" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div> 		
		<div style="border-top:1px solid #000000;margin:10px;padding:0;clear:both;"></div>				
		<div id="CONUSD" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<div id="PENUSD" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<!--<div id="CONUEF" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<div id="PENUEF" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>-->
		<div id="CONUGA" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<div id="PENUGA" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<div id="CONUTI" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<div id="PENUTI" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<!--<div id="CONUAJ" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
		<div id="PENUAJ" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>-->
		<!--<div id="CONUA" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>-->
		<div style="border-top:1px solid #000000;margin:10px;padding:0;clear:both;"></div>		

		<!-- div que contendrá la gráfica circular -->
        <!--<div id="container2" style="height: 400px; margin: 0 auto;"></div>-->
 
        
	</body>
</html>
