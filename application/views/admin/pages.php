<?php $this->load->view("admin/includes/lte/head"); ?>
<link href="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.css"); ?>" rel="stylesheet" type="text/css">
<title>All Pages - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			All Pages
			<small>Manage all pages</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Pages</li>
		</ol>
	</section>
	<section class="content">
		<p><small><strong>Note : </strong>Drag the pages to change their order</small></p>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-file-text-o"></i> All Pages</h3>
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/add-page"); ?>" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Add New Page</a>
			</div>
			<div class="box-body">
				<ul class="list-group">
					<li class="active list-group-item">
						<div class="row">
							<div class="col-xs-3">Title</div>
							<div class="col-xs-3">Permalink</div>
							<div class="col-xs-3">Published</div>
							<div class="col-xs-3 text-right">Actions</div>
						</div>
					</li>
					<?php
					foreach($pages as $page) {
						?>
						<li class="pages-lists list-group-item" id="<?php echo $page['id']; ?>">
							<div class="row">
								<div class="col-xs-3"><?php echo $page['title']; ?></div>
								<div class="col-xs-3"><?php echo $page['permalink']; ?></div>
								<div class="col-xs-3">
									<?php
									if($page['status'] == 1) {
										?><span class="label label-success">Yes</span><?php
									}
									else {
										?><span class="label label-warning">No</span><?php
									}
									?>
								</div>
								<div class="col-xs-3">
									<a title="Edit Page" href="<?php echo base_url(ADMIN_CONTROLLER."/edit-page/".$page['id'])?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
									<a data-permalink="<?php echo $page['permalink']; ?>" data-id="<?php echo $page['id']; ?>" title="Delete Page" class="delbtn btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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
			items: ".pages-lists",
			containment: ".box",
			update: function(event,ui)  {
				var order = $(this).sortable("toArray");
				$.ajax ({
					type: "POST",
					url: baseURL+adminURL+"/update-pages-order",
					data: {"updatePagesOrder":"updatePagesOrder","order":order}
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
				content: 'Do you want to delete that Page?',
				theme: 'dark',
				buttons: {
					confirm: {
						text: 'Confirm',
						btnClass: 'btn-green',
						action: function(){
							id = context.attr("data-id");
							permalink = context.attr("data-permalink");
							this.buttons.confirm.setText('Wait <i class="fa fa-spinner fa-spin"></i>');
							var id = context.attr("data-id");	
							$.ajax ({
								type: 'POST',
								url: baseURL+adminURL+"/delete-page",
								data: {"deletePage":"deletePage","id":id,"permalink":permalink},
								success: function (result) {
									alertContext.close();
									context.parents("li").remove();
									$.confirm({
										title: 'Success!',
										theme: 'dark',
										content: 'Page Deleted Successfully.',
										type: 'green',
										typeAnimated: true,
										buttons: {
											close: function () {
											}
										}
									});
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