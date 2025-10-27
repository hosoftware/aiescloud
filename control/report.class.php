<?php
include_once"control/common.php";
class REPORT {
	function __construct() {
		$this->page = 0;
		$this->rep_id=0;
		/*do action changes*/
		$this->objCommonFunc = new COMMONFUNC();
		$this->objPagination = new PAGINATION();

		if(!empty($_REQUEST['page'])) {
			$this->page = $_REQUEST['page'];
		}

		if(empty($_REQUEST['doAction'])) {
			$this->doAction = "";
		}
		else {
			$this->doAction = $_REQUEST['doAction'];
		}

		if(isset($_REQUEST['rep_id'])) {
			$this->rep_id = $_REQUEST['rep_id'];
		}

		if(!empty($_REQUEST['txtFilterName'])) {
			$this->txtFilterName = $_REQUEST['txtFilterName'];
		}
		else {
			$this->txtFilterName = "";
		}

		if(!empty($_REQUEST['txtSubCat'])) {
			$this->txtSubCat = $_REQUEST['txtSubCat'];
		}
		else {
			$this->txtSubCat = "";
		}

		if(!empty($_REQUEST['txtCat'])) {
			$this->txtCat = $_REQUEST['txtCat'];
		}
		else {
			$this->txtCat = "";
		}


		if($this->doAction =='ADD_REPORT' || $this->doAction =='UPDATE_REPORT') {
			if(!empty($_FILES['txtFile']['name'])) {
				$filename = strchr($_FILES['txtFile']['name'], ".");
				$extn = substr($filename,1);
				if(strtolower($extn) !='pdf' && strtolower($extn) !='xls' && strtolower($extn) !='xlsx') {
					//echo "Please upload PDF OR xls OR xlsx extension File";
					//exit;
				}

			}
		}

		$this->params = "txtFilterName=".$this->txtFilterName."&txtCat=".$this->txtCat."&txtSubCat=".$this->txtSubCat;

		if(isset($_REQUEST['doAction']) && $_REQUEST['doAction']=='CLEAR') {
			$this->txtFilterName ="";
			$this->txtSubCat = "";
			$this->txtCat = "";
			$this->doAction ="";
		}

		if(!empty($_REQUEST['submit']) && $_REQUEST['submit']=='CANCEL') {
			header('location:'.FILENAME);
		}

		if(!empty($_REQUEST['doAction'])) {
			switch($_REQUEST['doAction']) {
				case 'ADDSUBCATEGORY':
					$cat_id = $_REQUEST['cat_id'];
					$sub_cat_id = $_REQUEST['sub_cat_id'];
					$sqlins = "INSERT INTO sub_categories(subcat_cat_id,subcat_name)
					VALUES('".addslashes($_REQUEST['cat_id'])."',
					'".addslashes($_REQUEST['sub_cat_id'])."')";
					$this->objCommonFunc->executeQuery($sqlins);
					$rslt = $this->getSubCategoryNameList($cat_id);
					$str = '<select name="txtSubCat" id="txtSubCat"  class="txtfield"><option value=""> -- Select Subcategory-- </option>';
						while($row = $this->objCommonFunc->fetchAssoc($rslt)) {
							$str .='<option value="'.$row['subcat_id'].'"';
							if(!empty($_REQUEST['txtSubCat']) && $_REQUEST['txtSubCat'] == $row['subcat_id']) { $str .=" selected";}
							$str .= '>'.$row['subcat_name'].'</option>';
						}
					$str .= '</select>';
					print($str);
					break;
				case"ADD_REPORT":
					$page=0;
					$key = md5(CLIENTNAME);
					$sqlIns = "INSERT INTO reports (rep_client_id,rep_rig_id,rep_cat_id,rep_sub_cat_id,rep_desc,rep_insp_date,rep_next_insp_date,rep_comments)
					VALUES('".addslashes($_REQUEST['txtClientName'])."',
					'".addslashes($_REQUEST['txtRig'])."',
					'".addslashes($_REQUEST['txtCat'])."',
					'".addslashes($_REQUEST['txtSubCat'])."',
					'".addslashes($_REQUEST['txtTagno'])."',
					'".addslashes($this->objCommonFunc->date2sql($_REQUEST['txtInspectionDate']))."',
					'".addslashes($this->objCommonFunc->date2sql($_REQUEST['txtNextInspectionDate']))."',
					'".addslashes($_REQUEST['txtComments'])."'
					)";

					$this->objCommonFunc->executeQuery($sqlIns);
					$id = $this->objCommonFunc->lastInsertId();
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Added Report ".$_REQUEST['txtTagno']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					if(!empty($_FILES['txtFile']['name'])) {
						$folder = 'dms_files/';
						$filename = "dms_".$id."_".$_FILES['txtFile']['name'];
						 $ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;

						if(move_uploaded_file($_FILES["txtFile"]["tmp_name"], $path)){
						$sql_upd1 = "UPDATE reports SET rep_file='".$filename.".".$extension."' WHERE rep_id='".$id."'";
							$this->objCommonFunc->executeQuery($sql_upd1);
							$arrInfo = $this->objCommonFunc->getSingleRecInfo("rep_file","reports","rep_id=".$id);
							$file = 'dms_files/'.$arrInfo['rep_file'];
							$filename = strchr($_FILES['txtFile']['name'], ".");
							$extn = substr($filename,1);
							if($extn == 'pdf') {
								if((($_FILES["txtFile"]["size"]/1024)/1024) > 125) {
									if(@!$this->split_pdf($file , $folder,$id)) {
										print 'Sorry! system couldn\'t split file due to technical issue. Please split the files manualy and upload';
									}
								}
								else {
									$page=1;
									$folder = 'dms_files/';
									$filename = "dms_".$id."_".$_FILES['txtFile']['name'];
									$ext = pathinfo($filename);
								$extension = $ext['extension'];
								$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
								$path = $folder.$filename.".".$extension;
									move_uploaded_file($_FILES["txtFile"]["tmp_name"], $path);
									$sql_upd = "UPDATE reports SET rep_file2='".$filename.".".$extension."' WHERE rep_id='".$id."'";
									$this->objCommonFunc->executeQuery($sql_upd);
								}
							}
						}
					}
					if(!empty($_FILES['txtFile2']['name'])) {
						$page=1;
						$folder = 'dms_files/';
						$filename = "dms_".$id."_part1_".$_FILES['txtFile2']['name'];
						$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
						move_uploaded_file($_FILES["txtFile2"]["tmp_name"], $path);
						$sql_upd = "UPDATE reports SET rep_file2='".$filename.".".$extension."' WHERE rep_id='".$id."'";
						$this->objCommonFunc->executeQuery($sql_upd);
					}
					if(!empty($_FILES['txtFile3']['name'])) {
						$page=2;
						$folder = 'dms_files/';
						$filename = "dms_".$id."_part2_".$_FILES['txtFile3']['name'];
						$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
						move_uploaded_file($_FILES["txtFile3"]["tmp_name"], $path);
						$sql_upd = "UPDATE reports SET rep_file3='".$filename.".".$extension."' WHERE rep_id='".$id."'";
						$this->objCommonFunc->executeQuery($sql_upd);
					}
					if(!empty($_FILES['txtFile4']['name'])) {
						$page=3;
						$folder = 'dms_files/';
						$filename = "dms_".$id."_part3_".$_FILES['txtFile4']['name'];
						$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
						move_uploaded_file($_FILES["txtFile4"]["tmp_name"], $path);
						$sql_upd = "UPDATE reports SET rep_file4='".$filename.".".$extension."' WHERE rep_id='".$id."'";
						$this->objCommonFunc->executeQuery($sql_upd);
					}
					if(!empty($_FILES['txtFile5']['name'])) {
						$page=4;
						$folder = 'dms_files/';
						$filename = "dms_".$id."_part4_".$_FILES['txtFile5']['name'];
						$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
						move_uploaded_file($_FILES["txtFile5"]["tmp_name"], $path);
						$sql_upd = "UPDATE reports SET rep_file5='".$filename.".".$extension."' WHERE rep_id='".$id."'";
						$this->objCommonFunc->executeQuery($sql_upd);
					}
					$sql_upd = "UPDATE reports SET no_of_files='".$page."' WHERE rep_id='".$id."'";
					$this->objCommonFunc->executeQuery($sql_upd);
					print('SUCCESS');
					exit;
					//header('location:'.FILENAME."?page=".$this->page);
					break;
				case "UPDATE_REPORT":
					$page=0;
					$sqlUpd = "UPDATE reports
					SET rep_client_id='".addslashes($_REQUEST['txtClientName'])."',
					rep_rig_id='".addslashes($_REQUEST['txtRig'])."',
					rep_cat_id='".addslashes($_REQUEST['txtCat'])."',
					rep_sub_cat_id='".addslashes($_REQUEST['txtSubCat'])."',
					rep_desc='".addslashes($_REQUEST['txtTagno'])."',
					rep_insp_date='".addslashes($this->objCommonFunc->date2sql($_REQUEST['txtInspectionDate']))."',
					rep_next_insp_date='".addslashes($this->objCommonFunc->date2sql($_REQUEST['txtNextInspectionDate']))."',
					rep_comments = '".addslashes($_REQUEST['txtComments'])."'
					WHERE rep_id = '".addslashes($this->rep_id)."'";
					$this->objCommonFunc->executeQuery($sqlUpd);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Updated Report ".$_REQUEST['txtTagno']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					if(!empty($_FILES['txtFile']['name'])) {
						//fetch previous file name
						$arrInfo = $this->objCommonFunc->getSingleRecInfo("rep_file","reports","rep_id=".$this->rep_id);
						$prev_file = 'dms_files/'.$arrInfo['rep_file'];
						if(is_file($prev_file)) {
						unlink($prev_file);
						}
						$folder = 'dms_files/';
						$filename = "dms_".$this->rep_id."_".$_FILES['txtFile']['name'];
						$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
						if(move_uploaded_file($_FILES["txtFile"]["tmp_name"], $path)) {

							$sql_upd = "UPDATE reports SET rep_file='".$filename.".".$extension."' WHERE rep_id='".$this->rep_id."'";
							$this->objCommonFunc->executeQuery($sql_upd);
							$arrInfo = $this->objCommonFunc->getSingleRecInfo("rep_file","reports","rep_id=".$this->rep_id);
							$file = 'dms_files/'.$arrInfo['rep_file'];
							$filename = strchr($_FILES['txtFile']['name'], ".");
							$extn = substr($filename,1);
							$ext = pathinfo($filename);
							$extension = $ext['extension'];
							$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
							$path = $folder.$filename.".".$extension;
							if($extn == 'pdf') {
								if((($_FILES["txtFile"]["size"]/1024)/1024) > 125) {
									if(!$this->split_pdf($file , $folder,$this->rep_id)) {
										print 'Sorry! system couldn\'t split file due to technical issue. Please split the files manualy and upload';
									}
								}
								else {
									$page=1;
									$folder = 'dms_files/';
									$filename = "dms_".$this->rep_id."_".$_FILES['txtFile']['name'];
									$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
									$sql_upd = "UPDATE reports SET rep_file2='".$filename.".".$extension."' WHERE rep_id='".$this->rep_id."'";
									$this->objCommonFunc->executeQuery($sql_upd);
								}
							}
						}
					}

					if(!empty($_FILES['txtFile2']['name'])) {
						$page=1;
						$folder = 'dms_files/';
						$filename = "dms_".$this->rep_id."_part1_".$_FILES['txtFile2']['name'];
						$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
						move_uploaded_file($_FILES["txtFile2"]["tmp_name"], $path);
						$sql_upd = "UPDATE reports SET rep_file2='".$filename.".".$extension."' WHERE rep_id='".$this->rep_id."'";
						$this->objCommonFunc->executeQuery($sql_upd);
					}
					if(!empty($_FILES['txtFile3']['name'])) {
						$page=2;
						$folder = 'dms_files/';
						$filename = "dms_".$this->rep_id."_part2_".$_FILES['txtFile3']['name'];
						$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
						move_uploaded_file($_FILES["txtFile3"]["tmp_name"], $path);
						$sql_upd = "UPDATE reports SET rep_file3='".$filename.".".$extension."' WHERE rep_id='".$this->rep_id."'";
						$this->objCommonFunc->executeQuery($sql_upd);
					}
					if(!empty($_FILES['txtFile4']['name'])) {
						$page=3;
						$folder = 'dms_files/';
						$filename = "dms_".$this->rep_id."_part3_".$_FILES['txtFile4']['name'];
						$ext = pathinfo($filename);
						$extension = $ext['extension'];
						$filename = preg_replace('/[^A-Za-z0-9_]/', '_', $ext['filename']);
						$path = $folder.$filename.".".$extension;
						move_uploaded_file($_FILES["txtFile4"]["tmp_name"], $path);
						$sql_upd = "UPDATE reports SET rep_file4='".$filename.".".$extension."' WHERE rep_id='".$this->rep_id."'";
						$this->objCommonFunc->executeQuery($sql_upd);
					}
					if(!empty($_FILES['txtFile5']['name'])) {
						$page=4;
						$folder = 'dms_files/';
						$filename = "dms_".$this->rep_id."_part4_".$_FILES['txtFile5']['name'];
						$path = $folder.$filename;
						move_uploaded_file($_FILES["txtFile5"]["tmp_name"], $path);
						$sql_upd = "UPDATE reports SET rep_file5='".$filename.".".$extension."' WHERE rep_id='".$this->rep_id."'";
						$this->objCommonFunc->executeQuery($sql_upd);
					}
					$sql_upd = "UPDATE reports SET no_of_files='".$page."' WHERE rep_id='".$this->rep_id."'";
					$this->objCommonFunc->executeQuery($sql_upd);
					print('SUCCESS');
					exit;
					//header('location:'.FILENAME."?page=".$this->page."&rep_id=".$this->rep_id);
					break;
				case "DELETE_REPORT":
					$this->rep_id = $_REQUEST['rep_id'];
					$arrInfo = $this->objCommonFunc->getSingleRecInfo("*","reports","rep_id=". $this->rep_id);
					$file1 = "dms_files/".$arrInfo['rep_file'];
					$file2 = "dms_files/".$arrInfo['rep_file2'];
					$file3 = "dms_files/".$arrInfo['rep_file3'];
					$file4 = "dms_files/".$arrInfo['rep_file4'];
					$file5 = "dms_files/".$arrInfo['rep_file5'];
					if(is_file($file1)) {
					unlink($file1);
					}
					if(is_file($file2)) {
					unlink($file2);
					}
					if(is_file($file3)) {
					unlink($file3);
					}
					if(is_file($file4)) {
					unlink($file4);
					}
					if(is_file($file5)) {
					unlink($file5);
					}
					print $sqldel = "UPDATE  reports SET end_effdt = NOW(),username='".$_SESSION['username']."' WHERE rep_id='".$this->rep_id."'";
					//exit;
					$this->objCommonFunc->executeQuery($sqldel);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Delete Report'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					//print 'location:'.FILENAME."?page=".$this->page;
					header('location:'.FILENAME."?page=".$this->page);
					$_REQUEST['doAction']="";
					exit;
					break;
			}
		}
	}

	/*function for fetching client*/
	function  getReportInfo() {
		$sqlSel = "SELECT SQL_CALC_FOUND_ROWS rep_id,rep_client_id,rep_rig_id,rep_cat_id,rep_sub_cat_id,rep_desc,rep_insp_date,rep_next_insp_date,
		rep_test_proof_date,rep_due_proof_date,rep_tpi_date,rep_next_tpi_date,rep_comments,rep_file,rep_created_date,cat_name,subcat_name,rep_file2,
		rep_file3,rep_file4,rep_file5,no_of_files, DATE(rep_created_date) rep_created_date
		FROM reports rep
		LEFT JOIN clients c
		ON rep.rep_client_id = c.client_id
		LEFT JOIN rigs rg
		ON rg.rig_id=rep.rep_rig_id
		LEFT JOIN categories cat
		ON rep.rep_cat_id = cat.cat_id
		LEFT JOIN sub_categories subcat
		ON rep.rep_sub_cat_id = subcat.subcat_id
		WHERE (end_effdt IS NULL OR end_effdt='0000-00-00')";

		if(!empty($this->txtFilterName)) {
			$sqlSel .= " AND rep_desc LIKE '%".$this->txtFilterName."%'";
		}

		if(!empty($this->txtCat)) {
			$sqlSel .= " AND rep_cat_id = '".$this->txtCat."'";
		}

		if(!empty($this->txtSubCat)) {
			$sqlSel .= " AND rep_sub_cat_id = '".$this->txtSubCat."'";
		}

		$sqlSel .= " ORDER BY rep_desc";

		if($this->page==0) {
			$sqlSel .= " LIMIT 0,".LIMIT;
		}
		else {
			$sqlSel .= " LIMIT ".((LIMIT*($this->page-1))).",".(LIMIT);
		}
		$result = $this->objCommonFunc->executeQuery($sqlSel);
		return $result;
	}

	function  roGgetRigInfo() {
		$sqlSel = "SELECT SQL_CALC_FOUND_ROWS rep_id, rig_name, rig_client_id,rig_imo_no,rig_manager,rig_type,rig_classification,rig_remarks,c.client_name,
		rl.rl_username
		FROM rigs r
		LEFT JOIN clients c
		ON r.rig_client_id = c.client_id
		LEFT JOIN rig_login rl
		ON rl.rl_rep_id=r.rep_id
		WHERE r.rep_id = '".$this->rep_id."'";
		$result = $this->objCommonFunc->executeQuery($sqlSel);
		return $this->objCommonFunc->fetchAssoc($result);
	}

	/*Function for fetching client name*/
	function getClientNameList() {
		$sqlsel = "SELECT SQL_CALC_FOUND_ROWS client_id,client_name FROM clients ORDER BY client_name";
		$result = $this->objCommonFunc->executeQuery($sqlsel);
		return $result;
	}

	/*Function for fetching rig name*/
	function getRigNameList($client_id=null) {
		$sqlsel = "SELECT SQL_CALC_FOUND_ROWS rig_id,rig_name,rl_username
		FROM rigs r 
		LEFT JOIN rig_login rl ON r.rig_id = rl.rl_rig_id 
		WHERE rl_type='R'  ORDER BY rig_name";
		if($client_id>0) {
			$sqlsel .= " AND rig_client_id=".$client_id;
		}
		$result = $this->objCommonFunc->executeQuery($sqlsel);
		return $result;
	}

	/*Function for fetching category name*/
	function getCategoryNameList() {
		$sqlsel = "SELECT SQL_CALC_FOUND_ROWS cat_id,cat_name FROM categories ORDER BY cat_name";
		$result = $this->objCommonFunc->executeQuery($sqlsel);
		return $result;
	}

	/*Function for fetching category name*/
	function getSubCategoryNameList($subcat_id = null) {
		$sqlsel = "SELECT SQL_CALC_FOUND_ROWS subcat_id,subcat_name,subcat_cat_id FROM sub_categories
		WHERE  subcat_cat_id='".$subcat_id."' ORDER BY subcat_name";
		$result = $this->objCommonFunc->executeQuery($sqlsel);
		return $result;
	}

	function split_pdf($filename, $end_directory = false,$rep_id) {
		require_once('fpdf/fpdf.php');
		require_once('fpdi/fpdi.php');

		$end_directory = $end_directory ? $end_directory : './';
		$new_path = preg_replace('/[\/]+/', '/', $end_directory.'/'.substr($filename, 0, strrpos($filename, '/')));

		if (!is_dir($new_path))
		{
			// Will make directories under end directory that don't exist
			// Provided that end directory exists and has the right permissions
			mkdir($new_path, 0777, true);
		}

		$pdf = new FPDI();

		$pagecount = $pdf->setSourceFile($filename); // How many pages?
		if(empty($pagecount)) {
			return false;
		}
		$page_limit = 0;
		$page=0;
		// Split each page into a new PDF
		for ($i = 1; $i <= $pagecount; $i++) {
			$new_pdf = new FPDI();
			$new_pdf->AddPage();
			$new_pdf->setSourceFile($filename);
			$new_pdf->useTemplate($new_pdf->importPage($i));
			if($i%500 == 0) {
				$page_limit = $page_limit+$i;
				$page++;
				try {
					$new_filename = "dms_".$rep_id."_part".$page.'_'.str_replace('.pdf', '', $_FILES['txtFile']['name']).".pdf";
					$new_filepath = $end_directory."dms_".$rep_id."_part".$page.'_'.str_replace('.pdf', '', $_FILES['txtFile']['name']).".pdf";
					$new_pdf->Output($new_filepath, "F");
					switch($page) {
						case"1":
							$sql_upd = "UPDATE reports SET rep_file2='".$new_filepath."' WHERE rep_id='".$rep_id."'";
								$this->objCommonFunc->executeQuery($sql_upd);
							break;
						case"2":
							$sql_upd = "UPDATE reports SET rep_file3='".$new_filepath."' WHERE rep_id='".$rep_id."'";
								$this->objCommonFunc->executeQuery($sql_upd);
							break;
						case"3":
							$sql_upd = "UPDATE reports SET rep_file4='".$new_filepath."' WHERE rep_id='".$rep_id."'";
								$this->objCommonFunc->executeQuery($sql_upd);
							break;
						case"4":
							$sql_upd = "UPDATE reports SET rep_file5='".$new_filepath."' WHERE rep_id='".$rep_id."'";
								$this->objCommonFunc->executeQuery($sql_upd);
							break;
					}
					//echo "Page ".$i." split into ".$new_filename."<br />\n";
				} catch (Exception $e) {
					//echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			}
			if(($pagecount-$page_limit) == $i) {
				$page++;
				try {
					$new_filename = "dms_".$rep_id."_part".$page.'_'.str_replace('.pdf', '', $_FILES['txtFile']['name']).".pdf";
					$new_filepath = $end_directory."dms_".$rep_id."_part".$page.'_'.str_replace('.pdf', '', $_FILES['txtFile']['name']).".pdf";
					$new_pdf->Output($new_filepath, "F");
					switch($page) {
						case"1":
							$sql_upd = "UPDATE reports SET rep_file2='".$new_filepath."' WHERE rep_id='".$rep_id."'";
								$this->objCommonFunc->executeQuery($sql_upd);
							break;
						case"2":
							$sql_upd = "UPDATE reports SET rep_file3='".$new_filepath."' WHERE rep_id='".$rep_id."'";
								$this->objCommonFunc->executeQuery($sql_upd);
							break;
						case"3":
							$sql_upd = "UPDATE reports SET rep_file4='".$new_filepath."' WHERE rep_id='".$rep_id."'";
								$this->objCommonFunc->executeQuery($sql_upd);
							break;
						case"4":
							$sql_upd = "UPDATE reports SET rep_file5='".$new_filepath."' WHERE rep_id='".$rep_id."'";
								$this->objCommonFunc->executeQuery($sql_upd);
							break;
					}
					//echo "Page ".$i." split into ".$new_filename."<br />\n";
				} catch (Exception $e) {
					//echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			}
			$sql_upd = "UPDATE reports SET no_of_files='".$page."' WHERE rep_id='".$rep_id."'";
			$this->objCommonFunc->executeQuery($sql_upd);
		}
		return true;
	}
}
$report = new REPORT();
?>