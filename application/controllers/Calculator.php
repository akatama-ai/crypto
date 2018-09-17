<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends MY_Controller {
	private $checkLogin;
	public function __construct() {
		parent::__construct();
		$this->checkLogin=$this->AccountModel->checkLogin();
	}
	public function load()
	{
		$this->load->model('CryptoModel');
		$this->load->model('CryptoApi');		
		$data=$this->CommonDbFunc->getGeneralSettings();
		$data=array_merge($data,$this->CommonDbFunc->getLanguageData()); 
		$data['ads']=$this->CommonDbFunc->getAdsSettings();
		$data['analytics']=$this->CommonDbFunc->getAnalyticsSettings();
		$data['pages']=$this->CommonDbFunc->getAllPagesList();
		$data['coinStats']=$this->CommonDbFunc->getAllStatsCoin();
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		$data['nightMode']=getSetUserTheme($data['theme']);
		$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		$overRide=$crCh['type'];
		$activeCurrency=$crCh['currency'];
		
		$data['coinList']=$this->CryptoModel->getCoinsList([21,0],['order_by_Col'=>'volume24HourTo','order_by_type'=>'desc'],$where=null,$cacheIt=false,$select=['coinName','symbol','price','image','totalCoinSupply','fullName','changePercentage24Hour','sortOrder','marketCap','volume24HourTo']);
		
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		$activeLanguage=$data['activeLanguage'];
		$data['title']=isset($activeLanguage['website_title'])?$activeLanguage['website_title']:$data['title'];
		$data['pageName']=showlangVal($activeLanguage,"calculator");;
		$data['url']="calculator";
		
		$this->load->view('front/calculator',$data);
	}
	public function calcListTopPost() {
		$cur_page=trim(stripslashes($this->input->post('page')));
		if(strlen($cur_page)==0)
		$cur_page=0;
		$this->load->model('CryptoModel'); 
		$data['coins']=$this->CryptoModel->getCoinsList([21,$cur_page],['order_by_Col'=>'volume24HourTo','order_by_type'=>'desc'],$where=null,$cacheIt=false,$select=['coinName','symbol','price','image','totalCoinSupply','fullName','changePercentage24Hour','sortOrder','marketCap','volume24HourTo']);
		$data['page']=$cur_page;
		$next=$cur_page+count($data['coins']);
		$data['next']=$next;
		$html=$this->load->view('front/calcListPanel',$data,true);
		$this->compileResponse(1,$html,$next);
	}
	
	public function calculatorSearchPost() {
		$query = $this->input->post("query");
		$query = clearString($this->security->xss_clean($query));
		$data=[];
		$queryData=[];
		if(strlen($query)>0)
		{
			$url = filter_var($query, FILTER_SANITIZE_STRING);
			$queryData=$this->CommonDbFunc->getSearchResults($query);
		}
		$data['coins']=$queryData;
		$language = $this->CommonDbFunc->getLanguageData();
		$data['activeLanguage'] = $language['activeLanguage'];
		$html=$this->load->view('front/calcListPanel',$data,true);
		$this->compileResponse(1,$html);
	}
	protected function compileResponse($response,$responseHtml="",$data=[])
	{
		echo json_encode(['response'=>$response,'responseHtml'=>$responseHtml,'data'=>$data]);
		exit;
	}
}