<?php
include_once"control/common.php";
class CATEGORY {
	function __construct() {
		$this->page = 0;
		$this->cat_id=0;
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

		if(isset($_REQUEST['cat_id'])) {
			$this->cat_id = $_REQUEST['cat_id'];
		}

		if(!empty($_REQUEST['txtFilterName'])) {
			$this->txtFilterName = $_REQUEST['txtFilterName'];
		}
		else {
			$this->txtFilterName = "";
		}
		if(isset($_REQUEST['doAction']) && $_REQUEST['doAction']=='DELETE_CATEGORY') {
			if($this->isSubCategory($this->cat_id)) {
				$_REQUEST['doAction'] = "";
				$this->doAction = "";
				$_REQUEST['errMsg'] = 'Y';
			}
			else if($this->isReports($this->cat_id)) {
				$_REQUEST['doAction'] = "";
				$this->doAction = "";
				$_REQUEST['errMsg'] = 'Y';
			}
		}
		$this->params = "txtFilterName=".$this->txtFilterName;

		if(isset($_REQUEST['doAction']) &&  $_REQUEST['doAction']=='CLEAR') {
			$this->txtFilterName ="";
			$this->txtInspectionDate = "";
			$this->txtNextInspectionDate = "";
			$this->doAction ="";
		}
		
		if(!empty($_REQUEST['submit']) && $_REQUEST['submit']=='CANCEL') {
			header('location:'.FILENAME);
		}
		if(!empty($_REQUEST['doAction'])) {
			switch($_REQUEST['doAction']) {
				case"ADD_CATEGORY":
					$sqlIns = "INSERT INTO categories (cat_name,username)
					VALUES('".addslashes($_REQUEST['txtName'])."','".$_SESSION['username']."')";
					$this->objCommonFunc->executeQuery($sqlIns);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Add Category".$_REQUEST['txtName']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page);
					break;
				case "UPDATE_CATEGORY":
					$sqlUpd = "UPDATE categories 
					SET cat_name='".addslashes($_REQUEST['txtName'])."'
					WHERE cat_id = '".addslashes($this->cat_id)."'";
					$this->objCommonFunc->executeQuery($sqlUpd);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Update Category".$_REQUEST['txtName']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page."&cat_id=".$this->cat_id);
					break;
				case "DELETE_CATEGORY":
					$this->cat_id = $_REQUEST['cat_id'];
					$sqldel = "DELETE FROM categories WHERE cat_id='".$this->cat_id."'";
					$this->objCommonFunc->executeQuery($sqldel);
					$sql_ins="INSERT INTO activity_log(username,user_id,log_type)VALUES('".$_SESSION['username']."',
						'".$_SESSION['user_id']."',
						'Delete Category".$_REQUEST['txtName']."'
						)";
					$this->objCommonFunc->executeQuery($sql_ins);
					header('location:'.FILENAME."?page=".$this->page);
					break;
			}
		}
	}

	/*function for fetching cat*/
	function  getCategoryInfo() {
		$sqlSel = "SELECT SQL_CALC_FOUND_ROWS * FROM categories WHERE 1";

		if(!empty($this->txtFilterName)) {
			$sqlSel .= " AND cat_name LIKE '%".$this->txtFilterName."%'";
		}
		
		$sqlSel .= " ORDER BY cat_name";

		if($this->page==0) {
			$sqlSel .= " LIMIT 0,".LIMIT;
		}
		else {
			$sqlSel .= " LIMIT ".((LIMIT*($this->page-1))).",".(LIMIT);
		}
		$result = $this->objCommonFunc->executeQuery($sqlSel);
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

	function isReports($cat_id=null) {
		$sql="SELECT count(rep_cat_id) cnt FROM reports WHERE rep_cat_id='".$cat_id."' AND (end_effdt IS NULL OR end_effdt='0000-00-00')";
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
$category = new CATEGORY();
?>