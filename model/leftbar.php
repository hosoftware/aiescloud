<?php
include_once "control/leftbar.class.php";
?><div class="leftbar"><span></span><?php
	if(!empty($_SESSION['type']) && ($_SESSION['type'] == 'A'|| $_SESSION['type'] == 'S')) {
	?><ul class='left-menu' id='leftbar'>
		<li><a href="client.php"><div <?php if(FILENAME=='client.php') { print("class='leftactive'"); } ?>>Client Management</div></a></li>
		<li><a href="rig.php"><div <?php if(FILENAME=='rig.php') { print("class='leftactive'"); } ?>>Rig Management</div></a></li><?php
		?><li><a href="category.php"><div <?php if(FILENAME=='category.php') { print("class='leftactive'"); } ?>>Categories</div></a></li><?php
		?><li><a href="subcategory.php"><div <?php if(FILENAME=='subcategory.php') { print("class='leftactive'"); } ?>>Sub Categories</div></a></li>
		<li><a href="report.php"><div <?php if(FILENAME=='report.php') { print("class='leftactive'"); } ?>>Report Management</div></a></li>
		<li><a href="view_feedback.php"><div <?php if(FILENAME=='view_feedback.php') { print("class='leftactive'"); } ?>>Feedback Management</div></a></li>
		<li><a href="changepassword.php"><div <?php if(FILENAME=='changepassword.php') { print("class='leftactive'"); } ?>>Change Password</div></a></li>
		<li><a href="passwordrequest.php"><div <?php if(FILENAME=='passwordrequest.php') { print("class='leftactive'"); } ?>>Password Request List</div></a></li><?php
		if($_SESSION['type'] == 'A'|| $_SESSION['type'] == 'S') {
			?><li><a href="activitylog.php"><div <?php if(FILENAME=='activitylog.php') { print("class='leftactive'"); } ?>>User Activity</div></a></li><?php
		}
		if($_SESSION['type'] == 'S') {
			?><li><a href="adminuser.php"><div <?php if(FILENAME=='adminuser.php') { print("class='leftactive'"); } ?>>Admin Users</div></a></li><?php
		}
		?>
	</ul><?php
	}
	if(!empty($_SESSION['type']) && $_SESSION['type'] == 'R') {
		$rslt = $leftbar->getCateGory();
		if($leftbar->objCommonFunc->getNumRows($rslt)) {
			?><ul class='left-menu' id='leftbar'><?php
				while($row = $leftbar->objCommonFunc->fetchAssoc($rslt)) {
					?><li><a href="display_report.php?cat_id=<?php print($row['cat_id'])?>"><div <?php if(!empty($_REQUEST['cat_id']) && $row['cat_id'] == $_REQUEST['cat_id']) { print("class='leftactive'"); } ?>><?php print($row['cat_name'])?></div></a><?php
					if($leftbar->isSubCategory($row['cat_id'])) {
						$rslt1 = $leftbar->getSubCategory($row['cat_id']);
						if($leftbar->objCommonFunc->getNumRows($rslt1)) {
							?><ul class='left-submenu' id='submenu'><?php
								while($row_subcat = $leftbar->objCommonFunc->fetchAssoc($rslt1)) {
									?><li><a href="display_report.php?cat_id=<?php print($row['cat_id'])?>&sub_cat_id=<?php print($row_subcat['subcat_id'])?>"><div <?php if(!empty($_REQUEST['sub_cat_id']) && $row_subcat['subcat_id'] == $_REQUEST['sub_cat_id']) { print("class='leftactive'"); } ?>><?php print($row_subcat['subcat_name'])?></div></a></li><?php
								}
							?></ul><?php
						}
					}
					?></li><?php
				}
			?></ul><?php
		}
	}
	?>
</div>