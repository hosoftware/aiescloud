<?php
ini_set('display_errors',0);
include_once"control/session.class.php";
include_once"control/system.class.php";
include_once"control/constants.php";
include_once"control/commonfunc.class.php";
include_once"control/pagination.class.php";
$file = basename(str_replace(substr(strchr($_SERVER['REQUEST_URI'], "?"),0),'',$_SERVER['REQUEST_URI']));
$filename = strchr($file, ".");
$extn = substr($filename,1);
if(empty($_SESSION['user_id']) && !empty($extn) && ($file!='index.php')) {
	//header('location:./');
	include_once'view/index.php';
	exit;
}
?>