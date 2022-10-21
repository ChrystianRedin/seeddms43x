<html>
<head>
    <title>Comité de transparencia</title>
	<link rel="icon" href="icono.png" type="image/x-icon"/>
    <meta charset="UTF-8"></metacharset>
    <link href="style.css" rel="stylesheet" type="text/css">
	<meta content="text/html; charset=UTF-8" http-equiv=Content-Type>
    <!---->
    <script language="javascript">
        function doSearch()
        {
            const tableReg = document.getElementById('datos');
            const searchText = document.getElementById('searchTerm').value.toLowerCase();
            let total = 0;
            // Recorremos todas las filas con contenido de la tabla
            for (let i = 1; i < tableReg.rows.length; i++) {
                // Si el td tiene la clase "noSearch" no se busca en su cntenido
                if (tableReg.rows[i].classList.contains("noSearch")) {
                    continue;
                }
                let found = false;
                const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
                // Recorremos todas las celdas
                for (let j = 0; j < cellsOfRow.length && !found; j++) {
                    const compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                    // Buscamos el texto en el contenido de la celda
                    if (searchText.length == 0 || compareWith.indexOf(searchText) > -1) {
                        found = true;
                        total++;
                    }
                }
                if (found) {
                    tableReg.rows[i].style.display = '';
                } else {
                    // si no ha encontrado ninguna coincidencia, esconde la fila de la tabla
                    tableReg.rows[i].style.display = 'none';
                }
            }
            // mostramos las coincidencias
            /*const lastTR=tableReg.rows[tableReg.rows.length-1];
            const td=lastTR.querySelector("td");
            lastTR.classList.remove("hide", "red");
            if (searchText == "") {
                lastTR.classList.add("hide");
            } else if (total) {
                td.innerHTML="Se ha encontrado "+total+" coincidencia"+((total>1)?"s":"");
            } else {
                lastTR.classList.add("red");
                td.innerHTML="No se han encontrado coincidencias";
            }*/
        }
    </script>
    <!---->

</head>

<body>
<table font-family: Arial, Helvetica, sans-serif; style="height: 21px; width: 100%; border-collapse: collapse; background-color: #7c878e;" border="0">
    <tbody>
    <tr>
    <td style="width: 100%; height: 21px; text-align: center;">
        <span><img src="logo.png"></span>
    <h3><span style="color: #ffffff;" class="texto-grande">  Comit&eacute; de transparencia del Instituto de Informaci&oacute;n Estad&iacute;stica y Geogr&aacute;fica de Jalisco</span></h3>
    </td>
    </tr>
    <tr>
    <td align="center" style="background-color: #BDCFD6;">
        <input class="input-icono" id="searchTerm" placeholder="Buscar..." type="text" onkeyup="doSearch()" />
    </td>
    </tr>
    </tbody>
</table>
<br><br>
<table class="comite" id="datos">
    <thead>
    <tr >
    <th align="center">Orden del día</th>
    <th>Fecha y hora de la sesión</th>
    <th>Tipo de sesión</th>
    <th>Naturaleza de la sesión</th>
    <th>Documentos públicos para consulta</th>
    </tr>
    </thead>
    <?php
		//1. Consulta la BD
		$link = @mysql_connect("localhost", "root", "testIIEG2022") or die ("Error al conectar a la base de datos.");
		mysql_query("SET NAMES 'utf8'");
        @mysql_select_db("seedms_db", $link) or die ("Error al conectar a la base de datos.");
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
								tblDocuments.name = 'Comité de transparencia'
								/*and tblDocumentAttributes.attrdef=7*/
                                GROUP BY tblDocumentAttributes.document
                                order by tblDocuments.id desc
        "); 						

    ?>

    
    
    
     
    <?php  //Ciclo que recorre toda la informaci&oacute;n
	while($info=@mysql_fetch_array($query))
	{
	?>
    <tr>
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
    <td valign="center" align="center"><a accesskey="" href="../../../../data/1048576/<?php echo $info[2];?>/<?php 
		if($pdf==$info[8]) {echo "1.pdf";} 
		elseif($xls==$info[8]) {echo "1.xls";} 
		elseif($xlsx==$info[8]) {echo "1.xlsx";} 
		elseif($doc==$info[8]) {echo "1.doc";}  
		elseif($docx==$info[8]) {echo "1.docx";} 
		elseif($ppt==$info[8]) {echo "1.ppt";} 
		elseif($pptx==$info[8]) {echo "1.pptx";} 
		elseif($txt==$info[8]) {echo "1.txt";}	
    ?>" target="_blank" onMouseover="window.status='Descargar documento'; return true;" onMouseout="window.status='';return true;"><img draggable="false" class="mimeicon" src="<?php 
			 if($pdf==$info[8]) {echo "pdf10.png";} 
		elseif($xls==$info[8]) {echo "excel3.ico";} 
		elseif($xlsx==$info[8]) {echo "excel3.ico";} 
		elseif($doc==$info[8]) {echo "word.ico";} 
		elseif($docx==$info[8]) {echo "word.ico";} 
		elseif($ppt==$info[8]) {echo "powerpoint.ico";} 
		elseif($pptx==$info[8]) {echo "powerpoint.ico";}  
		elseif($txt==$info[8]) {echo "pdf10.png";} 	
		?>" title="Ver documento"></a><br/><?php echo "<br/>";?>
	</td>
    <?php //FECHA Y HORA DE LA SESIÓN?>
	<td> <?php echo "<b>".$info[4]."</b>";?></td> 
	
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
                                tblDocuments.name = 'Comité de transparencia'
                                and tblDocumentAttributes.attrdef=7	
                                /*and tblDocumentFiles.`name` like '%consulta%'*/
                                order by tblDocuments.id desc
														
									
								"); 		
													
		?>    
    <td>
			
			<?php 
			 //Ciclo que recorre toda la informaci&oacute;n 
			while($info2=@mysql_fetch_array($query2))
			{
			?>
			
				
				<!--<td align="center"><?php //echo $info2[9];?></td>-->
	     		 			
				
					<!--<?php //if ($info[2] == $info2[2] and $info2[11] != ""){ echo "<li>".$info2[7]."";}  else {echo "";}?></a> -->
					<?php if (is_null($info2[10])){echo "";} elseif ($info[2] == $info2[2]) {?> <a style="text-decoration:none" accesskey="" href="../../../../data/1048576/<?php echo $info2[2];?>/<?php if ($info2[11]="Documentos públicos para consulta") echo "f".$info2[10]; else echo $info2[10];?><?php echo $info2[8];?>" target="_blank" >	 <?php echo "<li>".$info2[9]."";}?></a> 
					 
			
				<?php
				}
				?>
       
    </td>
    </tr>
    
    <?php
    } ?>
    </table>
</body>

</html>