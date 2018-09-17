<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CryptoApi extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function updateCurrencyPrices() {
		$result = getRemoteContents("https://openexchangerates.org/api/latest.json?app_id=d0ec7c6d0ece4ac99a85638b08636f8b");
		if($result) {
			$result = json_decode($result,true);
			$data = $result['rates'];
			$tableData = array();
			foreach($data as $currency => $rate) {
				$values = array();
				$values['currency'] = $currency;
				$values['rate'] = $rate;
				array_push($tableData,$values);
			}
			$this->db->update_batch('currency-rates', $tableData, "currency");
		}
	}
	
	public function updateCoinsValues() {
		$result = $this->db->select("symbol")->order_by("sortOrder","asc")->get("coins")->result_array();
		$resultChunked = array_chunk($result,50);
		foreach($resultChunked as $chunk) {
			$symbols = array();
			foreach($chunk as $row) {
				array_push($symbols,$row['symbol']);
			}
			$symbols = implode(",",$symbols);
			$data = getRemoteContents("https://min-api.cryptocompare.com/data/pricemultifull?fsyms=".$symbols."&tsyms=USD");
			$data = json_decode($data,true);
			$updateArray = array();
			foreach($data['RAW'] as $coin => $row) {
				$coinData = $row['USD'];
				$values = array();
				$values['name'] = $coin;
				$values['price'] = $coinData['PRICE'];
				$values['lastUpdate'] = $coinData['LASTUPDATE'];
				$values['lastVolume'] = $coinData['LASTVOLUME'];
				$values['lastVolumeTo'] = $coinData['LASTVOLUMETO'];
				$values['lastTradeId'] = $coinData['LASTTRADEID'];
				$values['volumeDay'] = (isset($coinData['VOLUMEDAY']) ? $coinData['VOLUMEDAY'] : 0);
				$values['volumeDayTo'] = (isset($coinData['VOLUMEDAYTO']) ? $coinData['VOLUMEDAYTO'] : 0);
				$values['volume24Hour'] = $coinData['VOLUME24HOUR'];
				$values['volume24HourTo'] = $coinData['VOLUME24HOURTO'];
				$values['openDay'] = (isset($coinData['OPENDAY']) ? $coinData['OPENDAY'] : 0);
				$values['highDay'] = (isset($coinData['HIGHDAY']) ? $coinData['HIGHDAY'] : 0);
				$values['lowDay'] = (isset($coinData['LOWDAY']) ? $coinData['LOWDAY'] : 0);
				$values['open24Hour'] = $coinData['OPEN24HOUR'];
				$values['high24Hour'] = $coinData['HIGH24HOUR'];
				$values['low24Hour'] = $coinData['LOW24HOUR'];
				$values['lastMarket'] = $coinData['LASTMARKET'];
				$values['change24Hour'] = $coinData['CHANGE24HOUR'];
				$values['changePercentage24Hour'] = $coinData['CHANGEPCT24HOUR'];
				$values['changeDay'] = $coinData['CHANGEDAY'];
				$values['changePercentageDay'] = $coinData['CHANGEPCTDAY'];
				$values['supply'] = $coinData['SUPPLY'];
				$values['marketCap'] = $coinData['MKTCAP'];
				$values['totalVolume24Hour'] = $coinData['TOTALVOLUME24H'];
				$values['totalVolume24HourTo'] = $coinData['TOTALVOLUME24HTO'];
				array_push($updateArray,$values);
			}
			$this->db->update_batch('coins', $updateArray, 'name');
		}
	}
	
	public function getCap() {
		$result = $this->db->select("marketCap")->order_by("sortOrder","asc")->get("coins")->result_array();
		$cap = 0;
		foreach($result as $row) {
			$cap = $cap + $row['marketCap'];
		}
		echo number_format(round($cap));
	}
	
	public function getCoinPriceHour($coin)
	{
		$coins=$this->cache->get('info_last15days_'.$coin);
		$coins=$coins?$coins:[];
		return $coins;
	}
	
	public function getCoinsList()
	{
		if(!$coins=$this->cache->get(cache_prefix.'coins'))
		{
			$result = getRemoteContents("https://min-api.cryptocompare.com/data/all/coinlist");
			
			if($result) {
				$coins=[];
				$result = json_decode($result,true);
				$coins = $result['Data'];
				$this->cache->save(cache_prefix.'coins', $coins, 10*24*60*60);
				return $coins;
			}
		}
		return $coins;
	}
	
	public function getSocialFeedsCoin($coinId)
	{
		$cacheIndex='social_'.$coinId;
		if(!$coins=$this->cache->get($cacheIndex))
		{
			$result = getRemoteContents("https://www.cryptocompare.com/api/data/socialstats/?id=".$coinId);
			if($result) {
				$coins=[];
				$result = json_decode($result,true);
				$coins = $result['Data'];
				$this->cache->save($cacheIndex, $coins, 10*24*60*60);
				return $coins;
			}
		}
		return $coins;
	}
	
	public function getCoinInfo($coinPerma,$activeCurrency)
	{
		if(!$coinInfo=$this->cache->get(cache_prefix.$coinPerma))
		{
			$result = getRemoteContents("https://min-api.cryptocompare.com/data/histoday?fsym=$coinPerma&tsym=USD&aggregate=1&allData=true");
			$coinInfo=[];
			if($result) {
				$result = json_decode($result,true);
				$coinInfo = $result['Data'];
				foreach($coinInfo as $index=>$value)
				{
					$time=date('d-m-Y',$value['time']);
					$coinInfo[$index]['time']=$time;
				}
				$this->cache->save(cache_prefix.$coinPerma, $coinInfo, 3*60*60);
				return $coinInfo;
			}
		}
		
		$rate=$activeCurrency['rate'];
		$currencySymbol=$activeCurrency['symbol'];
		if($currencySymbol=="USD")
		{
			return $coinInfo;
		}
		
		foreach($coinInfo as $index=>$value)
		{
			$coinInfo[$index]['close']=$value['close']*$rate;
			$coinInfo[$index]['low']=$value['low']*$rate;
			$coinInfo[$index]['volumeto']=$value['volumeto']*$rate;
		}
		
		return $coinInfo;
	}
	
	public function getAllCoins() {
		$excludeCoins = array("AMIS","ARENA");
		$result = getRemoteContents("https://min-api.cryptocompare.com/data/all/coinlist");
		if($result) {
			$result = json_decode($result,true);
			$data = $result['Data'];
			$tableData = array();
			foreach($data as $row) {
				$values = array();
				if(!in_array($row['Name'],$excludeCoins)) {
					$values['name'] = $row['Name'];
					$values['symbol'] = $row['Symbol'];
					$values['coinName'] = $row['CoinName'];
					$values['fullName'] = $row['FullName'];
					$values['algorithm'] = $row['Algorithm'];
					$values['proofType'] = $row['ProofType'];
					$values['fullyPremined'] = $row['FullyPremined'];
					$values['totalCoinSupply'] = $row['TotalCoinSupply'];
					$values['preMinedValue'] = $row['PreMinedValue'];
					$values['totalCoinsFreeFloat'] = $row['TotalCoinsFreeFloat'];
					$values['sortOrder'] = $row['SortOrder'];
					$values['sponsored'] = ($row['Sponsored'] == true ? 1 : 0);
					if(isset($row['ImageUrl']) && !empty($row['ImageUrl'])) {
						$imageExtArr = explode(".",$row['ImageUrl']);
						$ext = end($imageExtArr);
						$values['image'] = strtolower($row['Name'].".".$ext);
					}
					else {
						$values['image'] = NULL;
					}
					array_push($tableData,$values);
				}
			}
			$this->db->insert_batch('coins', $tableData);
		}
	}
	
	public function getAllCoinsImages() {
		$result = getRemoteContents("https://min-api.cryptocompare.com/data/all/coinlist");
		if($result) {
			$result = json_decode($result,true);
			$data = $result['Data'];
			$tableData = array();
			foreach($data as $row) {
				if(isset($row['ImageUrl']) && !empty($row['ImageUrl'])) {
					$imageExtArr = explode(".",$row['ImageUrl']);
					$ext = end($imageExtArr);
					$image = strtolower($row['Name']).".".$ext;
					$imagePath = "assets/images/coins/".$image;
					if(!file_exists($imagePath)) {
						copy($result['BaseImageUrl'].$row['ImageUrl'],$imagePath);
					}
				}
			}
		}
	}
}
?>