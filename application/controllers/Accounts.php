<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends MY_Controller {
	private $checkLogin;
	
	public function __construct() {
		parent::__construct();
		$this->checkLogin=$this->AccountModel->checkLogin();
	}
	
	protected function compileResponse($response,$responseHtml="")
	{
		echo json_encode(['response'=>$response,'responseHtml'=>$responseHtml]);
		exit;
	}
	
	public function create() 
	{
		$language = $this->CommonDbFunc->getLanguageData();
		$activeLanguage = $language['activeLanguage'];
		
		if($this->checkLogin)
		$this->compileResponse(0,showLangVal($activeLanguage,"account_add_error_2"));
		
		$pName = clearString($this->security->xss_clean($this->input->post('pName')));
		
		if(strlen($pName)<3)
		$this->compileResponse(0,showLangVal($activeLanguage,"account_add_error"));
		$this->load->model('WatchModel');
		
		$data=['name'=>$pName,'registered'=>date('Y-m-d H:i:s')];
		$this->DbLayer->insertData('accounts',$data);
		
		$accountId=$this->db->insert_id();
		$hash=$this->AccountModel->get_gen_hash($accountId,"encode");
		
		$data['hash']=$hash;
		$data['accountId']=$accountId;
		$this->DbLayer->updateData('accounts',['hash'=>$hash],$where=['accountId'=>$accountId]);
		
		$this->WatchModel->saveLocalWatchList($accountId);
		getSetPreviuosLoginedUserInfoHash($state='set',[$hash,$pName]);
		$this->AccountModel->saveCookieLogin($data);
		$this->compileResponse(1);
		
	}
	public function updateUsername() 
	{
		$language = $this->CommonDbFunc->getLanguageData();
		$activeLanguage = $language['activeLanguage'];
		
		if(!$this->checkLogin)
		$this->compileResponse(0,showLangVal($activeLanguage,"update_account_error"));
		
		$pName = clearString($this->security->xss_clean($this->input->post('pName')));
		
		if(strlen($pName)==0)
		$this->compileResponse(0,showLangVal($activeLanguage,"account_add_error"));
		$userInfo=$this->session->user;
		$accountId=$userInfo['accountId'];
		$hash=$userInfo['hash'];
		
		$this->DbLayer->updateData('accounts',['name'=>$pName],$where=['accountId'=>$accountId]);
		getSetPreviuosLoginedUserInfoHash($state='set',[$hash,$pName]);
		$userInfo['name']=$pName;
		$this->session->user=$userInfo;
		$this->compileResponse(1,showLangVal($activeLanguage,"username_update_message"));
		
	}
	public function restore() 
	{
		$language = $this->CommonDbFunc->getLanguageData();
		$activeLanguage = $language['activeLanguage'];
		
		if($this->checkLogin)
		$this->compileResponse(0,showLangVal($activeLanguage,"account_restore_error_message_3"));
		
		$resH = clearString($this->security->xss_clean($this->input->post('resH')));
		
		if(strlen($resH)==0)
		$this->compileResponse(0,showLangVal($activeLanguage,"account_restore_error_message_1"));
		
		$accountId=$this->AccountModel->get_gen_hash($resH,"decode");
		if(!isset($accountId[0]))
		$this->compileResponse(0,showLangVal($activeLanguage,"account_restore_error_message_2"));
		
		$userInfo=$this->DbLayer->getData('accounts',$select=null,$where=['accountId'=>$accountId[0]],$resultType="row_array");
		
		if(count($userInfo)==0)
		$this->compileResponse(0,showLangVal($activeLanguage,"account_restore_error_message_2"));
	
		$name=$userInfo['name'];
		//getSetPreviuosLoginedUserInfoHash($state='set',[$resH,$name]);
		
		$this->AccountModel->saveCookieLogin($userInfo);
		$this->compileResponse(1);
	}
	public function logout()
	{
		$this->AccountModel->logout();
		// echo "<pre>";
		// print_r($this->session);
		// exit;
		redirect(base_url());
	}
}