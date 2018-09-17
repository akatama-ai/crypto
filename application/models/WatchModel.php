<?php   
class WatchModel extends CI_Model{
	private $checkLogin;
	function __construct()
    {
		parent::__construct();
		$this->checkLogin=$this->AccountModel->checkLogin();
    }
	function getWatchList($start=0,$recordCount="all")
	{
		if($this->checkLogin)
		{
			$accountId=$this->session->user['accountId'];
			if($recordCount=="all")
			$limit=null;
			else
			$limit=[$recordCount,$start];
		
			$watchlist=$this->DbLayer->getData('watchlist',$select=['cryptoId'],$where=['accountId'=>$accountId],$resultType="all_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col='id',$order_by_type='desc',$limit);
			$watchlist=array_map(function($e) {return $e['cryptoId'];},$watchlist);
			return $watchlist;
		}
		else
		{
			$watchList=$this->getLocalWatchList();
			if($recordCount!="all")
			$watchList=array_splice($watchList,$start,$recordCount);
			
			return $watchList;
		}
	}
	function saveLocalWatchList($accountId)
	{
		$watchList=$this->getWatchList();
		if(count($watchList)>0)
		{
			$insertBatch=[];
			foreach($watchList as $index=>$value)
			{
				$insertBatch[]=['accountId'=>$accountId,'cryptoId'=>$value,'on'=>date('Y-m-d H:i:s')];
			}
			$this->DbLayer->insertData('watchlist',$insertBatch,$batch=true);
			setcookie('wat', "", time() - (86400 * 20), "/");
		}
	}
	function addWatchList($cryptoId)
	{
		if($this->checkLogin)
		{
			$accountId=$this->session->user['accountId'];
			$check=$this->DbLayer->getData('watchlist',$select=['cryptoId'],$where=['accountId'=>$accountId,'cryptoId'=>$cryptoId],$resultType="count");
			if($check==0)
			{
				$accountId=$this->session->user['accountId'];
				$this->DbLayer->insertData('watchlist',['accountId'=>$accountId,'cryptoId'=>$cryptoId,'on'=>date('Y-m-d H:i:s')]);  
			}
			return true;
		}
		else
		{
			return $this->addLocalWatchList($cryptoId);
		}
	}
	function remWatchList($cryptoId)
	{
		if($this->checkLogin)
		{
			$accountId=$this->session->user['accountId'];
			$this->DbLayer->deleteData('watchlist',$where=['accountId'=>$accountId,'cryptoId'=>$cryptoId]);
			return true;
		}
		else
		{
			return $this->removeLocalWatchList($cryptoId);
		}
	}
	function addLocalWatchList($id){
	   $cookie_name = "wat";
	   $checkMate=false;
	   if(!isset($_COOKIE[$cookie_name]))
	   {
		   $cookieData=json_encode([$id]);
		   setcookie($cookie_name, $cookieData, time() + (86400 * 20), "/");
		   $checkMate=true;
		}
		else 
		{
			$cookieData=json_decode($_COOKIE[$cookie_name],true);
			if(isset($cookieData)) {
				if(is_array($cookieData)) {
					if(!in_array($id,$cookieData)) 
						{
							$cookieData[]=$id;
							$cookieData=json_encode($cookieData);
							setcookie($cookie_name, $cookieData, time() + (86400 * 20), "/");
							$checkMate=true;
						}
						else
						{
							$checkMate=true;
						}
					}
				}
		}
		return $checkMate; 

	}
	
	function getLocalWatchList()
	{
		$cookie_name ="wat";
		$data=[];
		if(!isset($_COOKIE[$cookie_name]))
		{
		   return $data;
		}
		$cookieData=json_decode($_COOKIE[$cookie_name],true);
		if(isset($cookieData)) {
			if(is_array($cookieData)) {
				if(count($cookieData)>0){
					return $cookieData;
				}
			}
		}
		return $data;		
	}

	function removeLocalWatchList($id){
	   $cookie_name = "wat";
	   $checkMate=true;
	   if(!isset($_COOKIE[$cookie_name]))
	   {
		   return $checkMate;
		}
		else 
		{
			$cookieData=json_decode($_COOKIE[$cookie_name],true);
			if(isset($cookieData)) {
				if(is_array($cookieData)) {
					if(count($cookieData)>0){
						if(in_array($id,$cookieData)) 
						{
							if (($key = array_search($id, $cookieData)) !== false) {
								unset($cookieData[$key]);
								$cookieData=json_encode($cookieData);
								setcookie($cookie_name, $cookieData, time() + (86400 * 20), "/");
								$checkMate=true;	
							}
							
						}
					}
				}
			}
		}
		return true; 
	}

}