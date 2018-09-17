<?php $pageName = basename($_SERVER['PHP_SELF']); ?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
	<div class="list-group">
		<a href="./" class="list-group-item <?php echo ($pageName == "index.php" ? "active": ""); ?> text-center">
			<h4 class="fa fa-home fa-lg"></h4><br/>Welcome
		</a>
		<a href="./requirements.php" class="list-group-item <?php echo ($pageName == "requirements.php" ? "active": ""); ?> text-center">
			<h4 class="fa fa-server fa-lg"></h4><br/>Server Requirements
		</a>
		<a href="./database.php" class="list-group-item <?php echo ($pageName == "database.php" ? "active": ""); ?> text-center">
			<h4 class="fa fa-clipboard fa-lg"></h4><br/>Database Details
		</a>
		<a href="./website.php" class="list-group-item <?php echo ($pageName == "website.php" ? "active": ""); ?> text-center">
			<h4 class="fa fa-list-alt fa-lg"></h4><br/>Website Details and Settings
		</a>
		<a href="./finish.php" class="list-group-item <?php echo ($pageName == "finish.php" ? "active": ""); ?> text-center">
			<h4 class="fa fa-thumbs-o-up fa-lg"></h4><br/>Finish
		</a>
	</div>
</div>