<!DOCTYPE html>
<html lang="en">
  <head>
   <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
  </head>
<body>
	<div id="respondSearch" class="crypto-main-container">
	<?php $this->load->view("front/includes/header"); ?>
		<div class="pages_main">
			<h2><?php echo showLangVal($activeLanguage,"contact_us"); ?></h2>
			
			<div class="row">
				<form method="post" action="<?php echo base_url("contact-us"); ?>">
					<?php
					if(isset($_POST['submit'])) {
						if($error == true) {
							?>
							<div class="text-danger form-group col-xs-12">
								<?php echo showLangVal($activeLanguage,"error"); ?> ! <?php echo showLangVal($activeLanguage,"contact_error_message"); ?>
							</div>
							<?php
						}
						else {
							?>
							<div class="text-success form-group col-xs-12">
								<?php echo showLangVal($activeLanguage,"success"); ?> ! <?php echo showLangVal($activeLanguage,"contact_success_message"); ?>
							</div>
							<?php
						}
					}
					?>
					<div class="col-md-4">
						<div class="form-group">
							<div class="inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input id="name" name="name" class="form-control contact_cont" placeholder="<?php echo showLangVal($activeLanguage,"name"); ?>" type="text" value="<?php echo(isset($name) && $error == true ? $name : ""); ?>" />
								</div>
								<?php
								if(isset($nameError)) {
									?>
									<div class="m-t-5 text-danger night-text-danger"><?php echo $nameError; ?></div>
									<?php
								}
								?>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group"> 
							<div class="inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
									<input id="email" name="email" class="form-control contact_cont" placeholder="<?php echo showLangVal($activeLanguage,"email"); ?>" type="email" value="<?php echo(isset($email) && $error == true ? $email : ""); ?>" />
								</div>
								<?php
								if(isset($emailError)) {
									?>
									<div class="m-t-5 text-danger night-text-danger"><?php echo $emailError; ?></div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<div class="inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
									<input id="subject" name="subject" class="form-control contact_cont" placeholder="<?php echo showLangVal($activeLanguage,"subject"); ?>" type="text" value="<?php echo(isset($subject) && $error == true ? $subject : ""); ?>" />
								</div>
								<?php
								if(isset($subjectError)) {
									?>
									<div class="m-t-5 text-danger night-text-danger"><?php echo $subjectError; ?></div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
		 
					<div class="col-xs-12">
						<div class="form-group">
							<div class="inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
									<textarea cols="6" rows="8" id="message" name="message" class="form-control contact_cont" placeholder="<?php echo showLangVal($activeLanguage,"message"); ?>"><?php echo(isset($message) && $error == true ? $message : ""); ?></textarea>
								</div>
								<?php
								if(isset($messageError)) {
									?>
									<div class="m-t-5 text-danger night-text-danger"><?php echo $messageError; ?></div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12">
							<?php
							if(isset($captchaCheck) && $captchaCheck == true) {
								?>
								<div class="form-group pull-left">
									<div style="display: inline-block;">
										<div class="g-recaptcha" data-sitekey="<?php echo $captchaSettings['siteKey']; ?>"></div>
									</div>
									<?php
									if(isset($captchaError)) {
										?>
										<div>
											<span class="text-danger night-text-danger"><?php echo $captchaError; ?></span>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}
							?>
						</div>
					
					<div class="clearfix"></div>

					<div class="col-md-4">
						<div class="form-group">
							<button type="submit" name="submit" class="btn btn-success"><?php echo showLangVal($activeLanguage,"submit_btn"); ?> <span class="glyphicon glyphicon-send"></span></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$this->load->view("front/includes/footer");
	if(isset($captchaCheck) && $captchaCheck == true) {
		?> <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script> <?php
	}
	?>
</body>
</html>