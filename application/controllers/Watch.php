<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Watch extends MY_Controller{
	private $checkLogin;
	public function __construct() {
		parent::__construct();
		$this->checkLogin=$this->AccountModel->checkLogin();
		$this->load->model('WatchModel'); 
	}
	public function manageWatch()
	{
		$cryptoId=clearString($this->security->xss_clean($this->input->post('sym')));
		$type=clearString($this->security->xss_clean($this->input->post('type')));
		
		if(strlen($cryptoId)==0 || strlen($type)==0)
		$this->compileResponse(0,"InValid Coin Posted");
		
		$checkRecord=$this->DbLayer->getData('coins',$select=null,$where=['cryptoId'=>$cryptoId],$resultType="count_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=null);
		
		if(count($checkRecord)==0)
		$this->compileResponse(0,"Coin Not Found");
	
		if($type==1)
		{
			$response=$this->WatchModel->addWatchList($cryptoId);
			if(!$response)
			$this->compileResponse(0,"UnAble to add coin to watchlist");
			$data=$this->CommonDbFunc->getGeneralSettings();
			$this->load->model('CryptoModel');
			$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
			$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
			$overRide=$crCh['type'];$activeCurrency=$crCh['currency'];
			$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
			$coinsInfo=$this->CryptoModel->getCoinsList(null,null,$where=['cryptoId'=>$cryptoId],$cacheIt=false,$select=['image','coinName','supply','symbol','cryptoId','price','changePercentage24Hour','marketCap','low24Hour','high24Hour','volume24Hour','volume24HourTo']);
			$data['coin']=$coinsInfo[0];
			$data['coins24Prices']=$this->coins24HourPricesFormator($coinsInfo);
			$next=mt_rand(4000,8000);
			$data['next']=$next;
			$language = $this->CommonDbFunc->getLanguageData();
			$data['activeLanguage']=$language['activeLanguage'];
			$html=$this->load->view('front/panelAppendWatchList',$data,true);
			$this->compileResponse(1,$html,$next);
		}
		else
		{
			$response=$this->WatchModel->remWatchList($cryptoId);
			if(!$response)
			$this->compileResponse(0,"UnAble to remove coin from watchlist");	
		}
		
		$this->compileResponse(1);	
	}
	
	public function loadWatchList() 
	{
		$this->load->model('CryptoModel');
		$data=$this->CommonDbFunc->getGeneralSettings();
		$data=array_merge($data,$this->CommonDbFunc->getLanguageData()); 
		$data['ads']=$this->CommonDbFunc->getAdsSettings();
		$data['analytics']=$this->CommonDbFunc->getAnalyticsSettings();
		$data['pages']=$this->CommonDbFunc->getAllPagesList();
		$data['coinStats']=$this->CommonDbFunc->getAllStatsCoin();
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		$data['nightMode']=getSetUserTheme($data['theme']);
		$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		$overRide=$crCh['type'];$activeCurrency=$crCh['currency'];
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		$totalResults=21;
		$data['topCoinList']=$this->CryptoModel->getCoinsList([$totalResults,0],['order_by_Col'=>'volume24HourTo','order_by_type'=>'desc'],$where=null,$cacheIt=false,$select=['coinName','cryptoId','symbol','image']);
		
		$activeLanguage=$data['activeLanguage'];
		
		$watchList=$this->WatchModel->getWatchList();
		$coinsInfo=[];
		$data['totalDataWatchList']=count($watchList);
		$watchLists=$watchList;
		$watchList2=array_splice($watchLists,0,$totalResults);
		if(count($watchList2)>0)
		{
			$coinsInfo=$this->DbLayer->rawQuery("SELECT `image`, `coinName`, `symbol`, `cryptoId`, `price`, `changePercentage24Hour`, `supply`,`marketCap`, `low24Hour`, `high24Hour`, `volume24Hour`, `volume24HourTo` FROM `coins` WHERE `cryptoId` IN(".implode(',',$watchList2).") ORDER BY FIELD(cryptoId, ".implode(',',$watchList2).") asc ","all_array");
		}
		$data['coins24Prices']=$this->coins24HourPricesFormator($coinsInfo);
		
		$data['coinsInfo']=$coinsInfo;
		$data['watchList']=$watchList;
		   
		$data['title']=isset($activeLanguage['website_title'])?$activeLanguage['website_title']:$data['title'];
		$data['pageName']=showlangVal($activeLanguage,"watchlist_page_title");
		$data['totalResults']=$totalResults;
		$data['url']='watch-list';
		$this->load->view('front/watchList',$data);
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
	public function watchListTopPost() {
		$cur_page=trim(stripslashes($this->input->post('page')));
		if(strlen($cur_page)==0)
		$cur_page=0;
		$this->load->model('CryptoModel'); 
		$data['coins']=$this->CryptoModel->getCoinsList([20,$cur_page],['order_by_Col'=>'volume24HourTo','order_by_type'=>'desc'],$where=null,$cacheIt=false,$select=['coinName','cryptoId','symbol','image']);
		$data['page']=$cur_page;
		$next=$cur_page+count($data['coins']);
		$data['next']=$next;
		$data['watchList']=$this->WatchModel->getWatchList();
		$html=$this->load->view('front/watchListPanel',$data,true);
		$this->compileResponse(1,$html,$next);
	}
	public function watchListLoadMorePost() {
		$cur_page=trim(stripslashes($this->input->post('page')));
		if(strlen($cur_page)==0)
		$cur_page=0;
		$coinsInfo=[];
		$totalResults=21;
		
		$watchList=$this->WatchModel->getWatchList($cur_page,$totalResults);
		if(count($watchList)>0)
		{
			$coinsInfo=$this->DbLayer->rawQuery("SELECT `image`, `coinName`, `symbol`, `cryptoId`, `price`, `supply`, `changePercentage24Hour`, `marketCap`, `low24Hour`, `high24Hour`, `volume24Hour`, `volume24HourTo` FROM `coins` WHERE `cryptoId` IN(".implode(',',$watchList).") ORDER BY FIELD(cryptoId, ".implode(',',$watchList).") desc ","all_array");
		}
		$data=$this->CommonDbFunc->getGeneralSettings();
		$this->load->model('CryptoModel'); 
		$data['coinsInfo']=$coinsInfo;
		$data['coins24Prices']=$this->coins24HourPricesFormator($coinsInfo);
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		$overRide=$crCh['type'];$activeCurrency=$crCh['currency'];
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		$data['page']=$cur_page;
		$next=$cur_page+count($coinsInfo);
		$data['next']=$next;
		$language = $this->CommonDbFunc->getLanguageData();
		$data['activeLanguage']=$language['activeLanguage'];
		$html=$this->load->view('front/panelAppendWatchListLoadMore',$data,true);
		$this->compileResponse(1,$html,$next);
	}
	public function watchListSearchPost() {
		$query = $this->input->post("query");
		$query = clearString($this->security->xss_clean($query));
		$data=[];
		$queryData=[];
		$watchList=[];
		if(strlen($query)>0)
		{
			$watchList=$this->WatchModel->getWatchList();
			$url = filter_var($query, FILTER_SANITIZE_STRING);
			$queryData=$this->CommonDbFunc->getSearchResults($query);
		}
		$data['coins']=$queryData;
		$data['watchList']=$watchList;
		$html=$this->load->view('front/watchListPanel',$data,true);
		$this->compileResponse(1,$html);
	}
	protected function compileResponse($response,$responseHtml="",$data=[])
	{
		echo json_encode(['response'=>$response,'responseHtml'=>$responseHtml,'data'=>$data]);
		exit;
	}
	
}