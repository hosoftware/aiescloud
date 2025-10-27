<?php
include_once "control/passwordrequest.class.php";
?><!doctype html>
<html lang="en">
  <head>
     <title>Aries Cloud</title><?php
	include_once "model/headerlinks.php";
  ?><style>  
 .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }  
 .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }  
 .percent { position:absolute; display:inline-block; top:3px; left:48%; }  
 </style>  
 <script language="javascript">
		/*Function for date picker*/
		function init() {
			calendar.set("txtInspectionDate");
			calendar.set("txtNextInspectionDate");
			
		}
  </script>
  </head>
   <body onload="init()">
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
				<div class="content"><?php
					switch($passwordrequest->doAction) {
						case"":
							$reslt = $passwordrequest->getRequestList();
							$r_rec = $passwordrequest->objCommonFunc->executeQuery("SELECT FOUND_ROWS()");
							$row_rec = mysqli_fetch_assoc($r_rec);
							$total_rec = $row_rec['no'];
							?><div class="subcontent">
								<span class="heading1"><strong style="color:red;">PASSWORD REQUEST LIST</strong></span>
								<div class="search">
										<form method="post" action="<?php print(FILENAME)?>">
										<table border="0" width="100%">
										<tr><td>Name</td>
										<td><input type="text" name="txtFilterName" value="<?php print($passwordrequest->txtFilterName)?>" class="txtfield" size="20"/></td>
										<td>From Date</td>
										<td><input type='text' name='txtInspectionDate' id='txtInspectionDate' size="10" value="<?php print($passwordrequest->txtInspectionDate)?>" class="txtfield"/></td>
										<td>To  Date</td>
										<td><input type='text' name='txtNextInspectionDate' id='txtNextInspectionDate' size="10" value="<?php print($passwordrequest->txtNextInspectionDate)?>" class="txtfield"/></td>
										
										<td colspan="3" align='right'><input type="submit" value="SEARCH" class="button1"/></td>
										<td colspan="3" align='left'><a href="<?php print(FILENAME)?>?doAction=CLEAR" class="button1">CLEAR</a></td></tr>
										</table>
										</form>
									
								</div>
								
								<table class="mainTable" cellpadding="0" cellspacing="0">
									<th width="20%" >Name</th><th width="25%">Email</th><th width="25%">Phone</th><th width="10%">Sent Date</th><?php
								while($row = $passwordrequest->objCommonFunc->fetchAssoc($reslt)) {
									$strView="";
									
									?><tr><td><?php print($row['name'])?></td>
									<td><?php print($row['email'])?></td>
									<td><?php print($row['phone'])?></td>
									<td><?php print($passwordrequest->objCommonFunc->sql2date($row['send_date']))?></td>
									<?php
								}
								?></table><?php
									$passwordrequest->objPagination->showPagination($total_rec,FILENAME);
							?></div><?php
							break;
						
					}
				?></div>
				<!-- Content end -->
				
				<!-- footer start --><?php
			include_once "model/footer.php";
			?><!-- footer end -->
		</div>
			<?php
		
   ?></body>
</html>