<?php
include_once"control/common.php";
class PASSWORDREQUEST {
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

		if(!empty($_REQUEST['txtInspectionDate'])) {
			$this->txtInspectionDate = $_REQUEST['txtInspectionDate'];
		}
		else {
			$this->txtInspectionDate = "";
		}

		if(!empty($_REQUEST['txtNextInspectionDate'])) {
			$this->txtNextInspectionDate = $_REQUEST['txtNextInspectionDate'];
		}
		else {
			$this->txtNextInspectionDate = "";
		}
		if(isset($_REQUEST['doAction']) =='CLEAR') {
			$this->txtFilterName ="";
			$this->txtInspectionDate = "";
			$this->txtNextInspectionDate = "";
			$this->doAction ="";
		}

		if($this->doAction =='ADD_REPORT' || $this->doAction =='UPDATE_REPORT') {
			if(!empty($_FILES['txtFile']['name'])) {
				$extn = substr($_FILES['txtFile']['name'],-3);
				if($extn !='pdf') {
					echo "Please upload PDF File";exit;
				}
				
			}
			if(!empty($_FILES['txtFile2']['name'])) {
				$extn = substr($_FILES['txtFile2']['name'],-3);
				if($extn !='swf') {
					echo "Please upload Flash(.swf) File";exit;
				}
				
			}
			
		}
		
		if(!empty($_REQUEST['submit']) && $_REQUEST['submit']=='CANCEL') {
			header('location:'.FILENAME);
		}
		
		if(!empty($_REQUEST['doAction'])) {
			switch($_REQUEST['doAction']) {
				case 'ADDSUBCATEGORY':
				
			}
		}
	}

	



	/*function for fetching client*/
	function  getRequestList() {
		$sqlSel = "SELECT SQL_CALC_FOUND_ROWS *,DATE(send_date) send_date
		FROM forgotpassword
		WHERE 1 ";
		
		if(!empty($this->txtFilterName)) {
			$sqlSel .= " AND name LIKE '%".$this->txtFilterName."%'";
		}
		if(!empty($this->txtInspectionDate)) {
			$sqlSel .= " AND DATE(send_date) >='".$this->objCommonFunc->date2sql($this->txtInspectionDate)."'";
		}

		if(!empty($this->txtNextInspectionDate)) {
			$sqlSel .= " AND DATE(send_date) <='". $this->objCommonFunc->date2sql($this->txtNextInspectionDate)."'";
		}
		
		
		$sqlSel .= " ORDER BY send_date DESC";

		if($this->page==0) {
			$sqlSel .= " LIMIT 0,".LIMIT;
		}
		else {
			$sqlSel .= " LIMIT ".((LIMIT*($this->page-1))).",".(LIMIT);
		}
		$result = $this->objCommonFunc->executeQuery($sqlSel);
		return $result;
	}
}
$passwordrequest = new PASSWORDREQUEST();
?>