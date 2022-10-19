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
            type: 'bar'
        },
        title: {
            text: 'Total de solicitudes por mes'
        },
            xAxis: {
            categories: [
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
														and YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
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
							(tblfolders.id !=  '22' or  tblfolders.id =  '22' and YEAR( FROM_UNIXTIME( tblDocuments.date ) )=2014) 
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
            text: 'Total de solicitudes 2015'
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
            max: 1000,

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
                text: '2015'
            },
            plotBands: [{
                from: 0,
                to: 330,
				color: '#DF5353'
                //color: '#55BF3B'  // green
            }, {
                from: 330,
                to: 660,
                color: '#DDDF0D' // yellow
            }, {
                from: 660,
                to: 1000,
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
											and YEAR( FROM_UNIXTIME( tblDocuments.date ) ) =2014
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
												AND tblworkflowtransitions.action=21
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
	//fin barra
	
	
	//gaue concluidas
	$('#cuga1').highcharts({

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: ''
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
            max: 1000,

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
                text: <?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =8
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
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
            },
            plotBands: [{
                from: 0,
                to: 330,
				color: '#DF5353'
                //color: '#55BF3B'  // green
            }, {
                from: 330,
                to: 660,
                color: '#DDDF0D' // yellow
            }, {
                from: 660,
                to: 1000,
				color: '#55BF3B' 
                //color: '#DF5353' // red 
            }]
        },

        series: [{
            name: 'Total', 
            data: [
					<?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =8
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

											ORDER BY
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

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
	
	//fin gauge concluidas
	
	//gauge sept
	$('#cuga2').highcharts({

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: ''
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
            max: 1000,

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
                text: <?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
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
            },
            plotBands: [{
                from: 0,
                to: 330,
				color: '#DF5353'
                //color: '#55BF3B'  // green
            }, {
                from: 330,
                to: 660,
                color: '#DDDF0D' // yellow
            }, {
                from: 660,
                to: 1000,
				color: '#55BF3B' 
                //color: '#DF5353' // red 
            }]
        },

        series: [{
            name: 'Total', 
            data: [
					<?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

											ORDER BY
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

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
	//fin gauge sept
	
	//gauge sept
	$('#cuga3').highcharts({

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: ''
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
            max: 1000,

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
                text: <?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
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
            },
            plotBands: [{
                from: 0,
                to: 330,
				color: '#DF5353'
                //color: '#55BF3B'  // green
            }, {
                from: 330,
                to: 660,
                color: '#DDDF0D' // yellow
            }, {
                from: 660,
                to: 1000,
				color: '#55BF3B' 
                //color: '#DF5353' // red 
            }]
        },

        series: [{
            name: 'Total', 
            data: [
					<?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

											ORDER BY
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

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
	//fin gauge sept
	
	//gauge sept
	$('#cuga4').highcharts({

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: ''
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
            max: 1000,

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
                text: <?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
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
            },
            plotBands: [{
                from: 0,
                to: 330,
				color: '#DF5353'
                //color: '#55BF3B'  // green
            }, {
                from: 330,
                to: 660,
                color: '#DDDF0D' // yellow
            }, {
                from: 660,
                to: 1000,
				color: '#55BF3B' 
                //color: '#DF5353' // red 
            }]
        },

        series: [{
            name: 'Total', 
            data: [
					<?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

											ORDER BY
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

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
	//fin gauge sept
	
	//gauge sept
	$('#cuga5').highcharts({

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: ''
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
            max: 1000,

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
                text: <?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
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
            },
            plotBands: [{
                from: 0,
                to: 330,
				color: '#DF5353'
                //color: '#55BF3B'  // green
            }, {
                from: 330,
                to: 660,
                color: '#DDDF0D' // yellow
            }, {
                from: 660,
                to: 1000,
				color: '#55BF3B' 
                //color: '#DF5353' // red 
            }]
        },

        series: [{
            name: 'Total', 
            data: [
					<?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

											ORDER BY
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

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
	//fin gauge sept
	
	//gauge sept
	$('#cuga6').highcharts({

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: ''
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
            max: 1000,

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
                text: <?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
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
            },
            plotBands: [{
                from: 0,
                to: 330,
				color: '#DF5353'
                //color: '#55BF3B'  // green
            }, {
                from: 330,
                to: 660,
                color: '#DDDF0D' // yellow
            }, {
                from: 660,
                to: 1000,
				color: '#55BF3B' 
                //color: '#DF5353' // red 
            }]
        },

        series: [{
            name: 'Total', 
            data: [
					<?php
						$sql=mysql_query("  
											SELECT
											date_format( FROM_UNIXTIME(  tblDocuments.date ),'%M' ) AS Mes, 
											count(tblgroups.name) as TOTAL
											FROM
											tblworkflowlog
											Inner Join tbldocuments ON tblworkflowlog.document = tbldocuments.id
											Inner Join tblusers ON tblusers.id = tblworkflowlog.userid
											Inner Join tblworkflowtransitions ON tblworkflowtransitions.id = tblworkflowlog.transition
											Inner Join tblworkflowactions ON tblworkflowactions.id = tblworkflowtransitions.action
											Inner Join tblworkflowstates ON tblworkflowtransitions.state = tblworkflowstates.id
											Inner Join tblgroupmembers ON  tblusers.id=tblgroupmembers.userID
											Inner Join tblgroups ON tblgroupmembers.groupID = tblgroups.id
											where tblworkflowtransitions.action=34
											and 
											tblgroups.id=6 
											and
											MONTH( FROM_UNIXTIME( tblDocuments.date ) ) =9
											and 
											YEAR( FROM_UNIXTIME( tblDocuments.date ) ) = 2014
											group by
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

											ORDER BY
											MONTH( FROM_UNIXTIME( tblDocuments.date ) )

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
	//fin gauge sept
	
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
         
        <div style="border-top:1px solid #CDCDCD;margin:10px;padding:0;clear:both;"></div>
		
		<div id="container2" style="width: 50%; height: 400px; margin: 0 auto;float:left;"></div> 
		<div id="container4" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div> 
		
		<div style="border-top:1px solid #CDCDCD;margin:10px;padding:0;clear:both;"></div>
		
		<div id="container5" style="height: 400px; margin: 0 auto;"></div> 
		
		<div style="border-top:1px solid #CDCDCD;margin:10px;padding:0;clear:both;"></div>
		<p align = center >Solicitudes concluidas por mes para demografía</p>
		
		<div id="cuga1" style="width: 16%; height: 250px; margin: 0 auto;float:left;"></div>
		<div id="cuga2" style="width: 16%; height: 250px; margin: 0 auto;float:left;"></div>
		<div id="cuga3" style="width: 16%; height: 250px; margin: 0 auto;float:left;"></div>
		<div id="cuga4" style="width: 16%; height: 250px; margin: 0 auto;float:left;"></div>
		<div id="cuga5" style="width: 16%; height: 250px; margin: 0 auto;float:left;"></div>
		<div id="cuga6" style="width: 16%; height: 250px; margin: 0 auto;float:left;"></div>
		
		<!-- div que contendrá la gráfica circular -->
        <!--<div id="container2" style="height: 400px; margin: 0 auto;"></div>-->
 
        
	</body>
</html>
