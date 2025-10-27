<?php
include_once "control/feedback.class.php";
?><!doctype html>
<html lang="en">
  <head>
     <title>Aries Cloud</title><?php
	include_once "model/headerlinks.php";
  ?><script language="javascript">
		
		/*Function for submitting Password*/
		function frmPassSubmit(objFrm) {
			if(objFrm.txtName.value=="") {
				document.getElementById('name').style.display="block";
				objFrm.txtName.focus();
				return false;
			}
			else {
				document.getElementById('name').style.display="none";
			}

			if(objFrm.txtSurName.value=="") {
				document.getElementById('surname').style.display="block";
				objFrm.txtSurName.focus();
				return false;
			}
			else {
				document.getElementById('surname').style.display="none";
				
			}

			if(objFrm.txtPosition.value=="") {
				document.getElementById('Position').style.display="block";
				objFrm.txtPosition.focus();
				return false;
			}
			else {
				document.getElementById('Position').style.display="none";
				
			}

			if(objFrm.txtService.value=="") {
				document.getElementById('Service').style.display="block";
				objFrm.txtService.focus();
				return false;
			}
			else {
				document.getElementById('Service').style.display="none";
				
			}

			if(objFrm.txtEmail.value=="") {
				document.getElementById('Email').style.display="block";
				objFrm.txtEmail.focus();
				return false;
			}
			else {
				document.getElementById('Email').style.display="none";
				
			}

			if(objFrm.txtMobile.value=="") {
				document.getElementById('Mobile').style.display="block";
				objFrm.txtMobile.focus();
				return false;
			}
			else {
				document.getElementById('Mobile').style.display="none";
				
			}

			if(objFrm.txtPhone.value=="") {
				document.getElementById('Phone').style.display="block";
				objFrm.txtPhone.focus();
				return false;
			}
			else {
				document.getElementById('Phone').style.display="none";
				
			}

			if(objFrm.txtComments.value=="") {
				document.getElementById('Comments').style.display="block";
				objFrm.txtComments.focus();
				return false;
			}
			else {
				document.getElementById('Comments').style.display="none";
				
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
					switch($feedback->doAction) {
						case"":
							$heading = "FEEDBACK";
							
							if(empty($_REQUEST['txtPassword'])) {
								$_REQUEST['txtPassword'] = "";
							}
							if(empty($_REQUEST['txtRPassword'])) {
								$_REQUEST['txtRPassword'] = "";
							}
							
							$rsl1 = $feedback->getClientNameList();
							?><div class="subcontent">
							<table border="0">
								
								<tr>
									<td><div><p><b>Aries Marine and Engineering Services</b></p> <br />
							P.O. Box : 24496, Tower 400, 20th Floor,<br/>
							Mina Road, Sharjah, UAE.<br />
							Tel  	: 	+971 6 5503300<br />
							Fax 	: 	+971 6 5503100<br />
							Email 	: <a class="style1" href="mailto:ariesmar@eim.ae">ariesmar@eim.ae</a><br />
						</div></td>
									<td><iframe width="500" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Aries+Marine+and+Engineering+Services+-+Tower+400,+20th+Floor,+Mina+Road+-+Al+Arouba+Street+-+Sharjah+-+United+Arab+Emirates&amp;aq=0&amp;oq=Aries+&amp;sll=10.54063,76.128318&amp;sspn=6.196797,10.821533&amp;ie=UTF8&amp;hq=Aries+Marine+and+Engineering+Services+-+Tower+400,+20th+Floor,+Mina+Road+-+Al+Arouba+Street+-&amp;hnear=Sharjah+-+United+Arab+Emirates&amp;ll=25.351846,55.385167&amp;spn=0.001391,0.002642&amp;t=h&amp;z=14&amp;iwloc=A&amp;cid=9810733433959683550&amp;output=embed"></iframe></td>
								</tr>
								</table>
								<div class="search">
								<span class="heading1"><strong><?php print($heading)?></strong></span><?php
								if(!empty($_REQUEST['errMsg'])) {
									?><br/><span style='color:green;'><strong >Feedback sent succefully.</strong></span><?php
								}
								?></div>
								<div class="frm-content">
									<form method="post" action="<?php print(FILENAME)?>" onsubmit="return frmPassSubmit(this)">
										<table border="0" align="center" ><?php
											?><tr>
												<td>Name<strong class="astric">*</strong></td><td><input type="text" name="txtName" value="" class="txtfield" size="30" id="txtName"/>
												<div class="arrow_box" id='name' style="display:none;">Please enter Name<div>
												</td>
											</tr>
											<tr>
												<td>Surname<strong class="astric">*</strong></td><td><input type="text" name="txtSurName" value="" class="txtfield" size="30" id="txtSurName"/>
												<div class="arrow_box" id='surname' style="display:none;">Please enter Surname<div>
												</td>
											</tr>
											<tr>
												<td>Position<strong class="astric">*</strong></td><td><input type="text" name="txtPosition" value="" class="txtfield" size="30" id="txtPosition"/>
												<div class="arrow_box" id='Position' style="display:none;">Please enter Position<div>
												</td>
											</tr>
											<tr>
												<td>Type of Service<strong class="astric">*</strong></td><td><input type="text" name="txtService" value="" class="txtfield" size="30" id="txtService"/>
												<div class="arrow_box" id='Service' style="display:none;">Please enter Type of Service<div>
												</td>
											</tr>
											<tr>
												<td>Email<strong class="astric">*</strong></td><td><input type="text" name="txtEmail" value="" class="txtfield" size="30" id="txtEmail"/>
												<div class="arrow_box" id='Email' style="display:none;">Please enter Email<div>
												</td>
											</tr>
											<tr>
												<td>Mobile<strong class="astric">*</strong></td><td><input type="text" name="txtMobile" value="" class="txtfield" size="30" id="txtMobile"/>
												<div class="arrow_box" id='Mobile' style="display:none;">Please enter Email<div>
												</td>
											</tr>
											<tr>
												<td>Phone<strong class="astric">*</strong></td><td><input type="text" name="txtPhone" value="" class="txtfield" size="30" id="txtPhone"/>
												<div class="arrow_box" id='Mobile' style="display:none;">Please enter Phone<div>
												</td>
											</tr>
											<tr>
												<td>Comments<strong class="astric">*</strong></td><td><textarea name="txtComments" value="" class="txtfield" cols="23" id="txtPhone" rows="3"></textarea>
												<div class="arrow_box" id='Mobile' style="display:none;">Please enter Comments<div>
												</td>
											</tr>
											<?php
											?><tr>
												<td align="center" colspan="2"><input type="submit" value="SUBMIT" class="button1"/>&nbsp;&nbsp;<a href="<?php print(FILENAME)?>" class="button1">CANCEL</a></td>
											</tr>
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