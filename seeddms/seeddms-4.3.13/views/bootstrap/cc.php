<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=UTF-8" http-equiv=Content-Type>
<title>Consejo Consultivo</title>
<style type="text/css">
<!--
.tabla {
	font-family: arial;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
}
-->
</style>
</head>

<body>
<p align="center"><img src="logo_jalisco.jpg"></p>

<p align="center"> <FONT FACE="arial" SIZE=5 COLOR=Gray><b><u>Consejo Consultivo</u><br><br>Instituto de Información Estadística y Geográfica de Jalisco</FONT> </p>
<table width="1296" border="1" align="center" class="tabla">
  <tr align="center">
	<td ><b>Orden del día</b></td>
    <td ><b>Fecha y hora de sesión</b></td>    
    <td ><b>Tipo de sesión</b></td>
    <td ><b>Naturaleza de la sesión</b></td>
    <td ><b>Documentos públicos para consulta previa</b></td>
    <td ><b>Acta de sesión</b></td>
    <td ><b>Documentos aprobados</b></td>
  </tr>
   
   
   
   <?php
		//1. Consulta la BD
		$link = @mysql_connect("localhost", "iieggob_transpa","ufLRX2KTXLsK9MH8") or die ("Error al conectar a la base de datos.");
		@mysql_select_db("iieggob_transparencia2", $link) or die ("Error al conectar a la base de datos.");
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
								tblDocuments.name = 'Consejo Consultivo'
								and tblDocumentAttributes.attrdef=7
								GROUP BY tblDocumentAttributes.document
							"); 						

	 //Ciclo que recorre toda la informaci&oacute;n
	while($info=@mysql_fetch_array($query))
	{
	?>
  <tr align="center">

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
		<td><div align="center" class="Estilo18"><br/>
		  <a accesskey="" href="../../data/1048576/<?php echo $info[2];?>/<?php 
		if($pdf==$info[8]) {echo "1.pdf";} 
		elseif($xls==$info[8]) {echo "1.xls";} 
		elseif($xlsx==$info[8]) {echo "1.xlsx";} 
		elseif($doc==$info[8]) {echo "1.doc";}  
		elseif($docx==$info[8]) {echo "1.docx";} 
		elseif($ppt==$info[8]) {echo "1.ppt";} 
		elseif($pptx==$info[8]) {echo "1.pptx";} 
		elseif($txt==$info[8]) {echo "1.txt";}	
		?>" target="_blank" onMouseover="window.status='Descargar documento'; return true;" onMouseout="window.status='';return true;"><img draggable="false" class="mimeicon" src="../../views/bootstrap/images/<?php 
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
									tblDocuments.name = 'Consejo Consultivo'
									and tblDocumentAttributes.attrdef=7	
									and tblDocumentFiles.`name` like '%consulta%'
									
								"); 		
													
		?>
		
		<td><table align = "center" border="0" align="left" class="tabla">
			<tr>
			<?php 
			 //Ciclo que recorre toda la informaci&oacute;n 
			while($info2=@mysql_fetch_array($query2))
			{
			?>
			
			
				<!--<td align="center"><?php //echo $info2[9];?></td>-->
	     		<td  align="left"> <a accesskey="" href="../../data/1048576/<?php echo $info2[2];?>/<?php if ($info2[11]="Documentos públicos para consulta previa") echo "f".$info2[10]; else echo $info2[10];?><?php echo $info2[8];?>" target="_blank" >
			<?php if ($info[2] == $info2[2]){ echo ">".$info2[9];} else {echo "";}?></a></td>
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
									tblDocuments.name = 'Consejo Consultivo'
									and tblDocumentAttributes.attrdef=7	
									and tblDocumentFiles.`name` like '%acta%'
									
								"); 		
													
		?>
	<td> <table align="center"  border="0" align="left" class="tabla">
			<tr>
			<?php 
			 //Ciclo que recorre toda la informaci&oacute;n 
			while($info3=@mysql_fetch_array($query3))
			{
			?>
			
			
				<!--<td align="center"><?php //echo $info2[9];?></td>-->
	     		<td align="left"> <a accesskey="" href="../../data/1048576/<?php echo $info3[2];?>/<?php if ($info3[11]="Acta de sesión") echo "f".$info3[10]; else echo $info3[10];?><?php echo $info3[8];?>" target="_blank" >
			<?php if ($info[2] == $info3[2]){ echo ">".$info3[9];} else {echo "";}?></a></td>
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
									tblDocuments.name = 'Consejo Consultivo'
									and tblDocumentAttributes.attrdef=7	
									and tblDocumentFiles.`name` like '%aprobados%'
									
								"); 		
													
		?>
	<td> <table align="center" border="0" align="left" class="tabla">
			<tr>
			<p>No se aprobaron documentos </p>
			<?php 
			 //Ciclo que recorre toda la informaci&oacute;n 
			/*while($info4=@mysql_fetch_array($query4))
			{
			?>
			
			
				<!--<td align="center"><?php //echo $info2[9];?></td>-->
	     		<td align="left"> <a accesskey="" href="../../data/1048576/<?php echo $info4[2];?>/<?php if ($info4[11]="Documentos aprobados") echo "f".$info4[10]; else echo $info4[10];?><?php echo $info4[8];?>" target="_blank" >
			<?php if ($info[2] == $info4[2]){ echo ">".$info4[9];} else {echo "";}?></a></td>
			</tr>
				<?php
				}*/
				?>
		  </table></td> 
	
	
	

  </tr>
    <?php
	}
?>
</table> 
</body>
</html>
