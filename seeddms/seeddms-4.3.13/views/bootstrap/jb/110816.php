<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>		
		<title>11 de Agosto de 2016</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>		
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />	
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />
	</head>
	<body>
		<h1 align="center"><img src="iieg.png" /></h1>
		<h1 class="text-center">11 de Agosto de 2016</h1><br/>	
		<div class="table-responsive"> 
		<table class="table table-responsive table-striped">
			<thead> 
			<tr>
			<!-- definimos cabeceras de la tabla --> 
			<th>Orden del día</th> 
			<th>Fecha y hora de sesión</th> 
			<th>Tipo de sesión</th>
			<th>Naturaleza de la sesión</th>
			<th>Documentos públicos para consulta previa</th>
			<th>Acta de sesión</th>
			<th>Documentos aprobados</th>
			</tr> 
			</thead>
		<tbody>
		<?php
		//1. Consulta la BD
		$link = @mysql_connect("localhost", "root","testIIEG2022") or die ("Error al conectar a la base de datos.");
		@mysql_select_db("seedms_db", $link) or die ("Error al conectar a la base de datos.");
		//EGCF 24/10/17 Quitar elementos raros 
		mysql_query("SET NAMES 'utf8'");
		/*2. query para: 
		|| Fecha y hora de sesión || Tipo de sesión || Naturaleza de la sesión*/
		$query=mysql_query("
			SELECT
			tblDocumentAttributes.value,
			tblDocumentAttributes.attrdef,
			tblDocumentAttributes.document,
			tblDocumentAttributes.id,
			t.value, 
			m.value,
			k.value,
			tblDocumentContent.orgFileName,
			tblDocumentContent.fileType
			FROM
			tblDocuments
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
			INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
			INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
			LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
			WHERE
			tblDocuments.name = 'Junta de Gobierno'
			and tblDocumentAttributes.attrdef=7
			and tblDocumentAttributes.value='11 de Agosto de 2016 a las 12:00 horas'
			GROUP BY tblDocumentAttributes.document
		"); 						

		//Ciclo que recorre toda la informaci&oacute;n
		while($info=@mysql_fetch_array($query))
		{
		?>
		<tr align="left">

		<?php $pdf=".pdf"?>
		<?php $xls=".xls"?>
		<?php $xlsx=".xlsx"?> 
		<?php $doc=".doc"?>
		<?php $docx=".docx"?>
		<?php $ppt=".ppt"?>
		<?php $pptx=".pptx"?>
		<?php $txt=".txt"?>
		<?php $rar=".rar"?>	

		<?php //ORDEN DEL DÍA?>
		<td ><div><br/>
		<a accesskey="" href="../../../data/1048576/<?php echo $info[2];?>/<?php 
		if($pdf==$info[8]) {echo "1.pdf";} 
		elseif($xls==$info[8]) {echo "1.xls";} 
		elseif($xlsx==$info[8]) {echo "1.xlsx";} 
		elseif($doc==$info[8]) {echo "1.doc";}  
		elseif($docx==$info[8]) {echo "1.docx";} 
		elseif($ppt==$info[8]) {echo "1.ppt";} 
		elseif($pptx==$info[8]) {echo "1.pptx";} 
		elseif($txt==$info[8]) {echo "1.txt";}	
		?>" target="_blank" onMouseover="window.status='Descargar documento'; return true;" onMouseout="window.status='';return true;"><img draggable="false" class="mimeicon" src="../images/<?php 
		if($pdf==$info[8]) {echo "pdf10.png";} 
		elseif($xls==$info[8]) {echo "excel3.ico";} 
		elseif($xlsx==$info[8]) {echo "excel3.ico";} 
		elseif($doc==$info[8]) {echo "word.ico";} 
		elseif($docx==$info[8]) {echo "word.ico";} 
		elseif($ppt==$info[8]) {echo "powerpoint.ico";} 
		elseif($pptx==$info[8]) {echo "powerpoint.ico";}  
		elseif($txt==$info[8]) {echo "txt.png";} 	
		?>" title="Ver documento"></a><br/><?php echo "<br/>";?>


		<?php //FECHA Y HORA DE LA SESIÓN?>
		<td> <?php echo $info[4];?></td> 

		<?php //TIPO DE SESIÓN?>
		<td> <?php echo $info[5];?></td> 

		<?php //NATURALEZA DE LA SESIÓN?>
		<td> <?php echo $info[6];?></td> 

		<?php //DOCUMENTOS PÚBLIOCOS PARA CONSULTA PREVIA?>
		<?php $query2=mysql_query("
			SELECT
			tblDocumentAttributes.`value`,
			tblDocumentAttributes.attrdef,
			tblDocumentAttributes.document,
			tblDocumentAttributes.id,
			t.value,
			m.value,
			k.value,
			tblDocumentContent.orgFileName,
			tblDocumentFiles.fileType,
			tblDocumentFiles.orgFileName,
			tblDocumentFiles.id,
			tblDocumentFiles.`name`
			FROM
			tblDocuments
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
			INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
			INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
			LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
			WHERE
			tblDocuments.name = 'Junta de Gobierno'
			and tblDocumentAttributes.attrdef=7	
			and tblDocumentFiles.`name` like '%consulta%'											

		"); 		
						
		?>

		<td><table align = "left" border="0" >
		<tr>
		<?php 
		//Ciclo que recorre toda la informaci&oacute;n 
		while($info2=@mysql_fetch_array($query2))
		{
		?>


		<!--<td align="center"><?php //echo $info2[9];?></td>-->
		<td  align="left"> <a accesskey="" href="../../../data/1048576/<?php echo $info2[2];?>/<?php if ($info2[11]="Documentos públicos para consulta previa") echo "f".$info2[10]; else echo $info2[10];?><?php echo $info2[8];?>" target="_blank" >				

		<?php if ($info[2] == $info2[2]){ echo "<LI>".$info2[9]."</LI>";} else {echo "";}?></a>  
		</td>
		</tr>
		<?php
		}
		?>
		</table></td> 

		<?php //ACTA DE SESIÓN?>
		<?php $query3=mysql_query("
			SELECT
			tblDocumentAttributes.`value`,
			tblDocumentAttributes.attrdef,
			tblDocumentAttributes.document,
			tblDocumentAttributes.id,
			t.value,
			m.value,
			k.value,
			tblDocumentContent.orgFileName,
			tblDocumentFiles.fileType,
			tblDocumentFiles.orgFileName,
			tblDocumentFiles.id,
			tblDocumentFiles.`name`
			FROM
			tblDocuments
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
			INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
			INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
			LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
			WHERE
			tblDocuments.name = 'Junta de Gobierno'
			and tblDocumentAttributes.attrdef=7	
			and tblDocumentFiles.`name` like '%acta%'

		"); 		
						
		?>
		<td> <table align="left"  border="0" >
		<tr>
		<?php 
		//Ciclo que recorre toda la informaci&oacute;n 
		while($info3=@mysql_fetch_array($query3))
		{
		?>


		<!--<td align="center"><?php //echo $info2[9];?></td>-->
		<td align="left"> <a accesskey="" href="../../../data/1048576/<?php echo $info3[2];?>/<?php if ($info3[11]="Acta de sesión") echo "f".$info3[10]; else echo $info3[10];?><?php echo $info3[8];?>" target="_blank" >
		<?php if ($info[2] == $info3[2]){ echo "<LI>".$info3[9]."</LI>";} else {echo "";}?></a></td>
		</tr>
		<?php
		}
		?>
		</table></td> 

		<?php //DOCUMENTOS APROBADOS?>
		<?php $query4=mysql_query("
			SELECT
			tblDocumentAttributes.`value`,
			tblDocumentAttributes.attrdef,
			tblDocumentAttributes.document,
			tblDocumentAttributes.id,
			t.value,
			m.value,
			k.value,
			tblDocumentContent.orgFileName,
			tblDocumentFiles.fileType,
			tblDocumentFiles.orgFileName,
			tblDocumentFiles.id,
			tblDocumentFiles.`name`
			FROM
			tblDocuments
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
			LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
			INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
			INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
			LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
			WHERE
			tblDocuments.name = 'Junta de Gobierno'
			and tblDocumentAttributes.attrdef=7	
			and tblDocumentFiles.`name` like '%aprobados%'

		"); 		
						
		?>
		<td> <table border="0" align="left">
		<tr>
		<?php 
		//Ciclo que recorre toda la informaci&oacute;n  
		while($info4=@mysql_fetch_array($query4))
		{
		?>


		<!--<td align="center"><?php //echo $info2[9];?></td>-->
		<td align="left"> <a accesskey="" href="../../../data/1048576/<?php echo $info4[2];?>/<?php if ($info4[11]="Documentos aprobados") echo "f".$info4[10]; else echo $info4[10];?><?php echo $info4[8];?>" target="_blank" >
		<?php if ($info[2] == $info4[2]){ echo "<LI>".$info4[9]."</LI>";} else {echo "";}?></a></td>
		</tr>
		<?php
		}
		?>
		</table></td> 		

		<?php }			
		?>
		</tbody>
		</table>
		</div>
	</body>
</html>
