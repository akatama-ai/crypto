<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends MY_Controller {
	private $checkLogin;
	public function __construct() {
		parent::__construct();
		$this->checkLogin=$this->AccountModel->checkLogin();
	}
	public function loadPortfolio($coin=false) 
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
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		$topCoinList=[];
		$portfolio=[];
		$totalTopCoins=0;
		$portfolioList=[];
		$page="portfolio";
		$url="portfolio";
		if($this->checkLogin)
		{
				$accountId=$this->session->user['accountId'];
				$select=['portfolio.cryptoId','portfolio.qty','portfolio.description','coins.image', 'coins.coinName', 'coins.symbol', 'coins.price', 'coins.changePercentage24Hour', 'coins.supply','coins.marketCap', 'coins.low24Hour', 'coins.high24Hour', 'coins.volume24Hour', 'coins.volume24HourTo'];
				if($coin==false)
				{
					$totalTopCoins=21;
					$topCoinList=$this->CryptoModel->getCoinsList([$totalTopCoins,0],['order_by_Col'=>'volume24HourTo','order_by_type'=>'desc'],$where=null,$cacheIt=false,['coinName','cryptoId','symbol','image']);
					$where=['accountId'=>$accountId];
					$resultType="all_array";
					$limit=[$totalTopCoins,0];
				}
				else
				{
					$url="portfolio/".$coin;
					$where=['portfolio.accountId'=>$accountId,'coins.name'=>$coin];
					$resultType="row_array";
					$limit=null;
					$select[]="coins.affiliateLink";
					$page="portfolioCoinInfo";
				}
				
				$portfolio=$this->DbLayer->getData('portfolio',$select,$where,$resultType,$join=true,$joinTable='coins',$joinStatement='portfolio.cryptoId=coins.cryptoId',$joinType='inner',$order_by_Col='on',$order_by_type='desc',$limit,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=false);
				
				if($coin)
				{
					if(count($portfolio)==0)
					show_404();
				}
				else
				{
					$portfolioList=array_map(function($e) {return $e['cryptoId'];},$portfolio);
				}
				$data['coins24Prices']=$this->coins24HourPricesFormator($coin?[$portfolio]:$portfolio);
				
		}
		
		$data['topCoinList']=$topCoinList;
		$data['totalTopCoins']=$totalTopCoins;
		$data['portfolioList']=$portfolioList;
		$data['portfolio']=$portfolio;
		$activeLanguage=$data['activeLanguage'];
		$data['title']=isset($activeLanguage['website_title'])?$activeLanguage['website_title']:$data['title'];
		$data['pageName']=showlangVal($activeLanguage,"portfolio_page_title");
		$data['url']=$url;
		
		$this->load->view('front/'.$page,$data);
	}
	
	function portfolioLoadMorePost()
	{
		$language = $this->CommonDbFunc->getLanguageData();
		$activeLanguage = $language['activeLanguage'];
		
		if(!$this->checkLogin)
		$this->compileResponse(0,showlangVal($activeLanguage,"please_login_to_continue"));
		
		$cur_page=trim(stripslashes($this->input->post('page')));
		if(strlen($cur_page)==0)
		$cur_page=0;
		$totalTopCoins=21;
		
		$this->load->model('CryptoModel'); 
		
		$data['topCoinList']=$this->CryptoModel->getCoinsList([$totalTopCoins,$cur_page],['order_by_Col'=>'volume24HourTo','order_by_type'=>'desc'],$where=null,$cacheIt=false,['coinName','cryptoId','symbol','image']);
		
		$accountId=$this->session->user['accountId'];
		
		$portfolio=$this->DbLayer->getData('portfolio',['cryptoId'],$where=['accountId'=>$accountId],'all_array',$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=false);
		
		$portfolioList=array_map(function($e) {return $e['cryptoId'];},$portfolio);
		
		$data['page']=$cur_page;
		$next=$cur_page+count($data['topCoinList']);
		$data['portfolioList']=$portfolioList;
		$html=$this->load->view('front/portCoinListPanel',$data,true);
		$this->compileResponse(1,$html,$next);
	}
	function portfolioSearchPost()
	{
		$query = $this->input->post("query");
		$query = clearString($this->security->xss_clean($query));
		$data=[];
		$queryData=[];
		$portfolioList=[];
		if(strlen($query)>0)
		{
			$accountId=$this->session->user['accountId'];
		
			$portfolio=$this->DbLayer->getData('portfolio',['cryptoId'],$where=['accountId'=>$accountId],'all_array',$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=false);
			
			$portfolioList=array_map(function($e) {return $e['cryptoId'];},$portfolio);
		
			$url = filter_var($query, FILTER_SANITIZE_STRING);
			$queryData=$this->CommonDbFunc->getSearchResults($query);
		}
		
		
		$data['topCoinList']=$queryData;
		$data['portfolioList']=$portfolioList;
		$html=$this->load->view('front/portCoinListPanel',$data,true);
		$this->compileResponse(1,$html);
	}
	
	function addCoins()
	{
		$language = $this->CommonDbFunc->getLanguageData();
		$activeLanguage = $language['activeLanguage'];
		
		if(!$this->checkLogin)
		$this->compileResponse(0,showLangVal($activeLanguage,"update_account_error"));
		
		$qty=clearString($this->security->xss_clean($this->input->post('qty')));
		if($qty<=0)
		$this->compileResponse(0,showLangVal($activeLanguage,"portfolio_add_coin_error"));
		
		$desc=clearString($this->security->xss_clean($this->input->post('desc')));
		$cryptoId=clearString($this->security->xss_clean($this->input->post('cryptoId')));
		if($cryptoId<=0)
		$this->compileResponse(0,showLangVal($activeLanguage,"invalid_coin_selected"));
	
		$checkRecord=$this->DbLayer->getData('coins',$select=null,$where=['cryptoId'=>$cryptoId],$resultType="count_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=null);
		
		if(count($checkRecord)==0)
		$this->compileResponse(0,showLangVal($activeLanguage,"coin_not_found"));
		
		$accountId=$this->session->user['accountId'];
		$check=$this->DbLayer->getData('portfolio',$select=['cryptoId'],$where=['accountId'=>$accountId,'cryptoId'=>$cryptoId],$resultType="count");
		if($check==0)
		{
			$accountId=$this->session->user['accountId'];
			$this->DbLayer->insertData('portfolio',['accountId'=>$accountId,'cryptoId'=>$cryptoId,'qty'=>$qty,'description'=>$desc,'on'=>date('Y-m-d H:i:s')]);
		}
		$this->compileResponse(1,showLangVal($activeLanguage,"portfolio_add_coin_success"));
	}
	function editCoins()
	{
		$language = $this->CommonDbFunc->getLanguageData();
		$activeLanguage = $language['activeLanguage'];
		
		if(!$this->checkLogin)
		$this->compileResponse(0,showLangVal($activeLanguage,"update_account_error"));
		//add integer validatiom
		$qty=clearString($this->security->xss_clean($this->input->post('qty')));
		if($qty<=0)
		$this->compileResponse(0,showLangVal($activeLanguage,"portfolio_add_coin_error"));
		
		$desc=clearString($this->security->xss_clean($this->input->post('desc')));
		$cryptoId=clearString($this->security->xss_clean($this->input->post('cryptoId')));
		if($cryptoId<=0)
		$this->compileResponse(0,showLangVal($activeLanguage,"invalid_coin_selected"));
	
		$checkRecord=$this->DbLayer->getData('coins',$select=null,$where=['cryptoId'=>$cryptoId],$resultType="count_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=null);
		
		if(count($checkRecord)==0)
		$this->compileResponse(0,showLangVal($activeLanguage,"coin_not_found"));
		
		$accountId=$this->session->user['accountId'];
		$check=$this->DbLayer->getData('portfolio',$select=['cryptoId'],$where=['accountId'=>$accountId,'cryptoId'=>$cryptoId],$resultType="count");
		if($check==1)
		{
			$accountId=$this->session->user['accountId'];
			$this->DbLayer->updateData('portfolio',['qty'=>$qty,'description'=>$desc,'on'=>date('Y-m-d H:i:s')],$where=['cryptoId'=>$cryptoId,'accountId'=>$accountId],$batchColumn=false,$cacheIt=false);
			$this->compileResponse(1,showLangVal($activeLanguage,"portfolio_update_coin_success"));
		}
		$this->compileResponse(1,showLangVal($activeLanguage,"invalid_data_posted"));
	}
	function delCoins()
	{
		$language = $this->CommonDbFunc->getLanguageData();
		$activeLanguage = $language['activeLanguage'];
		
		if(!$this->checkLogin)
		$this->compileResponse(0,showLangVal($activeLanguage,"update_account_error"));
		$cryptoId=clearString($this->security->xss_clean($this->input->post('id')));
		if($cryptoId<=0)
		$this->compileResponse(0,showLangVal($activeLanguage,"invalid_coin_selected"));
	
		$checkRecord=$this->DbLayer->getData('coins',$select=null,$where=['cryptoId'=>$cryptoId],$resultType="count_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=null);
		
		if(count($checkRecord)==0)
		$this->compileResponse(0,showLangVal($activeLanguage,"coin_not_found"));
		
		$accountId=$this->session->user['accountId'];
		$check=$this->DbLayer->getData('portfolio',$select=['cryptoId'],$where=['accountId'=>$accountId,'cryptoId'=>$cryptoId],$resultType="count");
		if($check==1)
		{
			$accountId=$this->session->user['accountId'];
			$this->DbLayer->deleteData('portfolio',$where=['accountId'=>$accountId,'cryptoId'=>$cryptoId]);
			$this->compileResponse(1,showLangVal($activeLanguage,"portfolio_delete_coin_success"));
		}
		$this->compileResponse(1,showLangVal($activeLanguage,"invalid_data_posted"));
	}
	protected function coins24HourPricesFormator($coins)
	{
		$this->load->model('CryptoApi');
		$coins24Prices=[];
		foreach($coins as $index=>$coin)
		{
			$prices=$this->CryptoApi->getCoinPriceHour($coin['symbol']);
			$coins24Prices[$coin['symbol']]=$prices;
		}
		return $coins24Prices;
	}
	protected function compileResponse($response,$responseHtml="",$data=[])
	{
		echo json_encode(['response'=>$response,'responseHtml'=>$responseHtml,'data'=>$data]);
		exit;
	}
}
		