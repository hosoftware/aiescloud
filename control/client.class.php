<?php
include_once"control/common.php";
class CLIENT {
	function __construct() {
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
					$sel_clnt = "select client_id from clients where client_name='".trim($_REQUEST['txtName'])."'"; 
					$res_clnt = $this->objCommonFunc->executeQuery($sel_clnt);
					$rw_clnt = $this->objCommonFunc->fetchAssoc($res_clnt);
				    if($rw_clnt['client_id']!=''){ 
					$error = "1";
					header('location:'.FILENAME."?doAction=ADD&error=".$error."&page=".$this->page);
					}
					else{
					$sqlIns = "INSERT INTO clients (client_name)
					VALUES('".addslashes(trim($_REQUEST['txtName']))."')";
					$this->objCommonFunc->executeQuery($sqlIns);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Added Client".$_REQUEST['txtName']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page);
					}
					break;
				case "TRANSFER_CLIENT":
					 $clientName = $_REQUEST['clientName'];
					 $client_id = $_REQUEST['client_id'];
					 $sqlrig = "select rig_id from rigs where rig_client_id=".$client_id; 
					 $res_rig = $this->objCommonFunc->executeQuery($sqlrig);
					 while($rigrow = $this->objCommonFunc->fetchAssoc($res_rig)) 
					 {
						$sqlrigUp = "UPDATE rigs SET rig_client_id=".$clientName." where rig_id=".$rigrow['rig_id']; 
						$this->objCommonFunc->executeQuery($sqlrigUp);
					 } 
					 $sqlrep = "select rep_id from reports where rep_client_id=".$client_id;
					 $res_rep = $this->objCommonFunc->executeQuery($sqlrep);
					 while($reprow = $this->objCommonFunc->fetchAssoc($res_rep)) 
					 {
						 $sqlrepUp = "UPDATE reports SET rep_client_id=".$clientName." where rep_id=".$reprow['rep_id'];
						 $this->objCommonFunc->executeQuery($sqlrepUp);
					 }
					
					header('location:'.FILENAME."?page=".$this->page."&client_id=".$this->client_id);
					break;
			    case "UPDATE_CLIENT":
				    $sel_clnt = "select client_id from clients where client_name='".trim($_REQUEST['txtName'])."' and client_id!= '".addslashes($this->client_id)."'";
					$res_clnt = $this->objCommonFunc->executeQuery($sel_clnt);
					$rw_clnt = $this->objCommonFunc->fetchAssoc($res_clnt);
				    if($rw_clnt['client_id']!=''){ 
					$error = "1";
					header('location:'.FILENAME."?doAction=EDIT&error=".$error."&page=".$this->page."&client_id=".$this->client_id);
					}
					else
					{
					$sqlUpd = "UPDATE clients 
					SET client_name='".addslashes(trim($_REQUEST['txtName']))."'
					WHERE client_id = '".addslashes($this->client_id)."'";
					$this->objCommonFunc->executeQuery($sqlUpd);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Update Client".$_REQUEST['txtName']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page."&client_id=".$this->client_id);
					}
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
		
		$sqlSel .= " ORDER BY client_name ASC";

		if($this->page==0) {
			$sqlSel .= " LIMIT 0,".LIMIT;
		}
		else {
			$sqlSel .= " LIMIT ".((LIMIT*($this->page-1))).",".(LIMIT);
		}
		$result = $this->objCommonFunc->executeQuery($sqlSel);
		return $result;
	}
	function  getClientData($clnt=null) {
		$sqlSel1 = "SELECT c.*,t.rep_id,r.rig_id FROM `clients` c left join rigs r on c.client_id=r.rig_client_id 
					left join reports t on c.client_id=t.rep_client_id WHERE c.client_id!=".$clnt." GROUP by c.client_id 
					ORDER BY c.client_name";

		$result1 = $this->objCommonFunc->executeQuery($sqlSel1);
		return $result1;
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
	function isReportscnt($cat_id=null) {
		$sql="SELECT count(rep_client_id) cnt FROM reports WHERE rep_client_id='".$cat_id."'";
		$result = $this->objCommonFunc->executeQuery($sql);
		$row = $this->objCommonFunc->fetchAssoc($result);
		if($row['cnt']>0) {
			return $row['cnt'];
		}
		else {
			return 0;
		}
	}

	function isRigscnt($cat_id=null) {
		$sql="SELECT count(rig_client_id) cnt FROM rigs WHERE rig_client_id='".$cat_id."'";
		$result = $this->objCommonFunc->executeQuery($sql);
		$row = $this->objCommonFunc->fetchAssoc($result);
		if($row['cnt']>0) {
			return $row['cnt'];
		}
		else {
			return 0;
		}
	}
}
$client = new CLIENT();
?>