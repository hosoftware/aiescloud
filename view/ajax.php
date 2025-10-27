<?php
include_once "control/report.class.php";
if(!empty($_REQUEST['doAction'])) {
			switch($_REQUEST['doAction']) {
				case'SELECTSUBCAT':
					
					$cat_id = $_REQUEST['cat_id'];
					$rslt = $report->getSubCategoryNameList($cat_id);
					$str = '<select name="txtSubCat" id="txtSubCat"  class="txtfield"><option value=""> -- Select Subcategory-- </option>';
						while($row = $report->objCommonFunc->fetchAssoc($rslt)) {
							$str .='<option value="'.$row['subcat_id'].'"';
							if(!empty($_REQUEST['txtSubCat']) && $_REQUEST['txtSubCat'] == $row['subcat_id']) { $str .=" selected";}
							$str .= '>'.$row['subcat_name'].'</option>';
						}
					$str .= '</select>';
					print($str);
					break;
				case"SELECTRIG":
					
					$client_id = $_REQUEST['client_id'];
					$rslt = $report->getRigNameList($client_id);
					$str = '<select name="txtRig" id="txtRig"  class="txtfield"><option value=""> -- Select Rig-- </option>';
						while($row = $report->objCommonFunc->fetchAssoc($rslt)) {
							$str .='<option value="'.$row['rig_id'].'"';
							if(!empty($_REQUEST['txtRig']) && $_REQUEST['txtRig'] == $row['rig_id']) { $str .=" selected";}
							$str .= '>'.$row['rig_name'].'</option>';
						}
					$str .= '</select>';
					print($str);
					break;
			}
}

?>