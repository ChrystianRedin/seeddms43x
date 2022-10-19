<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=UTF-8" http-equiv=Content-Type>
<title>Comité de transparencia convocatorias</title>
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

<p align="center"> <FONT FACE="arial" SIZE=5 COLOR=Gray><b><u>Comité de transparencia convocatorias</u><br><br>Instituto de Información Estadística y Geográfica de Jalisco</FONT> </p>
<table width="1296" border="1" align="center" class="tabla">
  <tr align="center">
	<td ><b>Fecha y hora de sesión</b></td> 
	<td ><b>Orden del día</b></td>  
    <td ><b>Tipo de sesión</b></td>
    <td ><b>Naturaleza de la sesión</b></td>
    <td ><b>Documentos públicos para consulta</b></td>
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
								tblDocuments.name = 'Comite de transparencia convocatorias'
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
	
	<?php //FECHA Y HORA DE LA SESIÓN?>
	<td> <?php echo $info[4];?></td> 
  
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
	
		
	<?php //TIPO DE SESIÓN?>
		<td> <?php echo $info[5];?></td> 
	
	<?php //NATURALEZA DE LA SESIÓN?>
		<td> <p>Restringida</p></td> 
	
	<?php //DOCUMENTOS PÚBLIOCOS PARA CONSULTA PREVIA?>
		
		<td><table align = "center" border="0" align="left" class="tabla">
			<tr>
			<p>No Aplica</p>
		  </table></td> 
	 
	

	
	
	

  </tr>
    <?php
	}
?>
</table> 
</body>
</html>
