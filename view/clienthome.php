<?php
include_once "control/display_report.class.php";
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
		function frmSubmit(objFrm) {
			if(objFrm.txtClientName.value=="") {
				document.getElementById('client').style.display="block";
				objFrm.txtClientName.focus();
				return false;
			}
			else {
				document.getElementById('client').style.display="none";
			}

			if(objFrm.txtRig.value=="") {
				document.getElementById('rig').style.display="block";
				objFrm.txtRig.focus();
				return false;
			}
			else {
				document.getElementById('rig').style.display="none";
			}

			if(objFrm.txtCat.value=="") {
				document.getElementById('cat').style.display="block";
				objFrm.txtCat.focus();
				return false;
			}
			else {
				document.getElementById('cat').style.display="none";
			}

			if(objFrm.txtTagno.value=="") {
				document.getElementById('tagno').style.display="block";
				objFrm.txtTagno.focus();
				return false;
			}
			else {
				document.getElementById('tagno').style.display="none";
			}

			

			if(objFrm.txtInspectionDate.value=="") {
				document.getElementById('InspectionDate').style.display="block";
				objFrm.txtInspectionDate.focus();
				return false;
			}
			else {
				document.getElementById('InspectionDate').style.display="none";
			}

			if(objFrm.txtNextInspectionDate.value=="") {
				document.getElementById('NextInspectionDate').style.display="block";
				objFrm.txtNextInspectionDate.focus();
				return false;
			}
			else {
				document.getElementById('NextInspectionDate').style.display="none";
			}

			

			if(objFrm.txtComments.value=="") {
				document.getElementById('Comments').style.display="block";
				objFrm.txtComments.focus();
				return false;
			}
			else {
				document.getElementById('Comments').style.display="none";
			}
			<?php if(!empty($_REQUEST['doAction'])&&$_REQUEST['doAction']=='ADD') {?>
			if(objFrm.txtFile && objFrm.txtFile.value=="") {
				document.getElementById('File').style.display="block";
				objFrm.txtFile.focus();
				return false;
			}
			else {
				document.getElementById('File').style.display="none";
			}<?php
			}
			?>
			<?php if(!empty($_REQUEST['doAction'])&&$_REQUEST['doAction']=='ADD') {?>
			if(objFrm.txtFile && objFrm.txtFile2.value=="") {
				document.getElementById('File2').style.display="block";
				objFrm.txtFile2.focus();
				return false;
			}
			else {
				document.getElementById('File2').style.display="none";
			}<?php
			}
			?>//startUpload();
			//return false;
			
		}
		/*Function for deleting records*/
		function deleteRec(path,id,page) {
			if(confirm('Are you sure to delete this record')) {
				location.href= path+"?doAction=DELETE_REPORT&rep_id="+id+"&page="+page;
			}
		}

		function loadXMLDoc(cat_id)
		{
			
			var xmlhttp;
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				 
				  document.getElementById("sub_category").innerHTML= "";
					document.getElementById("sub_category").innerHTML=xmlhttp.responseText;
				}
			  }

			xmlhttp.open("GET","ajax.php?doAction=SELECTSUBCAT&cat_id="+cat_id,true);
			var params = "doAction=SELECTSUBCAT&cat_id="+cat_id;
			xmlhttp.send();
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			http.setRequestHeader("Content-length", params.length);
			http.setRequestHeader("Connection", "close");
			
		}
		/*Function for date picker*/
		function init() {
			calendar.set("txtInspectionDate");
			calendar.set("txtNextInspectionDate");
			calendar.set("txtTestproof");
			calendar.set("txtNextTestproof");
			calendar.set("txtDateTpi");
			calendar.set("txtNextDateTpi");
		}
		/*Function for adding category*/
		function AddCategory() {
			if(document.getElementById('txtCat').value=="") {
				
				document.getElementById('cat').style.display="block";
				document.getElementById('txtCat').focus();
				document.getElementById('info_box').style.display="none";
			}
			else {
				document.getElementById('cat').style.display="none";
				document.getElementById('info_box').style.display="";
				document.getElementById('cat_id').value = document.getElementById('txtCat').value;
			}
		}
		/*Function for selecting category*/
		function cancelCategory(){
			document.getElementById('info_box').style.display="none";
		}
		/*Function for sub mitting category*/
		function  submitCategory() {
			var sub_category = document.getElementById('sub_cat_id').value;
			var category = document.getElementById('cat_id').value;
			var xmlhttp;
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				 
				  document.getElementById("sub_category").innerHTML= "";
					document.getElementById("sub_category").innerHTML=xmlhttp.responseText;
					document.getElementById('info_box').style.display="none";
				}
			  }

			xmlhttp.open("GET","ajax.php?doAction=ADDSUBCATEGORY&cat_id="+category+'&sub_cat_id='+sub_category,true);
			var params = "doAction=SELECTSUBCAT&cat_id="+cat_id;
			xmlhttp.send();
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			http.setRequestHeader("Content-length", params.length);
			http.setRequestHeader("Connection", "close");
		}
		
  </script>
   <script type="text/javascript" src="../js/script.js"></script>
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
					switch($display_report->doAction) {
						case"":
							$reslt = $display_report->getExpiredReportInfo();
							$r_rec = 	$display_report->objCommonFunc->executeQuery("SELECT FOUND_ROWS() no");
							$row_rec = mysqli_fetch_assoc($r_rec);
							$total_rec = $row_rec['no'];
							?><div class="subcontent">
								<span class="heading1"><strong style="color:red;">REPORT MANAGEMENT-EXPIRY LIST</strong></span>
								<div class="search">
									
										<form method="post" action="<?php print(FILENAME)?>">
										<table border="0" width="100%" align='center'>
										<td width="25%">Search Key &nbsp;<input type="text" name="txtFilterName" value="<?php print($display_report->txtFilterName)?>" class="txtfield" size="20"/></td>
										<td align='left' width="25%"><input type="submit" value="SEARCH" class="button1"/>
										<a href="<?php print(FILENAME)?>?doAction=CLEAR" class="button1">CLEAR</a></td>
										<td align='right' width="50%"><a href="expirylist_excel.php" class="button1">EXPORT&nbsp;TO&nbsp;EXCEL</a></td>
										</tr>
										</table>
										</form>
									
								</div>
								
								<table class="mainTable" cellpadding="0" cellspacing="0">
									<th width="20%" >Reference number</th><th width="25%">Category</th><th width="25%">Sub Category</th><th width="10%">Inspection Date</th><th width="2%">Next Inspection</th><th width="2%">Comments</th><th colspan="4">Actions</th><?php
								while($row = $display_report->objCommonFunc->fetchAssoc($reslt)) {
									$strView="";
									$no_of_files = $row['no_of_files'];
									
									if(!empty($row['rep_file2'])) {
										$strView .='<a href="filehandle.php?rep_id='.$row['rep_id'].'&type=1" " title="View Part1"><img src="images/view.png" height="16" width="25" title="View" target="_blank"></a><br/>'; 
									}
									else if(!empty($row['rep_file3'])) {
										$strView .='<a href="filehandle.php?rep_id='.$row['rep_id'].'&type=2"  title="View Part1"><img src="images/download.png" height="16" width="25" title="View" target="_blank"></a><br/>';
									}
									else if(!empty($row['rep_file4'])) {
										$strView .='<a href="filehandle.php?rep_id='.$row['rep_id'].'&type=3"  title="View Part1"><img src="images/download.png" height="16" width="25" title="View" target="_blank"></a><br/>';
									}
									else if(!empty($row['rep_file5'])) {
										$strView .='<a href="filehandle.php?rep_id='.$row['rep_id'].'&type=4"  title="View Part1"><img src="images/download.png" height="16" width="25" title="View" target="_blank"></a><br/>';
									}
									?><tr><td><?php print($row['rep_desc'])?></td>
									<td><?php print($row['cat_name'])?></td>
									<td><?php print($row['subcat_name'])?></td>
									<td><?php print($display_report->objCommonFunc->sql2date($row['rep_insp_date']))?></td>
									<td><strong style='color:red;'><?php print($display_report->objCommonFunc->sql2date($row['rep_next_insp_date']))?></strong></td>
									<td><?php print($row['rep_comments'])?></td>
									<td align="center"><a href="filehandle.php?rep_id=<?php print($row['rep_id'])?>&doAction=DOWNLOAD"><img src="images/download.png" height="16" width="25" title="Download" target="_blank"></i></a></td><?php
									if(!empty($strView)) {
									?><td align="center"><?php print($strView)?></td></tr><?php
									}
									else {
										?><td></td><?php
									}
								}
								?></table><?php
									$display_report->objPagination->showPagination($total_rec,FILENAME);
							?></div><?php
							break;
						
					}
				?></div>
				<!-- Content end -->
				
				<!-- footer start --><?php
			include_once "model/footer.php";
			?><!-- footer end -->
		</div><?php
		$reslt1 = $display_report->getExpiredReportInfo();
		if(empty($_SESSION['infobox'])) {
		?><div class='infoBox2' style='display:none;' id='info_box'>
		<span style='margin-left:-9%; position:absolute;' onclick='closebox()' class="close"><strong style='color:red'>X</strong></span>
			<?php
			if($_SESSION['days'] >= 180) {
				?><br/><br/><span style='color:red; text-align:center;margin-left:20%;margin-top:-20%''><strong><a href='changepassword.php' style='color:red;'>Your pass word life time exceeds six months. Please change your password</a></strong></span><br/><br/><?php
			}
			else if($display_report->objCommonFunc->getNumRows($reslt1)<=0) {
				$_SESSION['infobox'] = 'Y';
			}
			?><br><span class="heading1" style='margin-left:35%'><strong style="color:red;">REPORT MANAGEMENT-EXPIRY LIST</strong></span><br>
			<table cellpadding="0" cellspacing="0" border="1" width="50%"  class="alertTable" align="center">
				<th>Reference number</th><th >Category</th><th >Sub Category</th><th>Inspection Date</th><th >Next Inspection</th><th width="2%">Comments</th><th colspan="4">Actions</th><?php
				while($row = $display_report->objCommonFunc->fetchAssoc($reslt1)) {
					$strView="";
					$no_of_files = $row['no_of_files'];
					
					if(!empty($row['rep_file2'])) {
						$strView .='<a href="filehandle.php?rep_id='.$row['rep_id'].'&type=1" " title="View Part1"><img src="images/view.png" height="16" width="25" title="View" target="_blank"></a><br/>'; 
					}
					else if(!empty($row['rep_file3'])) {
						$strView .='<a href="filehandle.php?rep_id='.$row['rep_id'].'&type=2"  title="View Part1"><img src="images/download.png" height="16" width="25" title="View" target="_blank"></a><br/>';
					}
					else if(!empty($row['rep_file4'])) {
						$strView .='<a href="filehandle.php?rep_id='.$row['rep_id'].'&type=3"  title="View Part1"><img src="images/download.png" height="16" width="25" title="View" target="_blank"></a><br/>';
					}
					else if(!empty($row['rep_file5'])) {
						$strView .='<a href="filehandle.php?rep_id='.$row['rep_id'].'&type=4"  title="View Part1"><img src="images/download.png" height="16" width="25" title="View" target="_blank"></a><br/>';
					}
					?><tr><td><?php print($row['rep_desc'])?></td>
					<td><?php print($row['cat_name'])?></td>
					<td><?php print($row['subcat_name'])?></td>
					<td><?php print($display_report->objCommonFunc->sql2date($row['rep_insp_date']))?></td>
					<td><strong style='color:red;'><?php print($display_report->objCommonFunc->sql2date($row['rep_next_insp_date']))?></strong></td>
					<td><?php print($row['rep_comments'])?></td>
					<td align="center"><a href="filehandle.php?rep_id=<?php print($row['rep_id'])?>&doAction=DOWNLOAD"><img src="images/download.png" height="16" width="25" title="Download" target="_blank"></i></a></td><?php
					if(!empty($strView)) {
					?><td align="center"><?php print($strView)?></td></tr><?php
					}
					else {
						?><td></td><?php
					}
				}
			?></table>
		</div><?php
		}
   ?></body>
</html>
 <script src="js/jquery.js"></script>  
 <script src="js/jquery.form.js"></script>  
 <script>  <?php
 if(empty($_SESSION['infobox'])) {
 ?>(function() {  
	 var win = $( window );
	var dialog = $(".infoBox2");
	var close = $(".close");
var top = (win.height() - dialog.height()) / 2;
var left = (win.width() - dialog.width()) / 2;
dialog.css({
    position: "absolute",
    top: top,
    left: left
});
close.css({
    position: "absolute",
    top: 10,
    left: left+550
});
 $(".main").css("opacity",0.2).fadeIn(300, function () {   
		$('#info_box').show();
        $('#info_box').css({'position':'aboslute','z-index':99999});
     });
 })(); <?php
   }
 ?>
 function closebox() {
	$('#info_box').hide();
	 $(".main").css("opacity",1);
    $('".main').fadeOut('slow');
}
 </script>  <?php
 $_SESSION['infobox'] = 'Y';
 ?>