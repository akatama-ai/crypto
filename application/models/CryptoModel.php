<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CryptoModel extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	function getSingleCoinInfo($coin)
	{
		$coinData=$this->DbLayer->getData('coins',$select=null,$where=['name'=>$coin],$resultType="row_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"info_".$coin,'getSet'=>true,'time'=>2*60*60]);
		return $coinData;
	}
	
	function countAllCoins()
	{
		$countAllCoins=$this->DbLayer->getData('coins',$select=null,$where=null,$resultType="count_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_totalCoins",'getSet'=>true,'time'=>24*60*60]);
		return $countAllCoins;
	}
	
	function getCoinsList($limit,$order,$where=null,$cacheIt=false,$select=null,$wherep1=null,$whereinarray=null)
	{
		$coinData=$this->DbLayer->getData('coins',$select,$where,$resultType="all_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=$order['order_by_Col'],$order_by_type=$order['order_by_type'],$limit,$wherep1,$whereinarray,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt);
		
		return $coinData;
	}
	function checkCurrencyChange($prevCur)
	{
		if(isset($_GET['cur']))
		{
			$currency=trim(stripcslashes(strip_tags($_GET['cur'])));
			if(ctype_alnum($currency))
			{
				return ['currency'=>$currency,'type'=>true];
			}
		}
		return ['currency'=>$prevCur,'type'=>false];
	}
}
?>