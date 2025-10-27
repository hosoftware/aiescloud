<div class="navigation"><?php
?>
<ul>
  <li <?php if(FILENAME=='clienthome.php') print('class="nav_active"'); ?>><div><a href="clienthome.php">HOME</a></div></li><?php
  if(!empty($_SESSION['type']) && ($_SESSION['type'] == 'R')) {
 ?>
  <li ><div><a href="filehandle.php?doAction=USERMANUAL">USER MANUAL</a></div></li>
  <li <?php if(FILENAME=='riginformation.php') print('class="nav_active"');?>><div><a href="riginformation.php">RIG INFORMATION</a></div></li>
  <li <?php if(FILENAME=='changepassword.php')print('class="nav_active"');?>><div><a href="changepassword.php">CHANGE PASSWORD</a></div></li><?php
}
  ?><li><div><a href="http://ariesmar.com" target="_blank">ARIES GROUP </a></div></li><?php
	  if(!empty($_SESSION['type']) && ($_SESSION['type'] == 'R')) {
 ?> <li <?php if(FILENAME=='feedback.php') print('class="nav_active"');?>><div><a href="feedback.php">FEEDBACK</a></div></li><?php
  }
  ?><li><div><a href="<?php print(FILENAME)?>?doAction=LOGOUT">LOG OUT</a></div></li>
</ul>
<span  class="user">User:<strong style='color:#EDF480;'><?php print($_SESSION['username'])?></strong></span>
</div>