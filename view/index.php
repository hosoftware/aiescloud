<?php
include_once "control/index.class.php";
?><!doctype html>
<html lang="en">
  <head>
     <title>Aries Cloud</title><?php
	include_once "model/headerlinks.php";
  ?><script language="javascript">
  function frmSubmit(objFrm) {
	  if(objFrm.txtUsername.value=='Username') {
		  objFrm.txtUsername.value ="";
	  }
	  if(objFrm.txtPassword.value=='Password') {
		  objFrm.txtPassword.value ="";
	  }
	  if(objFrm.txtUsername.value=='') {
		 document.getElementById('username').style.display="block";
		 objFrm.txtUsername.focus();
		return false;
		
	  }
	  else {
		   document.getElementById('username').style.display="none";
	  }
	  if(objFrm.txtPassword.value=='') {
		   objFrm.txtPassword.focus();
		 document.getElementById('password').style.display="block";
		return false;
	  }
	  else {
		   document.getElementById('password').style.display="none";
	  }
  }
  /*function for forgot password form validation*/
  function sbtfrmPassword(objFrm) {
	if(objFrm.txtName.value=='') {
		 document.getElementById('name').style.display="block";
		 objFrm.txtName.focus();
		return false;
		
	  }
	  else {
		   document.getElementById('name').style.display="none";
	  }

	  if(objFrm.txtEmail.value=='') {
		 document.getElementById('email').style.display="block";
		 objFrm.txtEmail.focus();
		return false;
		
	  }
	  else {
		   document.getElementById('email').style.display="none";
	  }
	  //return false;
  }
  </script>
  </head>
   <body>
		<div class="main"><!-- topbar start --><?php
			include_once "model/topbar.php";
			?><!-- topbar end -->
			<!-- navigation bar start--><?php
			//include_once "model/navigation.php";
			?><!-- navigation bar end-->
				<!-- left bar start --><?php
			//include_once "model/leftbar.php";
			?><div class="clear">
				</div>
				<!-- left bar end -->
				<!-- Content start -->
				<?php
						if(!empty($_REQUEST['errMsg']) && $_REQUEST['errMsg']=='Y'){
							?><span style='background:white;padding:10px;margin-left:38%;border-radius:10px;'><strong style='color:red;'>Invalid Username or Password.Please try again</strong></span><br/><?php
						}
						else if(!empty($_REQUEST['errMsg']) && $_REQUEST['errMsg']=='SY'){
							?><span style='background:white;padding:10px;margin-left:38%;border-radius:10px;'><strong style='color:red;'>Your password request has been sent successfully</strong></span><br/><?php
						}
						else if(!empty($_REQUEST['errMsg']) && $_REQUEST['errMsg']=='SN'){
							?><span style='background:white;padding:10px;margin-left:38%;border-radius:10px;'><strong style='color:red;'>Your password request has been NOT sent successfully</strong></span><br/><?php
						}
					?>
				<div class="login"><span class='login-head'>&nbsp;</span><div class="login_form"><form action="<?php print(FILENAME)?>" method="post" onsubmit="return frmSubmit(this)">
							<div style='' class='username' title='Username'></div>
							<input type="text" name="txtUsername" id="txtUsername" value="Username" size="30" onfocus="if(this.value=='Username') this.value=''" onblur="if(this.value=='') this.value='Username'" style='border:1px solid #666768;'/>
							<div class="arrow_box" id='username' style="display:none;">Please enter Username</div><br/><br/>
							<div style='' class='password' title='Password'></div><input type="password" name="txtPassword" id="txtPassword" value="Password" size="30" onfocus="if(this.value=='Password') this.value=''" onblur="if(this.value=='') this.value='Password'"  style='border:1px solid #666768;backgroud:#fff !important;'/>
							<div class="arrow_box" id='password' style="display:none;">Please enter Password</div><br/><br/>
							
							<div class='login-bottom'>
							<input type="submit" name="submit" id="submit" value="LOGIN" size="30" class="button1" style=' padding-left:4%;padding-right:4%;-moz-box-shadow:    0px 1px 1px 2px #355A8F;-webkit-box-shadow: 0px 1px 1px 2px #355A8F; box-shadow:         0px 1px 1px 2px #355A8F;'/>
								<input type="hidden" name="doAction" id="doAction" value="LOGIN"/><?php
								if(empty($_REQUEST['count1'])) {
									$_REQUEST['count1'] = 1;
								}
								else {
									$_REQUEST['count1'] = $_REQUEST['count1']+1;
								}
								?><input type="hidden" name="count1" id="count1" value="<?php print($_REQUEST['count1']);?>"/><?php
								if(!empty($_REQUEST['HTTP_REFERER1'])){
								 ?><input type="hidden" name="HTTP_REFERER1" id="" value="<?php print($_REQUEST['HTTP_REFERER1']);?>"/><?php
								}
								?>
								<a href='#' style='color:#5394DE;font-size:16px;text-decoration:none;position:absolute;padding-left:12%' id='forgot_pass' style='font-weight:bold;color:#5394DE;font-size:9px;'/><strong>Forgot Password</strong></a>
							</div>
						</form>
					</div>
				<!-- Content end -->
				
				</div>
				<!-- footer start --><?php
			include_once "model/footer.php";
			?><!-- footer end -->
		</div>
		<div class='infoBox2' style='display:none;' id='info_box'>
			<span style='margin-left:90%; position:absolute;border:1px solid;width:20px;height:20px;text-align:center;border-radius: 20px;cursor:pointer;background: #CACBCC;' onclick='closebox()' ><strong style='color:red' title='close'>X</strong></span>
			<form method="post" name='frmSubmit2' onsubmit='return sbtfrmPassword(this)'><br/>
				<table align='center'>
					<tr><td colspan='2' align='center'>FORGOT PASSWORD</td></tr>
					<tr><td>Name<strong class="astric">*</strong></td><td><input type="text" name="txtName" id="txtName" value="" size="25" /><div class="arrow_box" id='name' style="display:none;">Please enter Name</div></td></tr>
					<tr><td>Official Email<strong class="astric">*</strong></td><td><input type="text" name="txtEmail" id="txtEmail" value="" size="25" /><div class="arrow_box" id='email' style="display:none;">Please enter Official Email</div></td></tr>
					<tr><td>Phone</td><td><input type="text" name="txtPhone" id="txtPhone" value="" size="25" /></td></tr>
					<tr><td>Company Name</td><td><input type="text" name="txtCompany" id="txtCompany" value="" size="25" /></td></tr>
					<tr><td>Rig Name</td><td><input type="text" name="txtRigname" id="txtRigname" value="" size="25" /></td></tr>
					<tr><td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="SEND REQUEST" size="30" class="button1"/>
							<input type="hidden" name="doAction" id="doAction" value="FORGOTPASSWORD"/></td></tr>
				</table>
			</form>
		</div>
   </body>
</html><script src="js/jquery.js"></script>  
 <script src="js/jquery.form.js"></script>  
 <script>  <?php
 //if(empty($_SESSION['infobox'])) {
 ?>$('#forgot_pass').click(function() {  
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
   //}
 ?>
 function closebox() {
	$('#info_box').hide();
	 $(".main").css("opacity",1);
    $('".main').fadeOut('slow');
}

 </script>