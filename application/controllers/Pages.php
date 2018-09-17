<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller{
	public function loadaPage($permalink)
	{
		$data=$this->CommonDbFunc->getGeneralSettings();
		$data=array_merge($data,$this->CommonDbFunc->getLanguageData()); 
		$activeLanguage=$data['activeLanguage'];
		$data['ads']=$this->CommonDbFunc->getAdsSettings();
		$data['analytics']=$this->CommonDbFunc->getAnalyticsSettings();
		
		$permalink=clearString($this->security->xss_clean($permalink));
		
		if(strlen($permalink)==0)
		show_404();
		
		$pageContent=$this->DbLayer->getData('pages',$select=null,$where=['status'=>1,'permalink'=>$permalink],$resultType="row_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_page_".$permalink,'getSet'=>true,'time'=>30*24*60*60]);
		
		if(count($pageContent)==0)
		show_404();
	
		$data['pages']=$this->CommonDbFunc->getAllPagesList();
		$data['nightMode']=getSetUserTheme($data['theme']);
		$this->load->model('CryptoModel');
		$data['coinStats']=$this->CommonDbFunc->getAllStatsCoin();
		
		$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		
		$overRide=$crCh['type'];
		$activeCurrency=$crCh['currency'];
		
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		
		$data['title']=isset($activeLanguage['website_title'])?$activeLanguage['website_title']:$data['title'];
		$data['pageName']=$pageContent['title'];
		$data['keywords']=$pageContent['keywords'];
		$data['description']=$pageContent['description'];
		$data['main']=1;
		$data['url']="page/".$pageContent['permalink'];
		$data['pageInfo']=$pageContent;
		
		$this->load->view('front/pageLoader',$data);	
	}
	
}