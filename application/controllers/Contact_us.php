<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->load->model('CryptoModel'); 
		$data = $this->CommonDbFunc->getGeneralSettings();
		$data=array_merge($data,$this->CommonDbFunc->getLanguageData());
		$data['ads']=$this->CommonDbFunc->getAdsSettings();
		$data['analytics']=$this->CommonDbFunc->getAnalyticsSettings();
		$data['pages']=$this->CommonDbFunc->getAllPagesList();
		$data['coinStats']=$this->CommonDbFunc->getAllStatsCoin();
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		$data['nightMode']=getSetUserTheme($data['theme']);
		$activeLanguage=$data['activeLanguage'];
		$data['title']=isset($activeLanguage['website_title'])?$activeLanguage['website_title']:$data['title'];
		$data['pageName']=showlangVal($activeLanguage,"contact_page_title");
		$data['url'] = "contact-us";
		
		$crCh = $this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		$overRide = $crCh['type'];
		$activeCurrency = $crCh['currency'];
		$data['activeCurrency'] = $this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		
		$captchaSettings = $this->DefaultModel->getData("captcha-settings","single",["cache" => ["name" => "crc_captcha_settings"]]);
		$captchaCheck = false;
		if($captchaSettings['contactCaptcha'] == 1) {
			$captchaCheck = true;
			$data['captchaSettings'] = $captchaSettings;
		}
		
		$error = false;
		if(isset($_POST['submit'])) {
			$name = clearString($this->security->xss_clean($this->input->post("name")));
			$data['name'] = $name;
			$email = clearString($this->security->xss_clean($this->input->post("email")));
			$data['email'] = $email;
			$subject = clearString($this->security->xss_clean($this->input->post("subject")));
			$data['subject'] = $subject;
			$message = clearString($this->security->xss_clean($this->input->post("message")));
			$data['message'] = $message;
			
			if($captchaCheck == true && isset($_POST['g-recaptcha-response'])) {
				$gCaptchaSecret = $captchaSettings['secretKey'];
				$gCaptchaResponse = $this->input->post("g-recaptcha-response");
				$remoteIp = $this->input->ip_address();
				$url = "https://www.google.com/recaptcha/api/siteverify?".http_build_query(['secret' => $gCaptchaSecret,'remoteip' => $remoteIp,'response' => $gCaptchaResponse]);
				$response = getRemoteContents($url);
				$response = json_decode($response,true);
				if(!isset($response['success']) || $response['success'] != true) {
					$error = true;
					$data['captchaError'] = showLangVal($activeLanguage,"contact_captcha_error");
				}
			}
			
			if(!$error) {
				if(!isAlphaSpaces($name)) {
					$error = true;
					$data['nameError'] = showLangVal($activeLanguage,"contact_name_error");
				}
				
				if(!validEmail($email)) {
					$error = true;
					$data['emailError'] = showLangVal($activeLanguage,"contact_email_error");
				}
				
				if(empty($subject)) {
					$error = true;
					$data['subjectError'] = showLangVal($activeLanguage,"contact_subject_error");
				}
				
				if(empty($message)) {
					$error = true;
					$data['messageError'] = showLangVal($activeLanguage,"contact_message_error");
				}
				
				if(!$error) {
					$this->load->library('email');
					$mailSettings = $this->DefaultModel->getData("mail-settings","single",["cache" => ["name" => "crc_mail_settings"]]);
					$config = array();
					if($mailSettings['smtpStatus'] == 1) {
						$config['protocol'] = 'smtp';
						$config['smtp_host'] = $mailSettings['host'];
						$config['smtp_port'] = $mailSettings['port'];
						$config['smtp_user'] = $mailSettings['username'];
						$config['smtp_pass'] = $mailSettings['password'];
					}
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['newline'] = "\r\n";
					$this->email->initialize($config);
					
					$host = getDomain(base_url());
					
					$message = nl2br($message);
					$message .= '<p><strong>'.isset($activeLanguage['sent_via'])?$activeLanguage['sent_via']:"Sent Via".' <a href="'.base_url().'">'.$host.'</a></strong></p>';
					
					$this->email->from($email, $name);
					$this->email->reply_to($email, $name);
					$this->email->to($mailSettings['contactEmail']);
					$this->email->subject($subject." : ".$host);
					$this->email->message($message);
					$this->email->send();
				}
			}
		}
		
		$data['error'] = $error;
		$data['captchaCheck'] = $captchaCheck;
		
		$this->load->view('front/contact_us',$data);
	}
}
?>