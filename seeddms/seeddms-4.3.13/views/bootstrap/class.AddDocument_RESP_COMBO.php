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






</script>

<?php
		//$msg = getMLText("max_upload_size").": ".ini_get( "upload_max_filesize");
		//if($enablelargefileupload) {
			//$msg .= "<p>".sprintf(getMLText('link_alt_updatedocument'), "out.AddMultiDocument.php?folderid=".$folderid."&showtree=".showtree())."</p>";
		//}
		//$this->warningMsg($msg);
		$this->contentHeading(getMLText("add_document"));
		$this->contentContainerStart();
		
		// Retrieve a list of all users and groups that have review / approve
		// privileges.
		$docAccess = $folder->getReadAccessList($enableadminrevapp, $enableownerrevapp);
		
		$this->contentSubHeading(getMLText("document_indications2"));
		$this->contentSubHeading(getMLText("document_infos1"));
		$this->contentSubHeading(getMLText("document_infos2"));
		$this->contentSubHeading(getMLText("document_infos3"));
		
		
		
?>
		<form action="../op/op.AddDocument.php" enctype="multipart/form-data" method="post" name="form1" onsubmit="return checkForm();">
		<?php echo createHiddenFieldWithKey('adddocument'); ?>
		<input type="hidden" name="folderid" value="<?php print $folderid; ?>">
		<input type="hidden" name="showtree" value="<?php echo showtree();?>">
		<hr color="gray" size=3>
		<table class="table-condensed">
		<tr>
			<td><?php printMLText("name");?>:</td>
			<td>			
				<select class="selectpicker" name="name" onChange="registroOnChange(this)">
					<option name='name'></option>
					<optgroup label="Documentos">		
					  <option value= "CC" name='name'>Contratos</option>
					  <option value= "CC" name='name'>Convenios</option>	
					</optgroup>
					<optgroup label="Reuniones">					
					  <option name='name'>Junta de Gobierno</option>
					  <option name='name'>Consejo consultivo</option>	
					</optgroup>
					<optgroup label="Resoluciones">					
					  <option name='name'>Resoluciones del comité de transparencia</option>
					  
					</optgroup>
				</select>			
			</td>
		</tr> 		
		<tr >
			<td><?php printMLText("comment");?>:</td>
			<td><textarea name="comment" rows="3" cols="80"></textarea></td>
			
		</tr>
		
		
		
	<!--ESTA SECCIÓN DE CÓDIGO SE UTILIZA PARA MOSTRAR LOS CAMPOS SEGÚN LA SELECCIÓN-->	
	<div>
	  <!--El div para el select-->
      <div>
           <p>Selecciona el tipo de documento:</p>
		   <SELECT style="width:310px" NAME="registro" onChange="registroOnChange(this)">
              <OPTION name='name'></OPTION>
			  <optgroup label="Documentos">	
			  <OPTION VALUE="CC">Contratos</OPTION>
			  <OPTION VALUE="CC">Covenios</OPTION>
			  </optgroup>	
			  <optgroup label="Junta de Gobierno">	
              <OPTION VALUE="JG">Junta de Gobierno</OPTION> 
			  </optgroup>	
			  <optgroup label="Resoluciones">	
			  <OPTION VALUE="Res">Resoluciones del comité de transparencia</OPTION>
			  </optgroup>	
           </SELECT>
      </div>
	  
	  <!--El div para CONTRATOS Y CONVENIOS-->
	  <div id="nCC" style="display:none;">
           <br>
		   Número*
           <br>
           <input type='text' name='nNum'size='20' maxLength='60'>
           <br>
		   Tipo
           <br>
           <input type='text' name='nTipo'size='20' maxLength='60'>
           <br>
		   Nombre de la Persona física o jurídica
           <br>
           <input type='text' name='nNombre'size='20' maxLength='60'>
           <br>
		   Monto
           <br>
           <input type='text' name='nMonto'size='20' maxLength='60'>
           <br>
		   Acciones a realizar
           <br>
           <input type='text' name='nAcciones'size='20' maxLength='60'>
           <br>
		   Proyecto o partida
           <br>
           <input type='text' name='nProyecto'size='20' maxLength='60'>
           <br>
		   Vigencia
           <br>
           <input type='text' name='nVigencia'size='20' maxLength='60'>
           <br>
      </div>
	  
	  <!--El div para JUNTA DE GOBIERNO-->
      <div id="nJG" style="display:none;">
           <br>
           Fecha y hora de sesión*
           <br>
           <input type='text' name='nFecha'size='20' maxLength='60'>
           <br><br>
           Orden del día*
           <br>
           <input type='text' name='nOrden'size='20' maxLength='60'>
           <br><br>
           Tipo de sesión*
		   <br>
           <input type='text' name='nTipoSesion'size='3' maxLength='3'>
		   <br>
           Naturaleza de la sesión*
           <br>
           <input type='text' name='nNaturaleza'size='20' maxLength='60'>
           <br>
		   <br>
           Documentos públicos para consulta previa*
           <br>
           <input type='text' name='nDoctos'size='20' maxLength='60'>
           <br>
		   <br>
           Acta de sesión*
           <br>
           <input type='text' name='nActa'size='20' maxLength='60'>
           <br>
      </div>
	  
	  <!--El div para RESOLUCIONES DEL COMITE DE TRANSPARENCIA-->
	  <div id="nRes" style="display:none;">
           <br>
		   N° de expediente interno*
           <br>
           <input type='text' name='nNum'size='20' maxLength='60'>          
      </div>
	  
	</div>
		<!---->
		
	<script language="JavaScript">		
		function registroOnChange(sel) {
			  if (sel.value=="CC"){
				   divC = document.getElementById("nCC");
				   divC.style.display = "";

				   divT = document.getElementById("nJG");
				   divT.style.display = "none";
				   
				   divT = document.getElementById("nRes");
				   divT.style.display = "none";

			  }else if (sel.value=="JG"){
				   divC = document.getElementById("nCC");
				   divC.style.display="none";

				   divT = document.getElementById("nJG");
				   divT.style.display = "";
				   
				   divT = document.getElementById("nRes");
				   divT.style.display = "none";
				   
			  }else if (sel.value=="Res"){
				   divC = document.getElementById("nCC");
				   divC.style.display="none";

				   divT = document.getElementById("nJG");
				   divT.style.display = "none";
				   
				   divT = document.getElementById("nRes");
				   divT.style.display = "";
			}
		}
	</script>
<hr color="gray" size=3>

<!--AQUÍ TERMINA LA SECCIÓN DE MOSTRAR LOS CAMPOS SEGÚN LA SELECCIÓN-->	
			<div id="nCC" style="display:none;">
			<?php
			$attrdefs = $dms->getAllAttributeDefinitions(array(SeedDMS_Core_AttributeDefinition::objtype_document, SeedDMS_Core_AttributeDefinition::objtype_document));
			if($attrdefs) 
			{					
				$i=0;
				foreach($attrdefs as $attrdef) 
				{ 
					$IDS=htmlspecialchars($attrdef->getID()); 
					?>
					<tr>			
						  <?php switch ($IDS)
						  {
								case "1":?>						
									<td id= "nCC" style="display:none;"><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td id= "nCC" style="display:none;"><?php $this->printAttributeEditField($attrdef, '') ?></td>
									<?php break; ?>
						  <?php case "2":?>						
									<td style="display:none;"><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td style="display:none;"><?php $this->printAttributeEditField($attrdef, '') ?></td>
									<?php break; ?>
						  <?php case "3":?>						
									<td style="display:none;"><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td style="display:none;"><?php $this->printAttributeEditField($attrdef, '') ?></td>
									<?php break; ?>
						  <?php case "4":?>						
									<td style="display:none;"><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td style="display:none;"><?php $this->printAttributeEditField($attrdef, '') ?></td>
									<?php break; ?>
						  <?php case "5":?>						
									<td style="display:none;"><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td style="display:none;"><?php $this->printAttributeEditField($attrdef, '') ?></td>
									<?php break; ?>
						  <?php case "6":?>						
									<td style="display:none;"><?php echo htmlspecialchars($attrdef->getname()); ?></td>
									<td style="display:none;"><?php $this->printAttributeEditField($attrdef, '') ?></td>
									<?php break; 
						  }?>							
						<td><?php //echo htmlspecialchars($attrdef->getID()); ?></td> 
						<td><?php //$this->printAttributeEditField($attrdef, '') ?></td>
					
					</tr>
				<?php
				}
			}
			?>
			</div>
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
		<tr>
			<td ><?php printMLText("sequence");?>:</td>
			<td><?php $this->printSequenceChooser($folder->getDocuments('s'));?></td>
		</tr>

		</table>

			<p><input type="submit" class="btn" value="<?php printMLText("add_document");?>"></p>
		</form>
<?php
		$this->contentContainerEnd();
		$this->htmlEndPage();

	} /* }}} */
}
?>
