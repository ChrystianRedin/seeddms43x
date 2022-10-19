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
		<title>Total general</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {

    $('#container').highcharts({

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
                text: <?php
						$sql=mysql_query("  
											SELECT date_format( FROM_UNIXTIME( DATE ),'%M' ) AS Mes,  count(*) as TOTALMES, folder as CONCLUIDAS
											FROM tblDocuments
											WHERE MONTH( FROM_UNIXTIME( DATE ) ) between 1 and 12
											AND YEAR( FROM_UNIXTIME( DATE ) ) =2015
											
											GROUP BY 
											MONTH( FROM_UNIXTIME( DATE ) )
											ORDER BY
											folder
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
											SELECT date_format( FROM_UNIXTIME( DATE ),'%M' ) AS Mes,  count(*) as TOTALMES, folder as CONCLUIDAS
											FROM tblDocuments
											WHERE MONTH( FROM_UNIXTIME( DATE ) ) between 1 and 12	
											AND YEAR( FROM_UNIXTIME( DATE ) ) =2015
											
											GROUP BY 
											MONTH( FROM_UNIXTIME( DATE ) )
											ORDER BY
											folder
										");
						while($res=mysql_fetch_array($sql)){			
						?>			
									[<?php echo $res['TOTALMES'] ?>],
								
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
});
		</script>
	</head>
	<body>
<script src="Highcharts-4.1.5/js/highcharts.js"></script>
<script src="Highcharts-4.1.5/js/highcharts-more.js"></script>
<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
<br><br>
<center><a href="index.php">regresar</a></center>
	</body>
</html>
