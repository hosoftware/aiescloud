<?php
include_once"control/common.php";
class CLIENT {
	function CLIENT() {
		$this->page = 0;
		$this->client_id=0;
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
		if(isset($_REQUEST['client_id'])) {
			$this->client_id = $_REQUEST['client_id'];
		}

		if(!empty($_REQUEST['txtFilterName'])) {
			$this->txtFilterName = $_REQUEST['txtFilterName'];
		}
		else {
			$this->txtFilterName = "";
		}

		//Params
		$this->params = "txtFilterName=".$this->txtFilterName;

		if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'CLEAR') {
			$this->txtFilterName ="";
			$this->doAction ="";
		}

		if(isset($_REQUEST['doAction']) && $_REQUEST['doAction']=='DELETE_CLIENT') {
			if($this->isRigs($this->client_id)) {
				$_REQUEST['doAction'] = "";
				$this->doAction = "";
				$_REQUEST['errMsg'] = 'Y';
			}
			else if($this->isReports($this->client_id)) {
				$_REQUEST['doAction'] = "";
				$this->doAction = "";
				$_REQUEST['errMsg'] = 'Y';
			}
		}
		if(!empty($_REQUEST['submit']) && $_REQUEST['submit']=='CANCEL') {
			header('location:'.FILENAME);
		}
		if(!empty($_REQUEST['doAction'])) {
			switch($_REQUEST['doAction']) {
				case"ADD_CLIENT":
					$sqlIns = "INSERT INTO clients (client_name)
					VALUES('".addslashes($_REQUEST['txtName'])."')";
					$this->objCommonFunc->executeQuery($sqlIns);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Added Client".$_REQUEST['txtName']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page);
					break;
				case "UPDATE_CLIENT":
					$sqlUpd = "UPDATE clients 
					SET client_name='".addslashes($_REQUEST['txtName'])."'
					WHERE client_id = '".addslashes($this->client_id)."'";
					$this->objCommonFunc->executeQuery($sqlUpd);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Update Client".$_REQUEST['txtName']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page."&client_id=".$this->client_id);
					break;
				case "DELETE_CLIENT":
					$this->client_id = $_REQUEST['client_id'];
					$sqldel = "DELETE FROM clients WHERE client_id='".$this->client_id."'";
					$this->objCommonFunc->executeQuery($sqldel);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Delete Client".$_REQUEST['txtName']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page);
					break;
			}
		}
	}

	/*function for fetching client*/
	function  getClientInfo() {
		$sqlSel = "SELECT SQL_CALC_FOUND_ROWS * FROM clients WHERE 1";

		if(!empty($this->txtFilterName)) {
			$sqlSel .= " AND client_name LIKE '%".$this->txtFilterName."%'";
		}
		
		$sqlSel .= " ORDER BY client_name";

		if($this->page==0) {
			$sqlSel .= " LIMIT 0,".LIMIT;
		}
		else {
			$sqlSel .= " LIMIT ".((LIMIT*($this->page-1))).",".(LIMIT);
		}
		$result = $this->objCommonFunc->executeQuery($sqlSel);
		return $result;
	}

	function isReports($cat_id=null) {
		$sql="SELECT count(rep_client_id) cnt FROM reports WHERE rep_client_id='".$cat_id."' AND (end_effdt IS NULL OR end_effdt='0000-00-00') ";
		$result = $this->objCommonFunc->executeQuery($sql);
		$row = $this->objCommonFunc->fetchAssoc($result);
		if($row['cnt']>0) {
			return true;
		}
		else {
			return false;
		}
	}

	function isRigs($cat_id=null) {
		$sql="SELECT count(rig_client_id) cnt FROM rigs WHERE rig_client_id='".$cat_id."'";
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
$client = new CLIENT();
?>