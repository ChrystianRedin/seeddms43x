<script>
$(function () {
   // captura el evento keyup cuando escribes en el input
    $("#search").keyup(function(){
        _this = this;
        // Muestra los tr que concuerdan con la busqueda, y oculta los demás.
        $.each($("#ExportarExcel"), function() {
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
               $(this).hide();
            else
               $(this).show();                
        }); 
    }); 							
});
</script>
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>

<p align="center"><img src="logo_jalisco.jpg"></p>

<p align="center"> <FONT FACE="arial" SIZE=5 COLOR=Gray><b><u>Junta de Gobierno</u><br><br>Instituto de Informaci&oacute;n Estad&iacute;stica y Geogr&aacute;fica de Jalisco</FONT> </p>

<style type="text/css"> 

.encabezado td {
	color: #FFF;
	font-family: Verdana, Geneva, sans-serif;
	font-weight: bold;
	font-size: 14px;
	text-align: center;
}

.textoceldas td {
	font-size: 14px;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
	color: #333;
}
</style>

</table>
</br>

<script type="text/javascript" src="jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script>

<script language="javascript">
// When document is ready: this gets fired before body onload 🙂
$(document).ready(function(){
	// Write on keyup event of keyword input element
	$("#kwd_search").change(function(){
		// When value of the input is not blank
		if( $(this).val() != "")
		{
			// Show only matching TR, hide rest of them
			$("#ExportarExcel tbody>tr").hide();
			$("#ExportarExcel td:contains-ci('" + $(this).val() + "')").parent("tr").show();
		}
		else
		{
			// When there is no input or clean again, show everything back
			$("#ExportarExcel tbody>tr").show();
		}
	});
});
// jQuery expression for case-insensitive filter
$.extend($.expr[":"], 
{
    "contains-ci": function(elem, i, match, array) 
	{
		return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
	}
});
</script>

<div class="row large-centered">
        
</div>
	
<div class="row large-centered">
<label ><p align="center"> <FONT FACE="arial" SIZE=5 COLOR=Gray><b>
<p align="center">Seleccionar fecha:
  </label> 
  <?php echo"<select id= \"kwd_search\" >";  ?>  <br/>
  <br/>

					<?php					 
					 $link = @mysql_connect("localhost", "iieggob_transpa","ufLRX2KTXLsK9MH8")
					  or die ("Error al conectar a la base de datos.");
					@mysql_select_db("iieggob_transparencia2", $link)
					  or die ("Error al conectar a la base de datos.");
					  //EGCF 24/10/17 Quitar elementos raros
					  mysql_query("SET NAMES 'utf8'");
					 
					$fechas = mysql_query("SELECT
							x.id AS `ID DEL DOCUMENTO`,
							x.`name` AS `Tipo de Contrato`,
							x.`comment` AS `Tipo de C`,
							t.value AS `Nombre de la persona física o jurídica`,
							k.value AS Monto,
							m.value AS `Acciones a realizar`,
							n.value AS `Proyecto o partida`,
							p.value AS Vigencia,
							q.value AS Vigencia222,
							tblDocumentContent.orgFileName,
							tblDocumentContent.fileType,
							tblDocumentFiles.fileType,
							tblDocumentFiles.id AS PDF,
							tblDocumentFiles.orgFileName,
							tblDocumentFiles.`comment`
						FROM
							tblDocuments AS x
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON x.id = t.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 8) AS k ON x.id = k.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON x.id = m.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS n ON x.id = n.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 11) AS p ON x.id = p.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 12) AS q ON x.id = q.document
							INNER JOIN tblDocumentContent ON tblDocumentContent.document = x.id
							LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = x.id
						WHERE
							x.`name`='Junta de Gobierno'
							GROUP BY x.date
						ORDER BY
							`ID DEL DOCUMENTO` Desc",$link);
					while($fecha = mysql_fetch_array($fechas)) {
					echo "<option value='".$fecha[3]."'>".$fecha[3]."</option>";
					
					}
					echo "</select>";  
					?>
</p>
<p>&nbsp;</p>
<div id="table_wrapper">
<script>
	$(document).ready(function() {
  $("#btnExport").click(function(e) {
    e.preventDefault();
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById('table_wrapper');
    var table_html = table_div.outerHTML.replace(/ /g, '%20');

    var a = document.createElement('a');
    a.href = data_type + ', ' + table_html;
    a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
    a.click();
  });
});
	                </script>
<div id="table_wrapper">
</p>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF" id="ExportarExcel" class="ExportarExcel">

<?php $nofile="No hay archivo"?>

<!--para establecer como invisible una tabla se utiliza el tag: style="display: none"-->

  <thead>
	  <tr>
	  <td ><div align="center" class="Estilo16" style="width: 200px;">Fecha y hora de sesi&oacute;n</div></td>
	  <td ><div align="center" class="Estilo16" style="width: 150px;">Orden del d&iacute;a</div></td>
	  <td ><div align="center" class="Estilo16" style="width: 150px;">Tipo de sesi&oacute;n</div></td>
	  <td ><div align="center" class="Estilo16" style="width: 200px;">Naturaleza de la sesi&oacute;n</div></td>
	  <td ><div align="center" class="Estilo16" style="width: 200px;">Tipo de documento</div></td>
	  <td ><div align="center" class="Estilo16" style="width: 200px;">URL</div></td>
	  <td ><div align="center" class="Estilo16" style="width: 200px;">Nombre del documento</div></td>
	
	   
  </thead>
  <tbody>
  <p align="center"><button id="btnExport">Exportar a excel</button></p>
  </tr>
	<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
	</form>
	<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
	<script language="javascript">
	$(document).ready(function() {
	     $(".botonExcel").click(function(event) {
	     $("#datos_a_enviar").val( $("<div>").append( $("#ExportarExcel").eq(0).clone()).html());
	     $("#FormularioExportacion").submit();
	});
	});
	</script>

  <?php
	//Consultamos la tabla de ipimun05
	$link = @mysql_connect("localhost", "iieggob_transpa","ufLRX2KTXLsK9MH8")
      or die ("Error al conectar a la base de datos.");
	@mysql_select_db("iieggob_transparencia2", $link)
      or die ("Error al conectar a la base de datos.");
	  //EGCF 24/10/17 Quitar elementos raros 
	  mysql_query("SET NAMES 'utf8'");					
						$query=mysql_query("
						SELECT
							x.id AS `ID DEL DOCUMENTO`,
							x.`name` AS `Tipo de Contrato`,
							x.`comment` AS `Tipo de C`,
							t.value AS `Nombre de la persona física o jurídica`,
							k.value AS Monto,
							m.value AS `Acciones a realizar`,
							n.value AS `Proyecto o partida`,
							p.value AS Vigencia,
							q.value AS Vigencia222,
							tblDocumentContent.orgFileName,
							tblDocumentContent.fileType,
							tblDocumentFiles.fileType,
							tblDocumentFiles.id AS PDF,
							tblDocumentFiles.orgFileName,
							tblDocumentFiles.`comment`
						FROM
							tblDocuments AS x
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON x.id = t.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 8) AS k ON x.id = k.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON x.id = m.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS n ON x.id = n.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 11) AS p ON x.id = p.document
							LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 12) AS q ON x.id = q.document
							INNER JOIN tblDocumentContent ON tblDocumentContent.document = x.id
							LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = x.id
						WHERE
							x.`name`='Junta de Gobierno'
						ORDER BY
							`ID DEL DOCUMENTO` Desc
							");							
							
							//------------------------------------------------
							//CONSULTA PARA BARRER LOS ARCHIVOS SUELTOS PARA CADA UNA DE LAS SESIONES DE LA JUNTA DE GOBIERNO; SE TRATA DE UNA SUBCONSULTA
							$query2=mysql_query("
							SELECT
								x.id AS `ID DEL DOCUMENTO`,
								tbldocumentfiles.orgFileName,
								tbldocumentfiles.`comment`,
								tbldocumentfiles.`name`
							FROM
								tbldocuments AS x
							INNER JOIN tbldocumentcontent ON tbldocumentcontent.document = x.id
							LEFT JOIN tbldocumentfiles ON tbldocumentfiles.document = x.id
							WHERE
								x.`name` = 'Junta de Gobierno'
							AND tbldocumentfiles.`comment` LIKE '%Documentos apro%'
							
							ORDER BY
								`ID DEL DOCUMENTO` DESC
							"); 
							
							//------------------------------------------------


	//Ciclo que recorre toda la informaci&oacute;n
	while($info=@mysql_fetch_array($query))
	{
?>

	<tr bgcolor="#FFFFFF" class="textoceldas">
	
	<!--<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><br/><a rel="<?php echo $info[3];?>" draggable="true" ondragstart="onDragStartDocument(event);" href="../../op/op.Download.php?documentid=<?php echo $info[3];?>&amp;version=1"><img draggable="false" class="mimeicon" src="../../views/bootstrap/images/pdf.png" title="Ver documento"></a><br/><?php echo $info[3];?> </div></td>-->    
	
	<?php $pdf=".pdf"?>
	<?php $xls=".xls"?>
	<?php $xlsx=".xlsx"?> 
	<?php $doc=".doc"?>
	<?php $docx=".docx"?>
	<?php $ppt=".ppt"?>
	<?php $pptx=".pptx"?>
	<?php $txt=".txt"?>
	<?php $rar=".rar"?>	
	

	
	<td width="57" class="Estilo1" ><div align="center" class="Estilo18"><?php echo $info[3];?></div></td>
		
	<td width="57" class="Estilo1" ><div align="center" class="Estilo18"><br/><a accesskey="" href="../../data/1048576/<?php echo $info[0];?>/<?php 
	if($pdf==$info[10]) {echo "1.pdf";} 
	elseif($xls==$info[10]) {echo "1.xls";} 
	elseif($xlsx==$info[10]) {echo "1.xlsx";} 
	elseif($doc==$info[10]) {echo "1.doc";}  
	elseif($docx==$info[10]) {echo "1.docx";} 
	elseif($ppt==$info[10]) {echo "1.ppt";} 
	elseif($pptx==$info[10]) {echo "1.pptx";} 
	elseif($txt==$info[10]) {echo "1.txt";}	
	?>" target="_blank" onMouseover="window.status='Descargar documento'; return true;" onMouseout="window.status='';return true;"><img draggable="false" class="mimeicon" src="../../views/bootstrap/images/<?php 
		 if($pdf==$info[10]) {echo "pdf10.png";} 
	elseif($xls==$info[10]) {echo "excel3.ico";} 
	elseif($xlsx==$info[10]) {echo "excel3.ico";} 
	elseif($doc==$info[10]) {echo "word.ico";} 
	elseif($docx==$info[10]) {echo "word.ico";} 
	elseif($ppt==$info[10]) {echo "powerpoint.ico";} 
	elseif($pptx==$info[10]) {echo "powerpoint.ico";} 
	elseif($txt==$info[10]) {echo "txt.png";} 	
	?>" title="Ver documento"></a><br/><?php echo "<br/>";?>
	
	
	<td width="57" class="Estilo1" ><div align="center" class="Estilo18"><?php echo $info[5];?></div></td>
	<td width="57" class="Estilo1" ><div align="center" class="Estilo18"><?php echo $info[6];?></div></td>
	<td width="57" class="Estilo1" ><div align="center" class="Estilo18"><?php echo $info[14];?></div></td>
	
	
	<!--para mostrar el .zip/.rar-->
	<td width="57" class="Estilo1" ><div align="center" class="Estilo18"><br/><a accesskey="" href="../../data/1048576/<?php echo $info[0];?>/<?php 
	if($pdf==$info[11]) {echo "f".$info[12].".pdf";} 
	elseif($xls==$info[11]) {echo "f".$info[12].".xls";}	
	elseif($xlsx==$info[11]) {echo "f".$info[12].".xlsx";}	
	elseif($doc==$info[11]) {echo "f".$info[12].".doc";}	
	elseif($docx==$info[11]) {echo "f".$info[12].".docx";}	
	elseif($ppt==$info[11]) {echo "f".$info[12].".ppt";}	
	elseif($pptx==$info[11]) {echo "f".$info[12].".pptx";}	
	elseif($txt==$info[11]) {echo "f".$info[12].".txt";}	
	// EGCF para meter la sibconsulta elseif($rar==$info[11]) {echo "f".$info[12].".rar";}		
	elseif($rar==$info[11]) {echo "f".$info[12].".rar";}	
	
	?>" target="_blank" onMouseover="window.status='Descargar documento'; return true;" onMouseout="window.status='';return true;"><img draggable="false" class="mimeicon" src="../../views/bootstrap/images/<?php 
		 if($pdf==$info[11]) {echo "pdf10.png";} 
	elseif($xls==$info[11]) {echo "excel3.ico";} 
	elseif($xlsx==$info[11]) {echo "excel3.ico";} 
	elseif($doc==$info[11]) {echo "word.ico";} 
	elseif($docx==$info[11]) {echo "word.ico";} 
	elseif($ppt==$info[11]) {echo "powerpoint.ico";} 
	elseif($pptx==$info[11]) {echo "powerpoint.ico";} 
	elseif($txt==$info[11]) {echo "txt.png";} 		
	elseif($rar==$info[11]) {echo "rar2.png";} 		
	?>" ></a><br/><?php echo "<br/>";?>
	<!---->
	<td width="57" class="Estilo1" ><div align="center" class="Estilo18"><?php echo $info[13];?></div></td>
	
	
  </tr>

  <?php
	}
?>
</tbody>
</table>



