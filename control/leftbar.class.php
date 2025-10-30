<?php
include_once"control/common.php";
class LEFTBAR {
	function __construct() {
		public $this->page = 0;
		public $this->rig_id=0;
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
				case"LOGOUT":
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Logout from system'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					$_SESSION = [];
					//remove PHPSESSID from browser
                    if ( isset( $_COOKIE[session_name()] ) )
                    setcookie( session_name(), "", time()-3600, "/");
                    //clear session from globals
                    $_SESSION = array();
                    //clear session from disk
                    session_destroy();
					header("location:./");
					exit;
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
		$sql_sel = "SELECT * FROM  categories,reports
		WHERE cat_id =rep_cat_id
		AND rep_rig_id ='".$_SESSION['user_id']."'
		AND (reports.end_effdt IS NULL OR reports.end_effdt='0000-00-00')
		GROUP BY cat_id";
		$result = $this->objCommonFunc->executeQuery($sql_sel);
		return $result;
	}

	function isSubCategory($cat_id=null) {
		$sql="SELECT count(subcat_id) cnt
		FROM sub_categories ,reports
		WHERE  subcat_cat_id = rep_sub_cat_id
		AND subcat_cat_id='".$cat_id."'
		GROUP BY subcat_cat_id";
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
		$sql="SELECT * FROM sub_categories ,reports
		WHERE subcat_cat_id = rep_sub_cat_id
		AND subcat_cat_id='".$cat_id."'
		AND rep_rig_id ='".$_SESSION['user_id']."'
		GROUP BY subcat_cat_id";
		$result = $this->objCommonFunc->executeQuery($sql);
		return $result;
	}
}
$leftbar = new LEFTBAR();
?>