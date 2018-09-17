</head>
<body class="hold-transition skin-purple-light sidebar-mini">
<div class="wrapper">
<header class="main-header">
	<a href="<?php echo base_url(); ?>" class="logo">
		<span class="logo-mini"><b>C</b>PT</span>
		<span class="logo-lg"><?php echo $settings['title']; ?></span>
	</a>
	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php
						$userInfo = $this->session->userdata('crc_user');
						$garavatar = "".(base_url("assets/images/avatar.jpg")); 
						?>
						<img src="<?php echo $garavatar; ?>" class="user-image" alt="User Image">
						<span class="hidden-xs"><?php echo $userInfo['username']; ?></span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-footer">
							<div class="pull-left">
								<a class="btn btn-default btn-flat" href="<?php echo base_url(ADMIN_CONTROLLER."/profile"); ?>">
									Profile Settings
								</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo base_url("logoutI"); ?>" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>
