<?php
include_once "control/rig.class.php";
?><!doctype html>
<html lang="en">
  <head>
    <title> <title>Aries Cloud:Rig Info</title></title><?php
	include_once "model/headerlinks.php";
  ?><script language="javascript">
		
		
  </script>
  </head>
   <body>
		<div class="main"><!-- topbar start --><?php
			include_once "model/topbar.php";
			?><!-- topbar end -->
			<!-- navigation bar start--><?php
			include_once "model/navigation.php";
			?><!-- navigation bar end-->
				<!-- left bar start --><?php
			include_once "model/leftbar.php";
			?><div class="clear">
				</div>
				<!-- left bar end -->
				<!-- Content start -->
				<div class="content"><?
					switch($rig->doAction) {
						case"":
							$heading = "RIG INFORMATION";
							
							if(empty($_REQUEST['txtPassword'])) {
								$_REQUEST['txtPassword'] = "";
							}
							if(empty($_REQUEST['txtRPassword'])) {
								$_REQUEST['txtRPassword'] = "";
							}
							
							$arrInfo = $rig->objCommonFunc->getSingleRecInfo("*","rigs left join clients ON client_id=rig_client_id","rig_id=".$_SESSION['user_id']);
							?><div class="subcontent">
								<div class="search">
								<span class="heading1"><strong><?php print($heading)?></strong></span><?php
								
								?></div>
								<div class="frm-content">
									<form method="post" action="<?php print(FILENAME)?>" onsubmit="return frmPassSubmit(this)">
										<table border="0" align="center" ><?php
											?><tr>
												<td><strong>Rig</strong></td><td>:<?php print($arrInfo['rig_name'])?></td>
											</tr>
											<tr>
												<td><strong>IMO number</strong></td><td>:<?php print($arrInfo['rig_imo_no'])?></td>
											</tr>
											<tr>
												<td><strong>Rig Manager</strong></td><td>:<?php print($arrInfo['rig_manager'])?></td>
											</tr>
											<tr>
												<td><strong>Rig Type</strong></td><td>:<?php print($arrInfo['rig_type'])?></td>
											</tr>
											<tr>
												<td><strong>Rig Classification</strong></td><td>:<?php print($arrInfo['rig_classification'])?></td>
											</tr>
											<tr>
												<td><strong>Client</strong></td><td>:<?php print($arrInfo['client_name'])?></td>
											</tr>
											
											<?php
											?>
										</table>
										<input type='hidden' name='doAction' value="ADDFEEDBACK"/>
									</form>
								</div>
							</div><?php
							break;
					}
				?></div>
				<!-- Content end -->
				<div class="clear">
				</div>
				<!-- footer start --><?php
			include_once "model/footer.php";
			?><!-- footer end -->
		</div>
   </body>
</html>