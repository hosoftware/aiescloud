<?php
define('DEBUG','1');
define('CLIENTNAME','MARKETINGLOGAPPLICATIONMASTER');
define('LIMIT','18');
define('GALLIMIT','32');
$file = basename($_SERVER['REQUEST_URI']);
if(strpos($file,'?')>0) {
	$file = substr($file,0,strpos($file,'?'));
}
define('FILENAME',$file);
?>