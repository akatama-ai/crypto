<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CryptoHub extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}
	public function index() 
	{
		$this->load->model('CryptoModel'); 
		$this->load->model('WatchModel'); 
		$data=$this->CommonDbFunc->getGeneralSettings();
		$data=array_merge($data,$this->CommonDbFunc->getLanguageData()); 
		$data['ads']=$this->CommonDbFunc->getAdsSettings();
		$data['analytics']=$this->CommonDbFunc->getAnalyticsSettings();
		$data['pages']=$this->CommonDbFunc->getAllPagesList();
		$data['coinStats']=$this->CommonDbFunc->getAllStatsCoin();
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		$data['nightMode']=getSetUserTheme($data['theme']);
		$per_page=20;
		$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		
		$overRide=$crCh['type'];
		$activeCurrency=$crCh['currency'];
		
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		///
		$this->load->library('PaginationLibAjax');
		$cur_page=0;
		$totalCoins=$this->CryptoModel->countAllCoins();
		$config['first_link']  = 'First';
		$config['div']         = 'postList'; 
		$config['base_url']    = base_url().'coins-list-post';
		$config['total_rows']  = $totalCoins;
		$config['per_page']    = $per_page;
		$config['cur_page']    = $cur_page;
		
		$this->paginationlibajax->initialize($config);
		$data['links']=$this->paginationlibajax->create_links(); 
		
		///
		
		$sortByColumn=$data['sortByColumn'];
		$sortByType=$data['sortByType'];
		$data['orderShift']=$sortByType=="desc"?"asc":"desc";
		
		$cryptos=$this->CryptoModel->getCoinsList([$per_page,$cur_page],['order_by_Col'=>$sortByColumn,'order_by_type'=>$sortByType]);
		$data['sortByTypeOrig']=$sortByType;
		$data['sortByType']=$sortByType=="desc"?"down":"up";
		
		$data['cryptos']=$cryptos;
		$data['coins24Prices']=$this->coins24HourPricesFormator($cryptos);
		
		$activeLanguage=$data['activeLanguage'];
		$data['watchList']=$this->WatchModel->getWatchList();
		$data['title']=isset($activeLanguage['website_title'])?$activeLanguage['website_title']:$data['title'];
		$data['pageName']=showlangVal($activeLanguage,"home_page_title");
		$data['totalRecord']=$per_page;
		$data['url']='';
		
		$this->load->view('front/home',$data);
	}
	public function sortHome()
	{
		$sort = $this->security->xss_clean($this->input->post('sort'));
		$sortByType = $this->security->xss_clean($this->input->post('sortType'));
		if(strlen($sort)==0 || strlen($sortByType)==0)
		show_404();
		
		$actualCombinations=['name'=>'coinName','price'=>'price','coins'=>'supply','vol'=>'volume24HourTo','mkp'=>'marketCap','ch24'=>'changePercentage24Hour','hl'=>'highDay'];
		if(isset($actualCombinations[$sort]))
		{
			$this->load->model('CryptoModel');
			$resultsGo=20;
			$data=$this->CommonDbFunc->getGeneralSettings();
			$data=array_merge($data,$this->CommonDbFunc->getLanguageData()); 
			$cur_page=0;
			
			if($sort!='ch24')
			{
				$whereMake=['status'=>1];
			}
			else
			{
				$whereMake=['changePercentage24Hour'.($sortByType=="desc"?">":"<") =>0,'status'=>1];
			}
			
			$coinInfo=$this->CryptoModel->getCoinsList([$resultsGo,$cur_page],['order_by_Col'=>$actualCombinations[$sort],'order_by_type'=>$sortByType],$whereMake);
			$this->load->model('WatchModel'); 
			$data['sortByTypeOrig']=$sortByType;
			$data['sortByType']=$sortByType=="desc"?"down":"up";
			$data['orderShift']=$sortByType=="desc"?"asc":"desc";
			$data['cryptos']=$coinInfo;
			$data['coins24Prices']=$this->coins24HourPricesFormator($coinInfo);
			$data['watchList']=$this->WatchModel->getWatchList();
			$data['totalResults']=$resultsGo;
			$data['sortByColumn']=$actualCombinations[$sort];
			
			$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
			$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
			$overRide=$crCh['type'];
			$activeCurrency=$crCh['currency'];
			
			$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
			///
			$this->load->library('PaginationLibAjax');
			
			$totalCoins=$this->CryptoModel->countAllCoins();
			$config['first_link']  = 'First';
			$config['div']         = 'postList'; 
			$config['base_url']    = base_url().'coins-list-post';
			$config['total_rows']  = $totalCoins;
			$config['per_page']    = $resultsGo;
			$config['cur_page']    = $cur_page;
			
			$this->paginationlibajax->initialize($config);
			$data['links']=$this->paginationlibajax->create_links(); 
			$data['totalCoins']=$totalCoins; 
			
			///
			$html=$this->load->view('front/homeSubViewFull',$data,true);
			$this->compileResponse(1,[],$html);
		}
		else
		{show_404();}
	}
	
	public function searchManage()
	{
		$query = $this->input->post("query");
		$query = clearString($this->security->xss_clean($query));
		$data=[];
		$queryData=[];
		$watchList=[];
		if(strlen($query)>0)
		{
			$this->load->model('WatchModel');
			$watchList=$this->WatchModel->getWatchList();
			$url = filter_var($query, FILTER_SANITIZE_STRING);
			$queryData=$this->CommonDbFunc->getSearchResults($query);
		}
		$data['result']=$queryData;
		$data['watchList']=$watchList;
		$this->load->view('front/searchDesign',$data);
	}
	
	public function movers() 
	{
		$this->load->model('CryptoModel'); 
		$data=$this->CommonDbFunc->getGeneralSettings();
		$data=array_merge($data,$this->CommonDbFunc->getLanguageData()); 
		$data['ads']=$this->CommonDbFunc->getAdsSettings();
		$data['analytics']=$this->CommonDbFunc->getAnalyticsSettings();
		$data['pages']=$this->CommonDbFunc->getAllPagesList();
		$data['coinStats']=$this->CommonDbFunc->getAllStatsCoin();
		$data['nightMode']=getSetUserTheme($data['theme']);
		
		$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		
		$overRide=$crCh['type'];
		$activeCurrency=$crCh['currency'];
		
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		
		$totalResults=100;
		$activeLanguage=$data['activeLanguage'];
		
		$gainers=$this->CryptoModel->getCoinsList([50,0],['order_by_Col'=>'changePercentage24Hour','order_by_type'=>"desc"],['changePercentage24Hour>'=>0]);
	
		$losers=$this->CryptoModel->getCoinsList([50,0],['order_by_Col'=>'changePercentage24Hour','order_by_type'=>"asc"],['changePercentage24Hour<'=>0]);
		
		$cryptos=array_merge($gainers,$losers);
		
		$data['gainers']=$gainers;
		$data['losers']=$losers;
		$data['coins24Prices']=$this->coins24HourPricesFormator($cryptos);
		$data['title']=isset($activeLanguage['website_title'])?$activeLanguage['website_title']:$data['title'];
		$data['pageName']=showlangVal($activeLanguage,"movers_page_title");
		$data['totalResults']=$totalResults;
		$data['main']=1;
		$data['url']="movers";
		$this->load->model('WatchModel');
		$data['watchList']=$this->WatchModel->getWatchList();
		$this->load->view('front/movers',$data);
	}
	
	public function getCoinsListPost() {
		
		$cur_page=$this->security->xss_clean($this->input->post('page'));
		$sor=$this->security->xss_clean($this->input->post('sor'));
		$sortC=$this->security->xss_clean($this->input->post('sortC'));
		
		$data=$this->CommonDbFunc->getGeneralSettings();
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		$this->load->model('CryptoModel');
		$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		
		$activeCurrency=$crCh['currency'];
		
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide=false);
		
		if(strlen($cur_page)==0)
		$cur_page=0;
		
		$actualCombinations=['name'=>'coinName','price'=>'price','coins'=>'supply','vol'=>'volume24HourTo','mkp'=>'marketCap','ch24'=>'changePercentage24Hour','hl'=>'highDay'];
		
		$sortColumn="volume24HourTo";
		$sor=strlen($sor)==0?"desc":$sor;
		
		if(strlen($sortC)>0)
		{
			if(isset($actualCombinations[$sortC]))
			{
				$sortColumn=$actualCombinations[$sortC];
			}
		}
		
		$per_page=20;
		$this->load->model('WatchModel');
		$this->load->library('PaginationLibAjax');
		$totalCoins=$this->CryptoModel->countAllCoins();
		$config['first_link']  = 'First';
		$config['div']         = 'postList'; 
		$config['base_url']    = base_url().'coins-list-post';
		$config['total_rows']  = $totalCoins;
		$config['per_page']    = $per_page;
		$config['cur_page']    = $cur_page;
		
		$this->paginationlibajax->initialize($config);
		$data['links']=$this->paginationlibajax->create_links(); 
		
		$cryptos=$this->CryptoModel->getCoinsList([$per_page,$cur_page],['order_by_Col'=>$sortColumn,'order_by_type'=>$sor]);
		$data['cryptos']=$cryptos;
		$data['coins24Prices']=$this->coins24HourPricesFormator($cryptos);
		
		$data['sortByTypeOrig']=$sor;
		$data['totalResults']=$per_page;
		$data['totalCoins']=$totalCoins;
		$data['page']=$cur_page;
		$next=$cur_page+count($data['cryptos']);
		$data['next']=$next;
		$data['watchList']=$this->WatchModel->getWatchList();
		$html=$this->load->view('front/cryptoHomeViewSub',$data,true);
		$this->compileResponse(1,$next,$html);
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
	public function chartLoadMain($coinPerma,$currency)
	{
		$coinPerma=trim(stripslashes($coinPerma));
		if(strlen($coinPerma)==0)
		show_404();
		$this->load->model('CryptoApi');
		
		$checkCoin=$this->DbLayer->getData('coins',$select=null,$where=['name'=>$coinPerma,'status'=>1],$resultType="count_array");
		if($checkCoin!=1)
		show_404();
		
		$checkcurrency=$this->DbLayer->getData('currency-rates',$select=null,$where=['currency'=>$currency],$resultType="row_array");
		if(count($checkcurrency)==0)
		show_404();
		$coinInfoComplete=$this->CryptoApi->getCoinInfo($coinPerma,$checkcurrency);
		echo json_encode($coinInfoComplete);
	}	
	public function openCoinInfo($coinPerma)
	{
		$coinPerma=trim(stripslashes($coinPerma));
		if(strlen($coinPerma)==0)
		show_404();
		$this->load->model('CryptoModel');
		$coinInfo=$this->CryptoModel->getSingleCoinInfo($coinPerma);
		if(count($coinInfo)==0)
		show_404();
		 
		$this->load->model('CryptoApi');
		$this->load->model('WatchModel');
		
		$data=$this->CommonDbFunc->getGeneralSettings();
		$data=array_merge($data,$this->CommonDbFunc->getLanguageData()); 
		$data['ads']=$this->CommonDbFunc->getAdsSettings();
		$data['analytics']=$this->CommonDbFunc->getAnalyticsSettings();
		$data['nightMode']=getSetUserTheme($data['theme']);
		$data['pages']=$this->CommonDbFunc->getAllPagesList();
		$crCh=$this->CryptoModel->checkCurrencyChange($data['defaultCurrency']);
		$overRide=$crCh['type'];
		$activeCurrency=$crCh['currency'];
		$data['currencies']=$this->CommonDbFunc->getAllCurrencies();
		
		$data['activeCurrency']=$this->CommonDbFunc->getSetUserDefaultCurrencyData($data['currencies'],$activeCurrency,$overRide);
		
		$coinInfo=$this->CryptoModel->getSingleCoinInfo($coinPerma);
		$coinId=$coinInfo['cryptoId'];
		$coinName=$coinInfo['fullName'];
		
		$data['coinStats']=$this->CommonDbFunc->getAllStatsCoin();
		$data['coinSocialFeed']=$this->CryptoApi->getSocialFeedsCoin($coinId);
		$data['coinInfo']=$coinInfo;
		
		$activeLanguage=$data['activeLanguage'];
		$data['title']=isset($activeLanguage['website_title'])?$activeLanguage['website_title']:$data['title'];
		$data['description']=strlen($coinInfo['description'])>0?$coinInfo['description']:$data['description'];
		$data['watchList']=$this->WatchModel->getWatchList();
		$data['perma']=$coinPerma;
		$data['pageName']=$coinName;
		$data['url']="coin/".$coinPerma;
		$this->load->view('front/coinDetail',$data);
	}
	
	protected function compileResponse($response,$data=[],$responseHtml="")
	{
		echo json_encode(['response'=>$response,'data'=>$data,'responseHtml'=>$responseHtml]);
		exit;
	}
	
	public function getCoinsDataSet()
	{
		$coinPerma=trim(stripslashes($this->input->post('coin')));
		$selectedCurrency=trim(stripslashes($this->input->post('curr')));
		if(strlen($coinPerma)==0)
		{
			$this->compileResponse(0);
		}
		$currencies=$this->CommonDbFunc->getAllCurrencies();
		$this->load->model('CryptoApi');
		$activeCurrency=$this->CommonDbFunc->getSetUserDefaultCurrencyData($currencies,$selectedCurrency,false);
		$coinInfo=$this->CryptoApi->getCoinInfo($coinPerma,$activeCurrency);
		
		$this->compileResponse(1,$coinInfo);
		
	}
}