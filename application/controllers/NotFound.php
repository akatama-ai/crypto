<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotFound extends MY_Controller {
	public function index() {
		$this->load->model('CryptoModel'); 
		$data = $this->CommonDbFunc->getGeneralSettings();
		$data=array_merge($data,$this->CommonDbFunc->getLanguageData());
		$data['analytics']=$this->CommonDbFunc->getAnalyticsSettings();
		$data['nightMode']=getSetUserTheme($data['theme']);
		$data['pageName'] = "404 Not Found";
		$data['url'] = "";
		$activeLanguage=$data['activeLanguage'];
		$this->load->view("front/404",$data);
	}
}
?>