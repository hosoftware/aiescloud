<?php
include_once"control/common.php";
class RIG {
	function __construct() {
		$this->page = 0;
		$this->rig_id=0;
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

		if(isset($_REQUEST['rig_id'])) {
			$this->rig_id = $_REQUEST['rig_id'];
		}

		if(!empty($_REQUEST['txtFilterName'])) {
			$this->txtFilterName = $_REQUEST['txtFilterName'];
		}
		else {
			$this->txtFilterName = "";
		}

		$this->params = "txtFilterName=".$this->txtFilterName;

		if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'CLEAR') {
			$this->txtFilterName ="";
			$this->doAction ="";
		}
		
		if($this->checkUserNameExist() && ($this->doAction =='ADD_ADMINUSER'||$this->doAction =='UPDATE_PASSWORD')) {
			if($this->rig_id) {
				$this->doAction = "EDIT";
			}
			else {
				$this->doAction = "ADD";
			}
			$_REQUEST['doAction'] = $this->doAction;
			$this->errMsg = "Username already exist. Please use another Username";
			
		}
		print $this->doAction;
		if(isset($_REQUEST['doAction']) && $_REQUEST['doAction']=='DELETE_RIG') {
			if($this->isReports($this->rig_id)) {
				$_REQUEST['doAction'] = "";
				$this->doAction = "";
				$this->errMsg = "Sorry! you can't delete this rig . There are some reports exists under this rig.";
			}
		}
		if(!empty($_REQUEST['submit']) && $_REQUEST['submit']=='CANCEL') {
			header('location:'.FILENAME);
		}
		if(!empty($_REQUEST['doAction'])) {
			switch($_REQUEST['doAction']) {
				case"ADD_RIG":
					$key = md5(CLIENTNAME);

					$sqlIns = "INSERT INTO rigs (rig_name,rig_client_id,rig_imo_no,rig_manager,rig_type,rig_classification,rig_remarks)
					VALUES('".addslashes($_REQUEST['txtName'])."',
					'".addslashes($_REQUEST['txtClientName'])."',
					'".addslashes($_REQUEST['txtIMO'])."',
					'".addslashes($_REQUEST['txtRigmanager'])."',
					'".addslashes($_REQUEST['txtRigtype'])."',
					'".addslashes($_REQUEST['txtClassification'])."',
					'".addslashes($_REQUEST['txtRemarks'])."'
					)";
					$this->objCommonFunc->executeQuery($sqlIns);
					$id = $this->objCommonFunc->lastInsertId();
					if(!empty($id)) {
						$sqlIns = "INSERT INTO rig_login (rl_rig_id,rl_username,rl_password,tmp_pass)
						VALUES('".$id."',
						'".addslashes($_REQUEST['txtUserName'])."',
						AES_ENCRYPT('".addslashes($_REQUEST['txtPassword'])."','".$key."'),AES_ENCRYPT('".addslashes($_REQUEST['txtPassword'])."','".$key."'))";
						$this->objCommonFunc->executeQuery($sqlIns);
					}
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Added Rig".$_REQUEST['txtName']."')";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page);
					break;
				case "UPDATE_RIG":
					 $sqlUpd = "UPDATE rigs,rig_login 
					SET rig_name='".addslashes($_REQUEST['txtName'])."',
					rig_client_id='".addslashes($_REQUEST['txtClientName'])."',
					rig_imo_no='".addslashes($_REQUEST['txtIMO'])."',
					rig_manager='".addslashes($_REQUEST['txtRigmanager'])."',
					rig_type='".addslashes($_REQUEST['txtRigtype'])."',
					rig_classification='".addslashes($_REQUEST['txtClassification'])."',
					rig_remarks='".addslashes($_REQUEST['txtRemarks'])."'
					WHERE rig_id = '".addslashes($this->rig_id)."'
					AND rig_id = rl_rig_id";
					$this->objCommonFunc->executeQuery($sqlUpd);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Updated Rig".$_REQUEST['txtName']."')";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page."&rig_id=".$this->rig_id);
					break;
				case "UPDATE_PASSWORD":
					$key = md5(CLIENTNAME);
					  $sqlUpd = "UPDATE rigs,rig_login 
							   SET tmp_pass = AES_ENCRYPT('".addslashes($_REQUEST['txtPassword'])."','".$key."'),
							   rl_username = '".addslashes($_REQUEST['txtUserName'])."'
							   WHERE rl_rig_id = '".addslashes($this->rig_id)."'";
							 // exit;
					$this->objCommonFunc->executeQuery($sqlUpd);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Change password".$_REQUEST['txtPassword']."Username:".$_REQUEST['txtUserName']."')";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page."&rig_id=".$this->rig_id);
					break;
				case "DELETE_RIG":
					$this->rig_id = $_REQUEST['rig_id'];
					$sqldel = "DELETE FROM rigs WHERE rig_id='".$this->rig_id."'";
					$this->objCommonFunc->executeQuery($sqldel);
					$sqldel = "DELETE FROM rig_login WHERE rl_rig_id='".$this->rig_id."'";
					$this->objCommonFunc->executeQuery($sqldel);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Delete rig'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page);
					break;
			}
		}
	}

	/*function for fetching client*/
	function  getRigInfo() {
		$sqlSel = "SELECT SQL_CALC_FOUND_ROWS rig_id, rig_name, rig_client_id,rig_imo_no,rig_manager,rig_type,rig_classification,rig_remarks,c.client_name,
		rl.rl_username
		FROM rigs r
		LEFT JOIN clients c
		ON r.rig_client_id = c.client_id
		LEFT JOIN rig_login rl
		ON rl.rl_rig_id=r.rig_id
		WHERE 1 AND rl_type='R'";

		if(!empty($this->txtFilterName)) {
			$sqlSel .= " AND rig_name LIKE '%".$this->txtFilterName."%'";
		}
		
		$sqlSel .= " ORDER BY rig_name";

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
		$key = md5(CLIENTNAME);
		$sqlSel = "SELECT SQL_CALC_FOUND_ROWS rig_id, rig_name, rig_client_id,rig_imo_no,rig_manager,rig_type,rig_classification,rig_remarks,c.client_name,
		rl.rl_username username,AES_DECRYPT(rl.rl_password,'".$key."') password
		FROM rigs r
		LEFT JOIN clients c
		ON r.rig_client_id = c.client_id
		LEFT JOIN rig_login rl
		ON rl.rl_rig_id=r.rig_id
		WHERE r.rig_id = '".$this->rig_id."'";
		$result = $this->objCommonFunc->executeQuery($sqlSel);
		return $this->objCommonFunc->fetchAssoc($result);
	}

	/*Function for fetching client name*/
	function getClientNameList() {
		$sqlsel = "SELECT SQL_CALC_FOUND_ROWS client_id,client_name FROM clients ORDER BY client_name";
		$result = $this->objCommonFunc->executeQuery($sqlsel);
		return $result;
	}

	function checkUserNameExist() {
		if(!empty($_REQUEST['txtUserName'])) {
			$sql = " SELECT count(rl_rig_id) cnt FROM rig_login WHERE rl_username='".addslashes($_REQUEST['txtUserName'])."'";
			if(!empty($this->rig_id)) {
				$sql .= " AND rl_rig_id <>'".$this->rig_id."'";
			}
			$result = $this->objCommonFunc->executeQuery($sql);
			$row = $this->objCommonFunc->fetchAssoc($result);
			
			if($row['cnt']>0) {
				return true;
				
			}
			else {
				return false;
			}
		}
	}

	function isReports($cat_id=null) {
		$sql="SELECT count(rep_rig_id) cnt FROM reports WHERE rep_rig_id='".$cat_id."' AND (end_effdt IS NULL OR end_effdt='0000-00-00')";
		$result = $this->objCommonFunc->executeQuery($sql);
		$row = $this->objCommonFunc->fetchAssoc($result);
		if($row['cnt']>0) {
			return true;
		}
		else {
			return false;
		}
	}
}
$rig = new RIG();
?>