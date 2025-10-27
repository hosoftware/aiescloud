<?php
$file = basename(str_replace(substr(strchr($_SERVER['REQUEST_URI'], "?"),0),'',$_SERVER['REQUEST_URI']));
$filename = strchr($file, ".");
$extn = substr($filename,1);
//print $_SERVER['PHP_SELF'];
//print $basepath = substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['REQUEST_URI'],'/'));
if(empty($filename)) {
	$file = "index.php";
}
else if($file=='favicon.ico') {
	$file = "index.php";
}
if($extn == 'pdf') {
	include_once "view/filehandle.php";
}
else {
include_once "view/".$file;
}
?>