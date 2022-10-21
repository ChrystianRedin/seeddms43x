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

<p align="center"> <FONT FACE="arial" SIZE=5 COLOR=Gray><b>Contratos del Instituto de Informaci&oacute;n Estad&iacute;stica y Geogr&aacute;fica de Jalisco</FONT> </p>



<!--sección de carga de estilos para la tabla-->
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
<!--general-->
<!--<table border="1" cellspacing=1 cellpadding=2 style="font-size: 8pt" align="center">-->



<?php



/*
  $link = @mysql_connect("localhost", "root","testIIEG2022")
      or die ("Error al conectar a la base de datos.");
  @mysql_select_db("seedms_db", $link)
      or die ("Error al conectar a la base de datos.");

  $query = ("			SELECT
							t.number
						FROM
							ost_ticket AS t
						INNER JOIN ost_staff AS g ON t.staff_id = g.staff_id
						INNER JOIN ost_user ON ost_user.id = t.user_id
						INNER JOIN ost_ticket_status ON t.status_id = ost_ticket_status.id
						INNER JOIN ost_ticket__cdata ON t.ticket_id = ost_ticket__cdata.ticket_id
						WHERE ost_user.`name` <> 'Prueba'
						order by t.created desc  ");

			
  $result = mysql_query($query);
  //$numero = 0;
  while($row = mysql_fetch_array($result))
  {

    $numero++;
  }
  echo "<tr><td colspan=\"15\"><font face=\"verdana\"><b>Total: " . $numero .
      "</b></font></td></tr>";

  mysql_free_result($result);
  mysql_close($link);*/
?>
</table>
</br>

<!--Detalle general-->

<script type="text/javascript" src="jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script>

<script language="javascript">
// When document is ready: this gets fired before body onload 🙂
$(document).ready(function(){
	// Write on keyup event of keyword input element
	$("#kwd_search").keyup(function(){
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
<label for="kwd_search"><p align="center"> <FONT FACE="arial" SIZE=5 COLOR=Gray><b>Buscar:</label> <input type="text" id="kwd_search" value=""/><br/><br/>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF" id="ExportarExcel" class="ExportarExcel">

<!--para establecer como invisible una tabla se utiliza el tag: style="display: none"-->

  <thead>
	  <tr class="encabezado">
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 130px;">No. de Contrato</div></td>
	  <!--<td bgcolor="770000"><div align="center" class="Estilo16">ID_Agente</div></td>-->
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 150px;">Tipo de Contrato</div></td>
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 200px;">Nombre de la Persona f&iacute;sica o jur&iacute;dica</div></td>
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 200px;">Monto</div></td>
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 200px;">Acciones a realizar</div></td>
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 350px;">Proyecto o partida</div></td>
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 200px;">Vigencia</div></td>  
  </thead>
  <tbody>
  </tr>
	<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
	<!--<p align=center>Exportar <img src="export_to_excel.gif" class="botonExcel" /></p>-->
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
	$link = @mysql_connect("localhost", "root","1234")
      or die ("Error al conectar a la base de datos.");
  @mysql_select_db("seeeddms", $link)
      or die ("Error al conectar a la base de datos.");

//consulta activa en la página
/*$query=mysql_query("
						SELECT
							t.number,							
							g.firstname,
							g.lastname,
							t.created,
							t.closed,
							ost_user.`name`,
							ost_ticket_status.name,
							ost_ticket__cdata.`subject`,
							ost_organization.`name`
						FROM
							ost_ticket AS t
						INNER JOIN ost_staff AS g ON t.staff_id = g.staff_id
						INNER JOIN ost_user ON ost_user.id = t.user_id
						INNER JOIN ost_ticket_status ON t.status_id = ost_ticket_status.id
						INNER JOIN ost_ticket__cdata ON t.ticket_id = ost_ticket__cdata.ticket_id
						INNER JOIN ost_organization ON ost_organization.id = ost_user.org_id
						WHERE ost_user.`name` <> 'Prueba'
						order by t.created desc");*/
						
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
							tbldocumentcontent.orgFileName,
							tbldocumentcontent.fileType
						FROM
							tbldocuments AS x
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 1) AS t ON x.id = t.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 2) AS k ON x.id = k.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 3) AS m ON x.id = m.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 4) AS n ON x.id = n.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 5) AS p ON x.id = p.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 6) AS q ON x.id = q.document
							INNER JOIN tbldocumentcontent ON tbldocumentcontent.document = x.id
						WHERE
							x.`name`='Contratos'
						ORDER BY
							`ID DEL DOCUMENTO` Desc
							");
							
							/*<td>
									<p align="center">
										<a accesskey="" href="archivos/iieg/contratos/2017/001MarthaIdaliaFuentesSanchezTESTADO.pdf" target="_blank"
											onMouseover="window.status='Descargar documento'; return true;"
											onMouseout="window.status='';return true;">
											<img src="img//adobe01.jpg" border="0" alt="Descargar documento">
										</a>
											<br/>
										001/2016  	
											<br/>
											<br/>
											<br/>
									</p> 
							</td>*/

//consulta con asignado por

	//Ciclo que recorre toda la informaci&oacute;n
	while($info=@mysql_fetch_array($query))
	{
?>

	<tr bgcolor="#FFFFFF" class="textoceldas">
	
	<!--Para la consulta de los pdf-->
	<!--<a rel="<?php //$info[0]?>" draggable="true" ondragstart="onDragStartDocument(event);" href="../../op/op.Download.php?documentid=<?php //$info[0]?>&amp;version=1"><img draggable="false" class="mimeicon" src="../../views/bootstrap/images/pdf.png" title="application/pdf"></a>-->
	
	<!--<td width="57" class="Estilo1" bgcolor="CCCCCC"><div align="center" class="Estilo18"><?php //echo $info[0];?></div></td>-->
	
	<!--en esta línea se agrega el ícono del pdf para que sea posoble descargar según la consulta del documento que se guardo en l
	BD, recordando que no se almacena como tal el archivo el BLOB, sino que lo hace en una carpeta del servidor-->
	
	<!--<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><br/><a rel="<?php echo $info[3];?>" draggable="true" ondragstart="onDragStartDocument(event);" href="../../op/op.Download.php?documentid=<?php echo $info[3];?>&amp;version=1"><img draggable="false" class="mimeicon" src="../../views/bootstrap/images/pdf.png" title="Ver documento"></a><br/><?php echo $info[3];?> </div></td>-->
	
	

    
	
	<?php $pdf=".pdf"?>
	<?php $xls=".xls"?>
	<?php $xlsx=".xlsx"?>
	<?php $doc=".doc"?>
	<?php $docx=".docx"?>
	<?php $ppt=".ppt"?>
	<?php $pptx=".pptx"?>
	<?php $txt=".txt"?>
	
	
<!--EL BUENO-->
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><br/><a accesskey="" href="../../data/1048576/<?php echo $info[0];?>/<?php 
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
	?>" title="Ver documento"></a><br/><?php echo $info[3];?> </div></td>
	
	
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><?php echo $info[2];?></div></td>
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><?php echo $info[4];?></div></td>
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><?php echo $info[5];?></div></td>
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><?php echo $info[6];?></div></td>
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><?php echo $info[7];?></div></td>
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><?php echo $info[8];?></div></td>
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><?php echo $info[9];?></div></td>
	<td width="57" class="Estilo1" bgcolor="#D8D8D8"><div align="center" class="Estilo18"><?php echo $info[10];?></div></td>
  </tr>
  <?php
	}
?>
</tbody>
</table>

