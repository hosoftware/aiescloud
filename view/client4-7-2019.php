<?php
include_once "control/client.class.php";
?><!doctype html>
<html lang="en">
  <head>
     <title>Aries Cloud</title><?php
	include_once "model/headerlinks.php";
  ?><script language="javascript">
		function frmSubmit(objFrm) {
			if(objFrm.txtName.value=="") {
				document.getElementById('name').style.display="block";
				return false;
			}
			else {
				document.getElementById('name').style.display="none";
			}
		}
		/*Function for deleting records*/
		function deleteRec(path,id,page) {
			if(confirm('Are you sure to delete this record')) {
				location.href= path+"?doAction=DELETE_CLIENT&client_id="+id+"&page="+page;
			}
		}
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
					switch($client->doAction) {
						case"":
							$reslt = $client->getClientInfo();
							$total_rec = mysql_result(mysql_query("SELECT FOUND_ROWS()"),0,0);
							?><div class="subcontent">
								<span class="heading1"><strong>CLIENT MANAGEMENT</strong></span>
								<div class="search"><?php
								if(!empty($_REQUEST['errMsg'])) {
								?><div id="errMsg">
										Sorry! you can't delete this client . There are some reports/rigs exists under this client.
								  </div><?php
								}
								?>
								<table width='100%'>
									<tr>
										<td>
											<div class="div_left">
												<form method="post" action="<?php print(FILENAME)?>">
												<input type="text" name="txtFilterName" value="<?php print($client->txtFilterName)?>" class="txtfield" size="30"/>
												<input type="submit" value="SEARCH" class="button1"/>
												<a href="<?php print(FILENAME)?>?doAction=CLEAR" class="button1">CLEAR</a>
												</form>
											</div>
										</td>
										<td align='right'>
											
												<form method="post" action="<?php print(FILENAME)?>">
												<input type="hidden" name="doAction" value="ADD"/>
												<span style="float:right;"><input type="submit" value="ADD" class="button1"/></span>
												</form>
										</td>
									</tr>
									</table>
									
								</div>
								
								<table class="mainTable" cellpadding="0" cellspacing="0">
									<th width="50%" >Name</th><th width="25%">Edit</th><th width="25%">Delete</th><?php
								while($row = $client->objCommonFunc->fetchAssoc($reslt)) {
									?><tr><td><?php print($row['client_name'])?></td>
									<td align="center"><a href="<?php print(FILENAME)?>?client_id=<?php print($row['client_id'])?>&doAction=EDIT"><img src="images/edit.jpeg" height="16" width="25" title="Edit"></i></a></td>
									<td align="center"><a href="javascript:deleteRec('<?php print(FILENAME)?>','<?php print($row['client_id'])?>','<?php print($client->page)?>')"><img src="images/delete.png" height="16" width="25" title="Delete"></i></a></td></tr><?php
								}
								?></table><?php
									$client->objPagination->showPagination($total_rec,FILENAME,$client->params);
							?></div><?php
							break;
						case"ADD":
						case"EDIT":
							if(isset($_REQUEST['client_id'])){
								$arrInfo = $client->objCommonFunc->getSingleRecInfo('*',"clients","client_id=".$_REQUEST['client_id']."");
								$_REQUEST['txtName'] = $arrInfo['client_name'];
								$heading = "CLIENT MANAGEMENT- Edit Client ";
							}
							else {
								$heading = "CLIENT MANAGEMENT- Add Client";
							}
							if(empty($_REQUEST['txtName'])) {
								$_REQUEST['txtName'] = "";
							}
							?><div class="subcontent">
								<div class="search">
								<span class="heading1"><strong><?php print($heading)?></strong></span>
								</div>
								<div class="frm-content">
									<form method="post" action="<?php print(FILENAME)?>" onsubmit="return frmSubmit(this)">
										<table border="0" align="center" >
											<tr>
												<td>Client Name<strong class="astric">*</strong></td><td><input type="text" name="txtName" value="<?php print(htmlentities($_REQUEST['txtName'],ENT_QUOTES))?>" class="txtfield" size="30"/>
												<div class="arrow_box" id='name' style="display:none;">Please enter Client name<div>
												</td>
											</tr>
											<tr>
												<td align="center" colspan="2"><input type="submit" value="SUBMIT" class="button1"/>&nbsp;&nbsp;<a href="<?php print(FILENAME)?>" class="button1">CANCEL</a></td>
											</tr>
										</table>
										<input type='hidden' name='page' value="<?php print($client->page)?>"/>
										<input type='hidden' name='client_id' value="<?php print($client->client_id)?>"/>
										<?php
										if(!empty($_REQUEST['client_id'])) {
											?><input type='hidden' name='doAction' value="UPDATE_CLIENT"/><?php
										}
										else {
											?><input type='hidden' name='doAction' value="ADD_CLIENT"/><?php
										}
									?></form>
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