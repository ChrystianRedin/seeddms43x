


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

</br>

<?php



/*
  $link = @mysql_connect("localhost", "iieggob_gdd","^~ozW]zTzuMD")
      or die ("Error al conectar a la base de datos.");
  @mysql_select_db("iieggob_soporte", $link)
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
$(document).ready(function() 
    { 
        $("#ExportarExcel").tablesorter(); 
    } 
); 
</script>

<table width="900" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF" id="ExportarExcel" class="ExportarExcel">

<!--para establecer como invisible una tabla se utiliza el tag: style="display: none"-->

  <thead>
	  <tr class="encabezado">
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 100px;">No. de Contrato</div></td>
	  <!--<td bgcolor="770000"><div align="center" class="Estilo16">ID_Agente</div></td>-->
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 150px;">Tipo de Contrato</div></td>
	  <td bgcolor="770000"><div align="center" class="Estilo16" style="width: 100px;">Nombre de la Persona f&iacute;sica o jur&iacute;dica</div></td>
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
							x.`name` as `Tipo de Contrato`,
							t.value as `Nombre de la persona física o jurídica`,
							k.value Monto,
							m.value`Acciones a realizar`,
							n.value`Proyecto o partida`,
							p.value Vigencia
						FROM 
							tbldocuments AS x
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 1) AS t ON x.id = t.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 2) AS k ON x.id = k.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 3) AS m ON x.id = m.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 4) AS n ON x.id = n.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 5) AS p ON x.id = p.document
							LEFT JOIN ( SELECT * FROM tbldocumentattributes WHERE attrdef = 6) AS q ON x.id = q.document
						WHERE
							x.`name`='Contratos'
							ORDER BY
							`ID DEL DOCUMENTO` ASC
							");
							

//consulta con asignado por

	//Ciclo que recorre toda la informaci&oacute;n
	while($info=@mysql_fetch_array($query))
	{
?>

	<tr bgcolor="#FFFFFF" class="textoceldas">
	<td width="57" class="Estilo1" bgcolor="CCCCCC"><div align="center" class="Estilo18"><?php echo $info[0];?></div></td>
	<td width="57" class="Estilo1" bgcolor="CCCCCC"><div align="center" class="Estilo18"><?php echo $info[1];?></div></td>
	<td width="57" class="Estilo1" bgcolor="CCCCCC"><div align="center" class="Estilo18"><?php echo $info[2];?></div></td>
	<td width="57" class="Estilo1" bgcolor="CCCCCC"><div align="center" class="Estilo18"><?php echo $info[3];?></div></td>
	<td width="57" class="Estilo1" bgcolor="CCCCCC"><div align="center" class="Estilo18"><?php echo $info[4];?></div></td>
	<td width="57" class="Estilo1" bgcolor="CCCCCC"><div align="center" class="Estilo18"><?php echo $info[5];?></div></td>
	<td width="57" class="Estilo1" bgcolor="CCCCCC"><div align="center" class="Estilo18"><?php echo $info[6];?></div></td>
  </tr>
  <?php
	}
?>
</tbody>
</table>

