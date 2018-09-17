<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo $settings['description']; ?>">
	<meta name="keywords" content="<?php echo $settings['keywords']; ?>">
    <link rel="icon" href="<?php echo base_url("assets/images/".$settings['favicon']); ?>">
    <link href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url("assets/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url("assets/css/admin-css-lte/adminlte.min.css?343434"); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url("assets/css/admin-css-lte/all-skins.min.css?343434"); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url("assets/css/admin-css-lte/my-style.css?343434"); ?>" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style>
	.skin-purple-light .sidebar a {
		color: #f3f3f3;
	}
	.sidebar-menu, .main-sidebar .user-panel, .sidebar-menu > li.header {
	white-space: nowrap;
	overflow: hidden;
	background-color: #523bb8;
}
.skin-purple-light .sidebar-menu > li.header {
	color: #fff;
	background: #3b2b4b;
}
.skin-purple-light .wrapper, .skin-purple-light .main-sidebar, .skin-purple-light .left-side {
	background-color: #523bb8;
}
.skin-purple-light .sidebar-menu > li:hover > a, .skin-purple-light .sidebar-menu > li.active > a {
	color: #000;
	background: #ecf0f5;
}
	</style>