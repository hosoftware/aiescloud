<?php
ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
ob_start();
session_cache_limiter('nocache');
ini_set('session.cookie_lifetime',84600);
ini_set('session.gc_maxlifetime',84600);
session_start();
ini_set('display_errors', '0'); 
?>