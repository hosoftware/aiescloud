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
				<div class="content"><?
					switch($display_report->doAction) {
						case"":
							$reslt = $display_report->getReportInfo();
					$r_rec = 	$display_report->objCommonFunc->executeQuery("SELECT FOUND_ROWS() no");
							$row_rec = mysqli_fetch_assoc($r_rec);
							$total_rec = $row_rec['no'];
							?><div class="subcontent">
								<span class="heading1"><strong>REPORT MANAGEMENT</strong></span>
								<div class="search">
										<form method="post" action="<?php print(FILENAME)?>">
										<table border="0" width='100%'>
										<td>Reference number.</td>
										<td><input type="text" name="txtFilterName" value="<?php print($display_report->txtFilterName)?>" class="txtfield" size="20"/></td>
										<td>Inspection Date</td>
										<td><input type='text' name='txtInspectionDate' id='txtInspectionDate' size="10" value="<?php print($display_report->txtInspectionDate)?>" class="txtfield" /></td>
										<td>Next  Date</td>
										<td><input type='text' name='txtNextInspectionDate' id='txtNextInspectionDate' size="10" value="<?php print($display_report->txtNextInspectionDate)?>" class="txtfield" /></td>
										<td><input type="submit" value="SEARCH" class="button1"/></td>
										<td><a href="<?php print(FILENAME)?>?doAction=CLEAR" class="button1">CLEAR</a></td>
										</table>
										</form>
									
								</div>
								
								<table class="mainTable" cellpadding="0" cellspacing="0">
									<th width="20%" >Reference number</th><th width="25%">Category</th><th width="25%">Sub Category</th><th width="10%">Inspection Date</th><th width="2%">Next Inspection</th><th width="2%">Comments</th><th width="2%">Uploaded Date</th>
									<th colspan="4">Actions</th><?php
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
									<td><?php print($display_report->objCommonFunc->sql2date($row['rep_next_insp_date']))?></td>
									<td><?php print($row['rep_comments'])?></td>
									<td><?php print($display_report->objCommonFunc->sql2date($row['rep_created_date']))?></td>
									<td align="center"><a href="filehandle.php?rep_id=<?php print($row['rep_id'])?>&doAction=DOWNLOAD"><img src="images/download.png" height="16" width="25" title="Download" target="_blank"></i></a></td><?php
									if(!empty($strView)) {
									?><td align="center"><?php print($strView)?></td></tr><?php
									}
									else {
										?><td></td><?php
									}
								}
								?></table><?php
									$display_report->objPagination->showPagination($total_rec,FILENAME,$display_report->params);
							?></div><?php
							break;
						
					}
				?></div>
				<!-- Content end -->
				<div class='infoBox' style='display:none;' id='info_box'>
					<form > 
					   <div class='info-content'>
						<label>Sub Category</label><input type='text' name='sub_cat_id' id='sub_cat_id' value='' class="txtfield" size="35"/><br/>
						<input class="button1" type='button' value='SUBMIT' onclick="javascript:submitCategory()"/><a class="button1" href="javascript:cancelCategory()">CANCEL</a>
						<input type="hidden" name='cat_id' id='cat_id' value=''/>
					  </div>
					</form>
				</div>
				<!-- footer start --><?php
			include_once "model/footer.php";
			?><!-- footer end -->
		</div>
   </body>
</html>
 <script src="js/jquery.js"></script>  
 <script src="js/jquery.form.js"></script>  
 <script>  
 (function() {  
 var bar = $('.bar');  
 var percent = $('.percent');  
 var status = $('#status');  
 var errMsg = $('#errMsg');  
 $('#myForm').ajaxForm({  
   beforeSend: function() {  
     status.empty();  
     var percentVal = '0%';  
     bar.width(percentVal)  
     percent.html(percentVal);  
   },  
   uploadProgress: function(event, position, total, percentComplete) {  
     var percentVal = percentComplete + '%';  
     bar.width(percentVal)  
     percent.html(percentVal);  
   },  
   complete: function(xhr) {  
     bar.width("100%");  
     percent.html("100%");
	 if(xhr.responseText == 'SUCCESS') {
		 location.href="<?php print(FILENAME)?>";
	 }
	 else {
		 errMsg.html(xhr.responseText);
	 }
   }  
 });   
 })();      
 </script>  