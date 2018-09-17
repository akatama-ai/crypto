<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view("front/includes/head"); ?>
	</head>
	<body>
		<div class="fourOfour">
			<div class="fourOfour_main">
				<img src="<?php echo base_url("assets/images/404.png"); ?>">
				<p><?php echo showLangVal($activeLanguage,"404_page_description"); ?></p>
				<div class="button_main">
					<a class="main_btn" href="<?php echo base_url(); ?>"><?php echo showLangVal($activeLanguage,"goto_home"); ?></a>
				</div>
			</div>
		</div>
	</body>
</html>