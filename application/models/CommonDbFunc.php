<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonDbFunc extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	function getGeneralSettings()
	{
		$settings=$this->DbLayer->getData('general-settings',$select=null,$where=null,$resultType="row_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_general_settings",'getSet'=>true,'time'=>24*60*60]);
		return $settings;
	}
	function getAdsSettings()
	{
		$settings=$this->DbLayer->getData('ads-settings',$select=null,$where=null,$resultType="row_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_ads_settings",'getSet'=>true,'time'=>24*60*60]);
		return $settings;
	}
	function getAnalyticsSettings()
	{
		$settings=$this->DbLayer->getData('analytics-settings',$select=null,$where=null,$resultType="row_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_analytics_settings",'getSet'=>true,'time'=>24*60*60]);
		return $settings;
	}
	function getAllStatsCoin()
	{
		$settings=$this->DbLayer->getData('coins',$select=['sum(totalVolume24HourTo) as totalVolume','sum(marketCap) as totalMarketCap','count(*) as totalCoins'],$where=null,$resultType="row_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_all_stats_coin",'getSet'=>true,'time'=>24*60*60]);
		return $settings;
	}
	
	function getAllCurrencies()
	{
		$settings=$this->DbLayer->getData('currency-rates',$select=null,$where=null,$resultType="all_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_currency_rates",'getSet'=>true,'time'=>24*60*60]);
		return $settings;
	}
	function getLanguageData()
	{
		$languages=$this->getAllLanguagesList();
		$defaultLanguage=getSetUserLanguage($languages);
		$activeLanguage=readFileLanguage($defaultLanguage['id']);
		return ['languages'=>$languages,'defaultLanguage'=>$defaultLanguage,'activeLanguage'=>$activeLanguage,'languages'=>$languages];
	}
	
	function getAllPagesList()
	{
		$pages=$this->DbLayer->getData('pages',$select=['title','permalink','displayOrder'],$where=['status'=>1],$resultType="all_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_pages",'getSet'=>true,'time'=>30*24*60*60]);
		return $pages;
	}
	
	function getAllLanguagesList()
	{
		$pages=$this->DbLayer->getData('languages',$select=null,$where=['status'=>1],$resultType="all_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col='displayOrder',$order_by_type='asc',$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=['index'=>"crc_languages",'getSet'=>true,'time'=>30*24*60*60]);
		return $pages;
	}
	
	function getSearchResults($query)
	{
		$settings=$this->DbLayer->getData('coins',$select=['price','coinName','fullName','cryptoId','symbol','image'],$where=null,$resultType="all_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col='sortOrder',$order_by_type='asc',$limit=[20,0],$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=$query,$likecolumn='fullName',$distinct=false,$cacheIt=false);
		return $settings;
	}
	
	function getSetUserDefaultCurrencyData($currencies,$setCurrency,$overRide)
	{
	$cookie_name = "defCur";
	$def=$setCurrency;
	   if(!isset($_COOKIE[$cookie_name]))
	   {
		   $cookieData=json_encode([$setCurrency]);
			setcookie($cookie_name, $cookieData, time() + (86400 * 20), "/");
		}
		else 
		{
			$cookieData=json_decode($_COOKIE[$cookie_name],true);
			if(isset($cookieData)) {
				if(is_array($cookieData)) {
					if(count($cookieData)==1){
						
						if($overRide)
						{
							if(!in_array($setCurrency,$cookieData)) 
							{
								$cookieDataN=json_encode([$setCurrency]);
								setcookie($cookie_name, $cookieDataN, time() + (86400 * 20), "/");
								$def=$setCurrency;
							}
						}
						else
						{
							$def=$cookieData[0];
						}
						
					}
				}
			}
		}
		
		$key=array_search($def,array_column($currencies,'currency'));
		$currencyInfo=$currencies[$key];
	
		if(!is_numeric($key))
		show_404();
		return $currencyInfo; 
	}
}
?>