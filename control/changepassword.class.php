<?php
include_once"control/common.php";
class CHANGEPASSWORD {
	function __construct() {
		$this->page = 0;
		$this->rig_id=0;
		if(empty($_SESSION['user_id'])) {
			header('./');
		}
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

		
		if(!empty($_REQUEST['doAction'])) {
			switch($_REQUEST['doAction']) {
				case"CHANGE_PASSWORD":
					$key = md5(CLIENTNAME);
					$sqlUpd = "UPDATE rigs,rig_login 
							   SET rl_password = '".addslashes(MD5($_REQUEST['txtPassword']))."',
							   tmp_pass = '".addslashes(MD5($_REQUEST['txtPassword']))."',
							   rl_create_date = '".gmdate('Y-m-d H:i:s')."'
							   WHERE rl_rig_id = '".addslashes($_SESSION['user_id'])."'";
					$this->objCommonFunc->executeQuery($sqlUpd);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Change Password".$_REQUEST['txtPassword']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME.'?errMsg=Y');
					break;
			}
		}
	}

	

	/*Function for fetching client name*/
	function getClientNameList() {
		$sqlsel = "SELECT SQL_CALC_FOUND_ROWS client_id,client_name FROM clients";
		$result = $this->objCommonFunc->executeQuery($sqlsel);
		return $result;
	}
	function  getCateGory() {
		$sql_sel = "SELECT * FROM  categories";
		$result = $this->objCommonFunc->executeQuery($sql_sel);
		return $result;
	}

	function isSubCategory($cat_id=null) {
		$sql="SELECT count(subcat_id) cnt FROM sub_categories WHERE subcat_cat_id='".$cat_id."'";
		$result = $this->objCommonFunc->executeQuery($sql);
		$row = $this->objCommonFunc->fetchAssoc($result);
		if($row['cnt']>0) {
			return true;
		}
		else {
			return false;
		}
	}

	function getSubCategory($cat_id=null) {
		$sql="SELECT * FROM sub_categories WHERE subcat_cat_id='".$cat_id."'";
		$result = $this->objCommonFunc->executeQuery($sql);
		return $result;
	}

}
$changepassword = new CHANGEPASSWORD();
?>