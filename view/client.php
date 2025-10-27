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
		function frmSubmit1(objFrm) {
			if(objFrm.clientName.value=="") {
				document.getElementById('client').style.display="block";
				return false;
			}
			else {
				document.getElementById('client').style.display="none";
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
							$r_rec = 	$client->objCommonFunc->executeQuery("SELECT FOUND_ROWS() no");
							$row_rec = mysqli_fetch_assoc($r_rec);
							$total_rec = $row_rec['no'];
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
											
												<form method="post" action="<?php print(FILENAME)?>?doAction=ADD">
												<input type="hidden" name="doAction" value="ADD"/>
												<span style="float:right;"><input type="submit" value="ADD" class="button1"/></span>
												</form>
										</td>
									</tr>
									</table>
									
								</div>
								
								<table class="mainTable" cellpadding="0" cellspacing="0">
									<th width="6%" >Sl No</th><th width="50%" >Name</th>
									<th width="10%">No Rigs</th><th width="10%">No Reports</th>
									<th width="8%">Edit</th><th width="8%">Transfer</th>
									<th width="8%">Delete</th><?php
							    $cnt=1;
								if(isset($_REQUEST['page']) && $_REQUEST['page']>1)
								{
									for($i=1;$i<$_REQUEST['page'];$i++)
									{
										$cnt=$cnt+18;
									}
								}
								
								while($row = $client->objCommonFunc->fetchAssoc($reslt)) {
									
									$Rep = $client->isReportscnt($row['client_id']);
									$Rig = $client->isRigscnt($row['client_id']);
									?><tr><td><?php print $cnt; ?></td><td><?php print($row['client_name'])?></td>
									<td align="center"><?php if($Rig>0){print $Rig;} ?></td><td align="center"><?php if($Rep>0){print $Rep;} ?></td>
									<td align="center"><a href="<?php print(FILENAME)?>?client_id=<?php print($row['client_id'])?>&doAction=EDIT"><img src="images/edit.jpeg" height="16" width="25" title="Edit"></i></a></td>
									<?php if($Rep==0 && $Rig==0){ ?>	
									<td align="center"></td>
									<td align="center"><a href="javascript:deleteRec('<?php print(FILENAME)?>','<?php print($row['client_id'])?>','<?php print($client->page)?>')"><img src="images/delete.png" height="16" width="25" title="Delete"></i></a></td>
									<?php }else{ ?>
									<td align="center"><a href="<?php print(FILENAME)?>?client_id=<?php print($row['client_id'])?>&doAction=Transfer"><img src="images/edit.jpeg" height="16" width="25" title="Edit"></i></a></td>
									<td align="center"></td><?php } ?>
									</tr><?php
									$cnt++;
									
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
									   <?php if(isset($_REQUEST['error']) && $_REQUEST['error']==1)
									   {?>
										<div style="color:red;text-align:center;">This Client Already exist</div>
									   <?php 
									   }
									   ?>
										<table border="0" align="center" >
											<tr>
												<td>Client Name<strong class="astric">*</strong></td><td><input type="text" name="txtName" value="<?php print(htmlentities($_REQUEST['txtName'],ENT_QUOTES))?>" class="txtfield" size="30"/>
												<div class="arrow_box" id='name' style="display:none;">Please enter Client name</div>
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
						    case"Transfer":
							$reslt1 = $client->getClientData($_REQUEST['client_id']);
							
							if(isset($_REQUEST['client_id'])){
								$arrInfo = $client->objCommonFunc->getSingleRecInfo('*',"clients","client_id=".$_REQUEST['client_id']."");
								
								$heading = "CLIENT MANAGEMENT- Transfer Client Details";
							}
							
							?><div class="subcontent">
								<div class="search">
								<span class="heading1"><strong><?php print($heading)?></strong></span>
								</div>
								<div class="frm-content">
									<form method="post" action="<?php print(FILENAME)?>" onsubmit="return frmSubmit1(this)">
										<table border="0" align="center" >
											<tr>
												<td><strong>Client Name : </strong></td><td><?php echo $arrInfo['client_name']; ?>											
												</td>
											</tr>
											<tr>
												<td>Transfer To<strong class="astric">*</strong></td><td><select name="clientName" id="clientName"  class="txtfield"><option value=""></option><?php
													while($row = $client->objCommonFunc->fetchAssoc($reslt1)) {
														if($row['rep_id']!='' && $row['rep_id']!='')
														{
														?><option value="<?php print($row['client_id'])?>"><?php echo $row['client_name'].'-'.$row['client_id'] ?></option><?php
														}
													}
												?></select>
												
												
												<div class="arrow_box" id='client' style="display:none;">Please enter Cleint Name</div>
												</td>
											</tr>
											<tr>
												<td align="center" colspan="2"><input type="submit" value="SUBMIT" class="button1"/>&nbsp;&nbsp;<a href="<?php print(FILENAME)?>" class="button1">CANCEL</a></td>
											</tr>
										</table>
										<input type='hidden' name='page' value="<?php print($client->page)?>"/>
										<input type='hidden' name='client_id' value="<?php print($client->client_id)?>"/>
										<input type='hidden' name='doAction' value="TRANSFER_CLIENT"/>
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