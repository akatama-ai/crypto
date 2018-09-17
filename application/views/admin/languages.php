<?php $this->load->view("admin/includes/lte/head"); ?>
<link href="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.css"); ?>" rel="stylesheet" type="text/css">
<title>Languages - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			All Languages
			<small>Manage all the languages</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Languages</li>
		</ol>
	</section>
	<section class="content">
		<p><small><strong>Note : </strong>Drag the languages to change their order</small></p>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-language"></i> All Languages</h3>
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/add-language"); ?>" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Add New Language</a>
			</div>
			<div class="box-body">
				<ul class="list-group">
					<li class="active list-group-item">
						<div class="row">
							<div class="col-xs-3">Name</div>
							<div class="col-xs-3">Code</div>
							<div class="col-xs-2">Published</div>
							<div class="col-xs-2">Complete</div>
							<div class="col-xs-2">Actions</div>
						</div>
					</li>
					<?php
					foreach($languages as $language) {
						?>
						<li class="languages-lists list-group-item" id="<?php echo $language['id']; ?>">
							<div class="row">
								<div class="col-xs-3"><?php echo $language['name']; ?></div>
								<div class="col-xs-3"><?php echo $language['code']; ?></div>
								<div class="col-xs-2">
									<?php
									if($language['status'] == 1) {
										?><span class="label label-success">Yes</span><?php
									}
									else {
										?><span class="label label-warning">No</span><?php
									}
									?>
								</div>
								<div class="col-xs-2">
									<span class="label label-info">
										<?php
										$percentage = ($langVarsCount[$language['id']]/$totalLangVars) * 100;
										$percentage = round($percentage,1);
										echo $percentage."%";
										?>
									</span>
								</div>
								<div class="col-xs-2">
									<a title="Edit Language" href="<?php echo base_url(ADMIN_CONTROLLER."/edit-language/".$language['id'])?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
									<button data-status="<?php echo $language['status']; ?>" data-id="<?php echo $language['id']; ?>" title="Delete Language" class="delbtn btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
									<a title="Edit Language Values" href="<?php echo base_url(ADMIN_CONTROLLER."/edit-language-values/".$language['id'])?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
								</div>
							</div>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<script type="text/javascript" src="<?php echo base_url("assets/jquery-ui/jquery-ui.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.js"); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("ul.list-group").sortable ({
			opacity: 0.8,
			cursor: 'move',
			axis: "y",
			items: ".languages-lists",
			containment: ".box",
			update: function(event,ui)  {
				var order = $(this).sortable("toArray");
				$.ajax ({
					type: "POST",
					url: baseURL+adminURL+"/update-languages-order",
					data: {"updateLanguagesOrder":"updateLanguagesOrder","order":order}
				});
			},
			stop: function() {
				$(".ui-sortable-handle").css ({
					'top' : 'auto',
					'left' : 'auto'
				});
			}
		});
		
		$(document).on("click",".delbtn",function() {
			var context = $(this);
			var alertContext = $.confirm({
				title: 'Confirm!',
				content: 'Do you want to delete that language?',
				theme: 'dark',
				buttons: {
					confirm: {
						text: 'Confirm',
						btnClass: 'btn-green',
						action: function(){
							id = context.attr("data-id");
							this.buttons.confirm.setText('Wait <i class="fa fa-spinner fa-spin"></i>');
							var id = context.attr("data-id");	
							var status = context.attr("data-status");	
							$.ajax ({
								type: 'POST',
								url: baseURL+adminURL+"/delete-language",
								dataType: "json",
								data: {"deleteLanguage":"deleteLanguage","id":id,"status":status},
								success: function (result) {
									alertContext.close();
									if(result.status == "success") {
										context.parents("li").remove();
										$.confirm({
											title: 'Success!',
											theme: 'dark',
											content: 'Language Deleted Successfully.',
											type: 'green',
											typeAnimated: true,
											buttons: {
												close: function () {
												}
											}
										});
									}
									else {
										$.confirm({
											title: 'Warning!',
											theme: 'dark',
											content: result.message,
											type: 'orange',
											typeAnimated: true,
											buttons: {
												close: function () {
												}
											}
										});
									}
								}
							});
							return false;
						}
					},
					close: {
						text: 'Cancel',
						action: function(){}
					}
				}
			});
		});
	});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>