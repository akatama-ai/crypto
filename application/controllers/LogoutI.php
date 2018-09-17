<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogoutI extends MY_Controller {
	public function index() {
		$this->session->sess_destroy();
		delete_cookie('crc_ud');
		redirect(base_url(),"location");
		exit();
	}
}
?>