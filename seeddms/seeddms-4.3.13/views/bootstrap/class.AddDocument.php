<?php
/**
 * Implementation of AddDocument view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("class.Bootstrap.php");

/**
 * Class which outputs the html page for AddDocument view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal, 
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_AddDocument extends SeedDMS_Bootstrap_Style {

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$folder = $this->params['folder'];
		$enablelargefileupload = $this->params['enablelargefileupload'];
		$enableadminrevapp = $this->params['enableadminrevapp'];
		$enableownerrevapp = $this->params['enableownerrevapp'];
		$enableselfrevapp = $this->params['enableselfrevapp']; 
		$strictformcheck = $this->params['strictformcheck'];
		$dropfolderdir = $this->params['dropfolderdir'];
		$workflowmode = $this->params['workflowmode'];
		$folderid = $folder->getId();

		$this->htmlStartPage(getMLText("folder_title", array("foldername" => htmlspecialchars($folder->getName()))));
		$this->globalNavigation($folder);
		$this->contentStart();
		$this->pageNavigation($this->getFolderPathHTML($folder, true), "view_folder", $folder);
		
?>

<script language="JavaScript">
function checkForm()
	{
	msg = new Array();
	//if (document.form1.userfile[].value == "") msg += "<?php printMLText("js_no_file");?>\n";
			
<?php
			if ($strictformcheck) {
?>
	if(!document.form1.name.disabled){
		if (document.form1.name.value == "") msg.push("<?php printMLText("js_no_name");?>");
	}
	if (document.form1.comment.value == "") msg.push("<?php printMLText("js_no_comment");?>");
	if (document.form1.keywords.value == "") msg.push("<?php printMLText("js_no_keywords");?>");
<?php
			}
?>
	if (msg != ""){
  	noty({
  		text: msg.join('<br />'),
  		type: 'error',
      dismissQueue: true,
  		layout: 'topRight',
  		theme: 'defaultTheme',
			_timeout: 1500,
  	});
		return false;
	}
	return true;
}

$(document).ready(function() {
	$('#new-file').click(function(event) {
			$("#upload-file").clone().appendTo("#upload-files").removeAttr("id").children('div').children('input').val('');
	});
});




/* } */
		
</script>



	<script language="JavaScript">		

	</script>
	
	<script type="text/javascript">
			function ocultarseque()
					{
						document.getElementById('seque').style.display = 'none';					
					}	
	</script>
	
	<script type="text/javascript">
			function mostrarCC()
					{
						document.getElementById('nCC').style.display = 'block';	
						document.getElementById('nJG').style.display = 'none';
						document.getElementById('nRes').style.display = 'none';						
						document.getElementById('nEstados').style.display = 'none';
						document.getElementById('nCT').style.display = 'none';						
						document.getElementById('nCCONS').style.display = 'none';				
										
					}	
	</script>			

	<script type="text/javascript">	

		function mostrarJG()
					{
						document.getElementById('nCC').style.display = 'none';	
						document.getElementById('nJG').style.display = 'block';	
						document.getElementById('nRes').style.display = 'none';	
						document.getElementById('nEstados').style.display = 'none';
						document.getElementById('nCT').style.display = 'none';	
						document.getElementById('nCCONS').style.display = 'none';
						
						
					}		
					</script>
					
	<script type="text/javascript">
		function mostrarRes()
					{
						document.getElementById('nCC').style.display = 'none';
						document.getElementById('nJG').style.display = 'none';	
						document.getElementById('nRes').style.display = 'block';							
						document.getElementById('nEstados').style.display = 'none';
						document.getElementById('nCT').style.display = 'none';							
						document.getElementById('nCCONS').style.display = 'none';	
						
					}	
	</script>
	
						
	<script type="text/javascript">
		function mostrarEdos()
					{
						document.getElementById('nCC').style.display = 'none';
						document.getElementById('nJG').style.display = 'none';	
						document.getElementById('nRes').style.display = 'none';							
						document.getElementById('nEstados').style.display = 'block';
						document.getElementById('nCT').style.display = 'none';		
						document.getElementById('nCCONS').style.display = 'none';	
												
						
					}	
	</script>
	
<script type="text/javascript">
		function mostrarComTrans()
					{
						document.getElementById('nCC').style.display = 'none';
						document.getElementById('nJG').style.display = 'none';	
						document.getElementById('nRes').style.display = 'none';							
						document.getElementById('nEstados').style.display = 'none';
						document.getElementById('nCT').style.display = 'block';							
						document.getElementById('nCCONS').style.display = 'none';	
						
					}	
	</script>
	
<script type="text/javascript">
		function mostrarConsCons() 
					{
						document.getElementById('nCC').style.display = 'none';
						document.getElementById('nJG').style.display = 'none';	
						document.getElementById('nRes').style.display = 'none';							
						document.getElementById('nEstados').style.display = 'none';
						document.getElementById('nCT').style.display = 'none';							
						document.getElementById('nCCONS').style.display = 'block';	
						
					}	
	</script>
	
	<script type="text/javascript">
		function formReset()
		{
			document.getElementById("form1").reset();
		}
	</script>
	

	

	
	

<?php
		
		$this->contentHeading(getMLText("add_document"));
		$this->contentContainerStart();
		
		// Retrieve a list of all users and groups that have review / approve
		// privileges.
		$docAccess = $folder->getReadAccessList($enableadminrevapp, $enableownerrevapp);
		

		
		
		
?>
		<form action="../op/op.AddDocument.php" enctype="multipart/form-data" method="post" name="form1" onsubmit="return checkForm();">
		<?php echo createHiddenFieldWithKey('adddocument'); ?>
		<input type="hidden" name="folderid" value="<?php print $folderid; ?>">
		<input type="hidden" name="showtree" value="<?php echo showtree();?>">
	
		
		<div>
		<div>
			<td><?php printMLText("link");?>:</td>
			<td>
				<br>
				<!--<select class="selectpicker" name="name" value="mostrar" >
					<option></option>
					<optgroup label="Documentos">		
					  <option value= "CC" name='name' onclick="mostrarCC()">Contratos / Convenios</option>					 
					</optgroup>
					<optgroup label="Reuniones">					
					  <option value= "JG" name='name' onclick="mostrarJG()">Junta de Gobierno</option>					 
					</optgroup>
					<optgroup label="Resoluciones">					
					  <option value="Res" name='name' onclick="mostrarRes()">Resoluciones del comité de transparencia</option>					  
					</optgroup>
				</select>		-->	
			</td>	
			<br/>
			<td><input class="btn btn-info" type="button" value= "  Contratos  |  Convenios  " onclick="mostrarCC()" ></td>			
			<td><input class="btn btn-info" type="button" value= "  <?php print "Junta de Gobierno  |  Consejo Consultivo  |  Comité de Transparencia";?>" onclick="mostrarJG()" ></td>			
			<!--<td><input class="btn btn-info" type="button" value= "  Resoluciones  " onclick="mostrarRes()"></td>-->
			<!--<td><input class="btn btn-info" type="button" value="   Estados financieros  " onclick="mostrarEdos()"></td>-->		  
			<!--<td><input class="btn btn-info" type="button" value="Comité de transparencia" onclick="mostrarComTrans()"></td>		
			<td><input class="btn btn-info" type="button" value="Consejo consultivo" onclick="mostrarConsCons()"></td>		--> 

			<br/>
		  </div>
							
			
			
		<!--ESTE BLOQUE DE CÓDIGO ES PARA CONTROLAR LOS CAMPOS QUE SE MUESTRAN SEGÚN LA SELECCIÓN DEL COMBO-->
		<!--ESTE BLOQUE ES PARA CONTRATOS Y CONVENIOS-->		
		<div id='nCC' style='display:none;'>	
		<br/>
		
	
		<table>
			<!--<select class="selectpicker" name="name" value="mostrar" >					
					<option></option>
					<optgroup label="Documentos">		
					  <option name='name'>Contratos</option>									
					  <option name='name'>Convenios</option>					 
					</optgroup>

				</select>-->
		
			<?php  
			$attrdefs = $dms->getAllAttributeDefinitions(array(SeedDMS_Core_AttributeDefinition::objtype_document, SeedDMS_Core_AttributeDefinition::objtype_document));
			if($attrdefs)  
			{					
				foreach($attrdefs as $attrdef) 
				{ 
					$IDS=htmlspecialchars($attrdef->getID()); 
					?> 		
					
					<tr>							
						  <?php switch ($IDS)
						  {
								case "1":?>		

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<!--<td ><?php //$this->printAttributeEditField($attrdef, '') ?></td>-->
									<td><?php echo "<input type=\"text\" name=\"attributes[1]\" value=\"".htmlspecialchars($objvalue)."\" / >" ;?></td>									
									<?php break; ?> 
						  <?php case "2":?>	

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<!--<td  ><?php //$this->printAttributeEditField($attrdef, '') ?></td>	-->
									<td><?php echo "<input type=\"text\" name=\"attributes[2]\" value=\"".htmlspecialchars($objvalue)."\" / >" ;?></td>	
									<?php break; ?>
						  <?php case "3":?>		

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<!--<td  ><?php //$this->printAttributeEditField($attrdef, '') ?></td>		-->
									<td><?php echo "<input type=\"text\" name=\"attributes[3]\" value=\"".htmlspecialchars($objvalue)."\" / >" ;?></td>										
									<?php break; ?>
						  <?php case "4":?>		

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<!--<td ><?php //$this->printAttributeEditField($attrdef, '')?></td>		 -->
									<td><?php echo "<input placeholder=\"0.00\" type=\"text\" onkeypress=\"return valida(event)\" name=\"attributes[4]\" value=\"".htmlspecialchars($objvalue)."\" / >";?></td>
									<!--<td><?php //echo "<input type=\"text\" name=\"attributes[4]\" value=\"".htmlspecialchars($objvalue)."\" / >";?></td>-->					
													<?php //echo "<input type=\"text\" onkeypress=\"return valida(event)\" name=\"attributes[4]\" value=\"".htmlspecialchars($objvalue)."\" / >";?>													
													
													<script>
														function valida(e){
															tecla = (document.all) ? e.keyCode : e.which;
															//Tecla de retroceso para borrar, siempre la permite
															if (tecla==8){
																return true;
															}																
															// Patron de entrada, en este caso solo acepta numeros
															patron =/[0-9]/;
															patron =/[0-9-.]/;
															//patron =/[0-9-,]/;
															tecla_final = String.fromCharCode(tecla);
															return patron.test(tecla_final);
														}
													</script>
									
									
									<?php break; ?>
						  <?php case "5":?>	

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<!--<td  ><?php //$this->printAttributeEditField($attrdef, '') ?></td>-->
									<td><?php echo "<input type=\"text\" name=\"attributes[5]\" value=\"".htmlspecialchars($objvalue)."\" / >" ;?></td>										
									<?php break; ?>
						 <?php case "6":?>	

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td> 
									<!--<td  ><?php //$this->printAttributeEditField($attrdef, '') ?></td>	-->
									<td><?php echo "<input type=\"text\" name=\"attributes[6]\" value=\"".htmlspecialchars($objvalue)."\" / >" ;?></td>	
									<?php break; ?>
						 <?php case "18":?>	

									<td  ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<!--<td  ><?php $this->printAttributeEditField($attrdef, '') ?></td>	-->
									<td><?php echo "<input type=\"text\" name=\"attributes[18]\" value=\"".htmlspecialchars($objvalue)."\" / >" ;?></td>	
									<?php 
						  }?>						
					</tr>					
				<?php 
				}
			}
			?>
			</table>
			</div>
			<!--TERMINA EL BLOQUE PARA CONTRATOS Y CONVENIOS-->	
			
			<!--ESTE BLOQUE ES PARA JUNTA DE GOBIERNO-->		
			<div id='nJG' style='display:none;'>	
			<br/>
			
			<table>
			<!--<select class="selectpicker" name="name" value="mostrar" >					
					<option></option>
					<optgroup label="Reuniones">		
					  <option name='name'>Junta de Gobierno</option>
					</optgroup>
				</select>		-->
			<tr>


			</tr>				
			<?php  
			$attrdefs = $dms->getAllAttributeDefinitions(array(SeedDMS_Core_AttributeDefinition::objtype_document, SeedDMS_Core_AttributeDefinition::objtype_document));
			if($attrdefs)  
			{					
				foreach($attrdefs as $attrdef) 
				{ 
					$IDS=htmlspecialchars($attrdef->getID()); 
					?> 					
					<tr>							
						  <?php switch ($IDS)
						  {
								case "7":?>		

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>

									<!--Sencillo a texto libre-->
									<td ><?php $this->printAttributeEditField($attrdef, '') ?>		
									<!--fecha con T-->
									<!--<td ><input id="datetime-local" type="datetime-local" <?php //$this->printAttributeEditField($attrdef, '') ?></td>
									<!----><!--EGDC seleccionar fecha con hora
									<td>
										<html>
										  <head>
											<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
											<link rel="stylesheet" type="text/css" media="screen"
											 href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
										  </head>
										  <body>
											<div id="datetimepicker" class="input-append date">
											  <input type="text"  <?php //$this->printAttributeEditField($attrdef, '') ?>></input>
											  <span class="add-on">
												<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
											  </span>
											</div>
											<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
											<script type="text/javascript" src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
											<script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
											<script type="text/javascript" src="http://iieg.gob.mx/seeddms-4.3.13/styles/bootstrap/bootstrap/js/es-MX.js"></script>
											<script type="text/javascript"> 
											  $('#datetimepicker').datetimepicker({
												format: 'dd/MM/yyyy hh:mm:ss',
												language: 'es-MX'
											  });
											</script>
										  </body>
										</html>	
									</td>-->
									<!---->
									
									<?php break; ?> 
						  <?php case "9":?>	 

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td  ><?php $this->printAttributeEditField($attrdef, '') ?></td>											
									<?php break; ?>
									
						  <?php case "10":?>
									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td  ><?php $this->printAttributeEditField($attrdef, '') ?></td>						
									<?php break; ?>
									
						  <!--<?php //case "10":?>		

									<td ><?php //echo htmlspecialchars($attrdef->getname()); ?></td>
									<td  ><?php //$this->printAttributeEditField($attrdef, '') ?></td>						
									<?php //break; ?>
						  <?php //case "11":?>		

									<td ><?php //echo htmlspecialchars($attrdef->getname()); ?></td>
									<td  ><?php //$this->printAttributeEditField($attrdef, '') ?></td>						
									<?php// break; ?>
						  <?php //case "12":?>	

									<td ><?php //echo htmlspecialchars($attrdef->getname()); ?></td>
									<td  ><?php //$this->printAttributeEditField($attrdef, '') ?></td>						
									<?php //break; ?>
						  <?php //case "13":?>	

									<td  ><?php //echo htmlspecialchars($attrdef->getname()); ?></td>
									<td  ><?php //$this->printAttributeEditField($attrdef, '') ?></td>	-->					
									<?php //break; 
									
						  }?>						
					</tr>					
				<?php
				}
			}
			?>
			</table>
			</div>
			
			<!--TERMINA EL BLOQUE PARA JUNTA DE GOBIERNO-->	
			
			<!--ESTE BLOQUE ES PARA RESOLUCIONES-->		
			<div id='nRes' style='display:none;'>	
			<br/>
			<!--<td><?php printMLText("type_of_document");?>:</td>
			<table>
			<select class="selectpicker" name="name" value="mostrar" >					
					<option></option>
					<optgroup label="Resoluciones">		
					  <option name='name'>Resoluciones del comité de transparencia</option>														 
					</optgroup>
			</select>-->
			<table>
			<?php  
			$attrdefs = $dms->getAllAttributeDefinitions(array(SeedDMS_Core_AttributeDefinition::objtype_document, SeedDMS_Core_AttributeDefinition::objtype_document));
			if($attrdefs)  
			{					
				foreach($attrdefs as $attrdef) 
				{ 
					$IDS=htmlspecialchars($attrdef->getID()); 
					?> 					
					<tr>							
						  <?php switch ($IDS)
						  {
								case "17":?>		
									<br>
									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td ><?php $this->printAttributeEditField($attrdef, '') ?></td>																				
									<?php break;  }?>						
					</tr>											
				<?php
				}
			}
			?>
			</table>
			</div>
			<!--TERMINA EL BLOQUE PARA RESOLUCIONES-->	
			
			<!--ESTE BLOQUE ES PARA ESTADOS FINANCIEROS-->		
			<div id='nEstados'  style='display:none;'>	
			<br/>
			<!--<td><?php printMLText("type_of_document");?>:</td>
			<table>
			<select class="selectpicker" name="name" value="mostrar" >					
					<option></option>
					<optgroup label="Resoluciones">		
					  <option name='name'>Resoluciones del comité de transparencia</option>														 
					</optgroup>
			</select>-->
			<table>
			<?php  
			$attrdefs = $dms->getAllAttributeDefinitions(array(SeedDMS_Core_AttributeDefinition::objtype_document, SeedDMS_Core_AttributeDefinition::objtype_document));
			if($attrdefs)  
			{					
				foreach($attrdefs as $attrdef) 
				{ 
					$IDS=htmlspecialchars($attrdef->getID()); 
					?> 					
					<tr>							
						  <?php switch ($IDS)
						  {
								case "20":?>		
									<br>
									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td ><?php $this->printAttributeEditField($attrdef, '') ?></td>																				
									<?php break;  ?>	
						<?php   case "21":?>	

									<td ><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td ><input id="date" type="date" <?php $this->printAttributeEditField($attrdef, '') ?></td>	
									
						  <?php break; }?>									
								
					</tr>						
				<?php
				}
			}
			?>
			</table>
			</div>
			<!--TERMINA EL BLOQUE PARA ESTADOS FINANCIEROS-->
					<br/>
					
					<tr>
					Seleccionar destino: <select class="selectpicker" name="name" value="mostrar" >					
					<option></option>
					<optgroup label="Contratos || Convenios">		
					  <option name='name'><?php $varContra = "Contratos";  echo $varContra;?></option>									
					  <option name='name'><?php $varConve = "Convenios";  echo $varConve;?></option>									
					  <!--<option name='name'>Convenios</option>-->
					</optgroup>
					<optgroup label="Junta de Gobierno || Consejo Consultivo || Comité de Transparencia">		
					  <option name='name'><?php $varJunta = "Junta de Gobierno";  echo $varJunta;?></option>
					  <option name='name'><?php $varConsejo = "Consejo Consultivo";  echo $varConsejo;?></option>
					  <option name='name'><?php $varComiteTranspaConvo = "Comité de transparencia";  echo $varComiteTranspaConvo;?></option>
					  <!--<option name='name'>Junta de Gobierno</option>-->
					</optgroup>
					<!--<optgroup label="Resoluciones">		
					  <option name='name'>Resoluciones del comité de transparencia</option>														 
					</optgroup>
					<optgroup label="Estados Financieros">		
					  <option name='name'>Estados Financieros</option>														 
					</optgroup>-->
					</select>
					</tr>
					<br/>
					<!--
					<tr><?php // EGCF se elimina el campo de TIPO?>
						<td><?php printMLText("comment");?>:</td>
						<td><textarea name="comment" rows="3" cols="80"></textarea></td>
					</tr>
					-->
			
	
			

			
			
		</div>
	
<!--AQUÍ TERMINA LA SECCIÓN DE MOSTRAR LOS CAMPOS SEGÚN LA SELECCIÓN-->	
			<br/>
		<tr>
			<td><?php printMLText("local_file");?>:</td>
			<td>
<!--
			<a href="javascript:addFiles()"><?php //printMLtext("add_multiple_files") ?></a>
			<ol id="files">
			<li><input type="file" name="userfile[]" size="60"></li>
			</ol>
-->
<?php
	$this->printFileChooser('userfile[]', false);
?>
			<a class="" id="new-file"><?php //printMLtext("add_multiple_files") ?></a>
			</td>
		</tr>
<?php if($dropfolderdir) { ?>
		<tr>
			<td><?php printMLText("dropfolder_file");?>:</td>
			<td><?php $this->printDropFolderChooser("form1");?></td>
		</tr>
<?php } ?>

<?php
			$attrdefs = $dms->getAllAttributeDefinitions(array(SeedDMS_Core_AttributeDefinition::objtype_documentcontent, SeedDMS_Core_AttributeDefinition::objtype_all));
			if($attrdefs) {
				foreach($attrdefs as $attrdef) {
?>
		<tr>
			<td><?php echo htmlspecialchars($attrdef->getName()); ?></td>
			<td><?php $this->printAttributeEditField($attrdef, '', 'attributes_version') ?></td>
		</tr>
<?php
				}
			}
		if($workflowmode != 'traditional') {
?>
		<tr>	

      <td>
<?php
				$mandatoryworkflow = $user->getMandatoryWorkflow();
				if($mandatoryworkflow) {
?>
				<?php echo $mandatoryworkflow->getName(); ?>
				<input type="hidden" name="workflow" value="<?php echo $mandatoryworkflow->getID(); ?>">
<?php
				} else {
?>

<?php
				}
?>
      </td>
    </tr>
		<tr>	
      <td colspan="2">
			<?php //$this->warningMsg(getMLText("add_doc_workflow_warning")); ?>
      </td>
		</tr>	
<?php
		} else {
?>
		<tr>
      <td>
		<?php $this->contentSubHeading(getMLText("assign_reviewers")); ?>
      </td>
		</tr>	
		<tr>	
      <td>
			<div class="cbSelectTitle"><?php printMLText("individuals");?>:</div>
      </td>
      <td>
<?php
				$res=$user->getMandatoryReviewers();
?>
        <select class="chzn-select span9" name="indReviewers[]" multiple="multiple" data-placeholder="<?php printMLText('select_ind_reviewers'); ?>">
<?php
				foreach ($docAccess["users"] as $usr) {
					if (!$enableselfrevapp && $usr->getID()==$user->getID()) continue; 
					$mandatory=false;
					foreach ($res as $r) if ($r['reviewerUserID']==$usr->getID()) $mandatory=true;

					if ($mandatory) print "<option disabled=\"disabled\" value=\"".$usr->getID()."\">". htmlspecialchars($usr->getLogin()." - ".$usr->getFullName())."</option>";
					else print "<option value=\"".$usr->getID()."\">". htmlspecialchars($usr->getLogin()." - ".$usr->getFullName())."</option>";
				}
?>
        </select>
<?php
				/* List all mandatory reviewers */
				if($res) {
					$tmp = array();
					foreach ($res as $r) {
						if($r['reviewerUserID'] > 0) {
							$u = $dms->getUser($r['reviewerUserID']);
							$tmp[] =  htmlspecialchars($u->getFullName().' ('.$u->getLogin().')');
						}
					}
					if($tmp) {
						echo '<div class="mandatories"><span>'.getMLText('mandatory_reviewers').':</span> ';
						echo implode(', ', $tmp);
						echo "</div>\n";
					}
				}

				/* Check for mandatory reviewer without access */
				foreach($res as $r) {
					if($r['reviewerUserID']) {
						$hasAccess = false;
						foreach ($docAccess["users"] as $usr) {
							if ($r['reviewerUserID']==$usr->getID())
								$hasAccess = true;
						}
						if(!$hasAccess) {
							$noAccessUser = $dms->getUser($r['reviewerUserID']);
							echo "<div class=\"alert alert-warning\">".getMLText("mandatory_reviewer_no_access", array('user'=>htmlspecialchars($noAccessUser->getFullName()." (".$noAccessUser->getLogin().")")))."</div>";
						}
					}
				}
?>
      </td>
      </tr>
      <tr>
        <td>
			<div class="cbSelectTitle"><?php printMLText("groups");?>:</div>
        </td>
        <td>
        <select class="chzn-select span9" name="grpReviewers[]" multiple="multiple" data-placeholder="<?php printMLText('select_grp_reviewers'); ?>">
<?php
			foreach ($docAccess["groups"] as $grp) {
			
				$mandatory=false;
				foreach ($res as $r) if ($r['reviewerGroupID']==$grp->getID()) $mandatory=true;	

				if ($mandatory) print "<option value=\"".$grp->getID()."\" disabled=\"disabled\">".htmlspecialchars($grp->getName())."</option>";
				else print "<option value=\"".$grp->getID()."\">".htmlspecialchars($grp->getName())."</option>";
			}
?>
			</select>
<?php
				/* List all mandatory groups of reviewers */
				if($res) {
					$tmp = array();
					foreach ($res as $r) {
						if($r['reviewerGroupID'] > 0) {
							$u = $dms->getGroup($r['reviewerGroupID']);
							$tmp[] =  htmlspecialchars($u->getName());
						}
					}
					if($tmp) {
						echo '<div class="mandatories"><span>'.getMLText('mandatory_reviewergroups').':</span> ';
						echo implode(', ', $tmp);
						echo "</div>\n";
					}
				}
				/* Check for mandatory reviewer group without access */
				foreach($res as $r) {
					if ($r['reviewerGroupID']) {
						$hasAccess = false;
						foreach ($docAccess["groups"] as $grp) {
							if ($r['reviewerGroupID']==$grp->getID())
								$hasAccess = true;
						}
						if(!$hasAccess) {
							$noAccessGroup = $dms->getGroup($r['reviewerGroupID']);
							echo "<div class=\"alert alert-warning\">".getMLText("mandatory_reviewergroup_no_access", array('group'=>htmlspecialchars($noAccessGroup->getName())))."</div>";
						}
					}
				}
?>
			</td>
			</tr>
			
		  <tr>	
        <td>
		<?php $this->contentSubHeading(getMLText("assign_approvers")); ?>
        </td>
		  </tr>	
		
		  <tr>	
        <td>
			<div class="cbSelectTitle"><?php printMLText("individuals");?>:</div>
        </td>
				<td>
      <select class="chzn-select span9" name="indApprovers[]" multiple="multiple" data-placeholder="<?php printMLText('select_ind_approvers'); ?>">
<?php
			$res=$user->getMandatoryApprovers();
			foreach ($docAccess["users"] as $usr) {
				if (!$enableselfrevapp && $usr->getID()==$user->getID()) continue; 

				$mandatory=false;
				foreach ($res as $r) if ($r['approverUserID']==$usr->getID()) $mandatory=true;
				
				if ($mandatory) print "<option value=\"". $usr->getID() ."\" disabled='disabled'>". htmlspecialchars($usr->getFullName())."</option>";
				else print "<option value=\"". $usr->getID() ."\">". htmlspecialchars($usr->getLogin()." - ".$usr->getFullName())."</option>";
			}
?>
			</select>
<?php
				/* List all mandatory approvers */
				if($res) {
					$tmp = array();
					foreach ($res as $r) {
						if($r['approverUserID'] > 0) {
							$u = $dms->getUser($r['approverUserID']);
							$tmp[] =  htmlspecialchars($u->getFullName().' ('.$u->getLogin().')');
						}
					}
					if($tmp) {
						echo '<div class="mandatories"><span>'.getMLText('mandatory_approvers').':</span> ';
						echo implode(', ', $tmp);
						echo "</div>\n";
					}
				}

				/* Check for mandatory approvers without access */
				foreach($res as $r) {
					if($r['approverUserID']) {
						$hasAccess = false;
						foreach ($docAccess["users"] as $usr) {
							if ($r['approverUserID']==$usr->getID())
								$hasAccess = true;
						}
						if(!$hasAccess) {
							$noAccessUser = $dms->getUser($r['approverUserID']);
							echo "<div class=\"alert alert-warning\">".getMLText("mandatory_approver_no_access", array('user'=>htmlspecialchars($noAccessUser->getFullName()." (".$noAccessUser->getLogin().")")))."</div>";
						}
					}
				}
?>
				</td>
		  </tr>	
		  <tr>	
        <td>
			<div class="cbSelectTitle"><?php printMLText("groups");?>:</div>
        </td>
        <td>
      <select class="chzn-select span9" name="grpApprovers[]" multiple="multiple" data-placeholder="<?php printMLText('select_grp_approvers'); ?>">
<?php
			foreach ($docAccess["groups"] as $grp) {
			
				$mandatory=false;
				foreach ($res as $r) if ($r['approverGroupID']==$grp->getID()) $mandatory=true;	

				if ($mandatory) print "<option value=\"". $grp->getID() ."\" disabled=\"disabled\">".htmlspecialchars($grp->getName())."</option>";
				else print "<option value=\"". $grp->getID() ."\">".htmlspecialchars($grp->getName())."</option>";

			}
?>
			</select>
<?php
				/* List all mandatory groups of approvers */
				if($res) {
					$tmp = array();
					foreach ($res as $r) {
						if($r['approverGroupID'] > 0) {
							$u = $dms->getGroup($r['approverGroupID']);
							$tmp[] =  htmlspecialchars($u->getName());
						}
					}
					if($tmp) {
						echo '<div class="mandatories"><span>'.getMLText('mandatory_approvergroups').':</span> ';
						echo implode(', ', $tmp);
						echo "</div>\n";
					}
				}

				/* Check for mandatory approver groups without access */
				foreach($res as $r) {
					if ($r['approverGroupID']) {
						$hasAccess = false;
						foreach ($docAccess["groups"] as $grp) {
							if ($r['approverGroupID']==$grp->getID())
								$hasAccess = true;
						}
						if(!$hasAccess) {
							$noAccessGroup = $dms->getGroup($r['approverGroupID']);
							echo "<div class=\"alert alert-warning\">".getMLText("mandatory_approvergroup_no_access", array('group'=>htmlspecialchars($noAccessGroup->getName())))."</div>";
						}
					}
				}
?>
				</td>
		  </tr>	
		  <tr>	
        <td colspan="2">
			<div class="alert"><?php printMLText("add_doc_reviewer_approver_warning")?></div>
        </td>
		  </tr>	
<?php
		}
?>

<div id='seque' style='display:none;'>
		<tr>
			<td><?php printMLText("sequence");?>:</td>
			<td><?php $this->printSequenceChooser($folder->getDocuments('s'));?></td>
		</tr>
</div>

		

			<p><input type="submit" class="btn btn-success" value="<?php printMLText("add_document");?>">
			<input type="button" class="btn btn-danger" value="<?php echo ("Cancelar");?>" onclick="document.location.reload();"></p>
			
		</form>
		
		
		
<?php
		$this->contentContainerEnd();
		$this->htmlEndPage();

	} /* }}} */
}
?>
