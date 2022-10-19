			<div id='nRes' style='display:none;'>	
			<br/>
			<td><?php printMLText("name");?>:</td>
			<table>
			<select class="selectpicker" name="name" value="mostrar" >					
					<option></option>
					<optgroup label="Resoluciones">		
					  <option name='name'>Resoluciones del comité de transparencia</option>			
					</optgroup>
			</select>
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