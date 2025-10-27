<?php
include_once "control/feedback.class.php";
?><!doctype html>
<html lang="en">
  <head>
    <title>Aries Cloud:Feedback</title><?php
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
				location.href= path+"?doAction=DELETE_CLIENT&cleint_id="+id+"&page="+page;
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
				<div class="content"><?php
					switch($feedback->doAction) {
						case"":
							$reslt = $feedback->getFeedBack();
							$r_rec = 	$feedback->objCommonFunc->executeQuery("SELECT FOUND_ROWS() no");
							$row_rec = mysqli_fetch_assoc($r_rec);
							$total_rec = $row_rec['no'];
							$str_Feed = "";
							?><div class="subcontent">
								<span class="heading1"><strong>FEEDBACK MANAGEMENT</strong></span>
								<div class="search">
									
								</div>
								
								<table class="mainTable" cellpadding="0" cellspacing="0">
									<th >Client</th><th width="25%">User Name</th><th >Feedback</th><th >Feedback Date</th><th>View</th><?php
								while($row = $feedback->objCommonFunc->fetchAssoc($reslt)) {
									?><tr><td><?php print($row['client_name'])?></td>
									<td><?php print($row['rl_username'])?></td>
									<td><?php print(nl2br(htmlentities($row['fb_comments'])))?></td>
									<td><?php print($feedback->objCommonFunc->sql2date($row['fb_created_date']))?></td>
									<td align="center"><a href="javascript:viewfeedback('<?php print($row['fb_id'])?>')"><img src="images/view.png" height="16" width="25" title="Edit"></i></a></td>
									</tr><?php
									$str_Feed .= "<div class='infoBox' style='display:none;' id='fb_".$row['fb_id']."'>
									<span style='margin-left:240px; position:absolute;' onclick='closebox()' class='close'><strong style='color:red'>X</strong></span>";
										$str_Feed .= "<table id='infotbl'  style='margin:50px; '>";
											$str_Feed .= "<tr><td align='right'>Client Name:</td><td align='left'>".$row['client_name']."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Rig Name:</td><td  align='left'>".$row['rig_name']."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Name:</td><td  align='left'>".$row['fb_name']."".$row['fb_sur_name']."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Position:</td><td  align='left'>".$row['fb_position']."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Type of Service	:</td><td  align='left'>".$row['fb_cat_id']."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Email	:</td><td  align='left'>".$row['fb_cat_id']."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Mobile	:</td><td  align='left'>".$row['fb_email']."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Phone	:</td><td  align='left'>".$row['fb_mob_no']."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Feedback Date	:</td><td  align='left'>".$feedback->objCommonFunc->sql2date($row['fb_created_date'])."</td></tr>";
											$str_Feed .= "<tr><td align='right'>Feedback:</td><td  align='left'>".nl2br(htmlentities($row['fb_comments']))."</td>
											</tr>
										</table>
									</div>";
								}
								?></table><?php
									print $str_Feed;
									$feedback->objPagination->showPagination($total_rec,FILENAME);
							?></div><?php
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
	<script src="js/jquery.js"></script>  
 <script>  
	function viewfeedback(id) {
		dialog.hide();
		$('#fb_'+id).show();
	}
var win = $( window );
	var dialog = $(".infoBox" );
var top = (win.height() - dialog.height()) /600;
var left = (win.width() - dialog.width()) / 200;
var top1 = (win.height() - dialog.height()) / 600;
var left1 = (win.width() - dialog.width()) / 200;
var close = $(".close");
close.css({
    position: "absolute",
    top: top1,
    left: left1
});
dialog.css({
    position: "absolute",
    top: top,
    left: left
});
function closebox() {
	dialog.hide();
}
 </script>  
   </body>
</html>