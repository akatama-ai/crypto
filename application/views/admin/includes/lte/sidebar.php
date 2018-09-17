<?php $pageName = $this->uri->segment(2); ?>
<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MAIN NAVIGATION</li>
			<li class="<?php echo($pageName == "dashboard" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">
					<i class="fa fa-area-chart fa-fw" aria-hidden="true"></i> <span>Dashboard</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "general-settings" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/general-settings"); ?>">
					<i class="fa fa-cogs fa-fw" aria-hidden="true"></i> <span>General Settings</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "profile" || $pageName == "change-password" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/profile"); ?>">
					<i class="fa fa-user-o" aria-hidden="true"></i> <span>Profile Settings</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "coins" || $pageName == "edit-coin" || $pageName == "add-coin" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/coins"); ?>">
					<i class="fa fa-btc fa-fw" aria-hidden="true"></i> <span>Coins</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "currencies" || $pageName == "edit-currency" || $pageName == "add-currency" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/currencies"); ?>">
					<i class="fa fa-money fa-fw" aria-hidden="true"></i> <span>Currencies</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "languages" || $pageName == "add-language" || $pageName == "edit-language" || $pageName == "edit-language-values" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/languages"); ?>">
					<i class="fa fa-language fa-fw" aria-hidden="true"></i> <span>Languages</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "pages" || $pageName == "add-page" || $pageName == "edit-page" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/pages"); ?>">
					<i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> <span>Pages</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "mail-settings" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/mail-settings"); ?>">
					<i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i> <span>Mail Settings</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "ads-settings" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/ads-settings"); ?>">
					<i class="fa fa-code fa-fw" aria-hidden="true"></i> <span>Ads Settings</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "analytics-settings" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/analytics-settings"); ?>">
					<i class="fa fa-line-chart fa-fw" aria-hidden="true"></i> <span>Tracking Code</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "captcha-settings" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/captcha-settings"); ?>">
					<i class="fa fa-user-secret fa-fw" aria-hidden="true"></i> <span>Google Captcha</span>
				</a>
			</li>
			<li class="<?php echo($pageName == "clear-cache" ? "active" : "not-active"); ?>">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/clear-cache"); ?>">
					<i class="fa fa-minus-circle fa-fw" aria-hidden="true"></i> <span>Clear Cache</span>
				</a>
			</li>
			<li>
				<a href="<?php echo base_url("logout"); ?>">
					<i class="fa fa-power-off fa-fw" aria-hidden="true"></i> <span>Logout</span>
				</a>
			</li>
		</ul>
	</section>
</aside>