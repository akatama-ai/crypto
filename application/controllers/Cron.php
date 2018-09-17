<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function update_coin($symbol = null) {
		if($symbol != null) {
			$response = array();
			$symbol = clearString($this->security->xss_clean($symbol));
			$result = getRemoteContents("https://min-api.cryptocompare.com/data/pricemultifull?fsyms=".$symbol."&tsyms=USD");
			if($result) {
				$btcValues = $this->DefaultModel->getData("coins","single",["select" => "price,marketCap", "where" => ["symbol" => "BTC"]]);
				$result = json_decode($result,true);
				if(isset($result['RAW'][$symbol]['USD'])) {
					$coinData = $result['RAW'][$symbol]['USD'];
					if(($btcValues['price'] > $coinData['PRICE']) && ($btcValues['marketCap'] > $coinData['MKTCAP'])) {
						$values = array();
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
						$this->DefaultModel->updateData("coins",$values,["where" => ["symbol" => $symbol], "cache" => ["action" => "delete", "name" => "info_".$symbol]]);
					}
					$response['status'] = "success";
					$response['message'] = "Coin Updated Successfully.";
				}
			}
			if(!isset($response['status']) || $response['status'] != "success") {
				$response['status'] = "success";
				$response['message'] = "Not data found for this coin.";
			}
			echo json_encode($response);
		}
	}
	
	public function update_seo_desc($cryptoId = null) {
		if($cryptoId != null) {
			$response = array();
			$cryptoId = clearString($this->security->xss_clean($cryptoId));
			$result = getRemoteContents("https://www.cryptocompare.com/api/data/coinsnapshotfullbyid/?id=".$cryptoId);
			if($result) {
				$result = json_decode($result,true);
				if(isset($result['Data']['General']['Description'])) {
					$description = $result['Data']['General']['Description'];
					$values = array();
					$values['description'] = $description;
					$this->DefaultModel->updateData("coins",$values,["where" => ["cryptoId" => $cryptoId]]);
					$response['status'] = "success";
					$response['message'] = "Coin Updated Successfully.";
				}
			}
			if(!isset($response['status']) || $response['status'] != "success") {
				$response['status'] = "success";
				$response['message'] = "Not data found for this coin.";
			}
			echo json_encode($response);
		}
	}
	
	public function update_historic_data($symbol = null) {
		if($symbol != null) {
			$response = array();
			$result = getRemoteContents("https://min-api.cryptocompare.com/data/histoday?fsym=".$symbol."&tsym=USD&aggregate=1&allData=true");
			if($result) {
				$result = json_decode($result,true);
				if(isset($result['Data'])) {
					$data = $result['Data'];
					foreach($data as $index => $value) {
						$data[$index]['time'] = date("d-m-Y",$value['time']);
					}
					$cacheVar = cache_prefix.$symbol;
					$this->cache->save($cacheVar, $data, 86400);
					$response['status'] = "success";
					$response['message'] = "Historic Data Updated Successfully.";
				}
			}
			echo json_encode($response);
		}
	}
	
	public function update_24hour_data($symbol = null) {
		if($symbol != null) {
			$response = array();
			$result = getRemoteContents("https://min-api.cryptocompare.com/data/histohour?fsym=".$symbol."&tsym=USD&limit=23&aggregate=1");
			if($result) {
				$result = json_decode($result,true);
				if(isset($result['Data'])) {
					$data = $result['Data'];
					$cacheVar = "info_24hour_".$symbol;
					$this->cache->save($cacheVar, $data, 3600);
					$response['status'] = "success";
					$response['message'] = "24 Hour Data Updated Successfully.";
				}
			}
			echo json_encode($response);
		}
	}
	
	public function update_7days_data() {
		$coins = $this->DefaultModel->getData("coins","multiple",["select" => "symbol","orderBy" => ["name" => "updateTimeStamp asc,volume24HourTo desc", "order" => NULL],"limit" => 20]);
		$updateData = array();
		foreach($coins as $coin) {
			$symbol = $coin['symbol'];
			$result = getRemoteContents("https://min-api.cryptocompare.com/data/histoday?fsym=".$symbol."&tsym=USD&aggregate=1&limit=6");
			if($result) {
				$result = json_decode($result,true);
				if(isset($result['Response']) && $result['Response'] == "Success") {
					if(isset($result['Data'])) {
						$data = $result['Data'];
						$values = array();
						foreach($data as $index => $value) {
							array_push($values,$value['close']);
						}
						if(count($values) > 0) {
							$cacheVar = "info_last7days_".$symbol;
							$this->cache->save($cacheVar, $values, (86400*120));
						}
					}
				}
			}
			array_push($updateData,["symbol" => $symbol, "updateTimeStamp" => time()]);
		}
		$this->DefaultModel->updateData("coins",$updateData,["batchUpdate" => "symbol"]);
	}
	
	public function update_small_charts_data() {
		$coins = $this->DefaultModel->getData("coins","multiple",["select" => "symbol","orderBy" => ["name" => "updateTimeStamp asc,volume24HourTo desc", "order" => NULL],"limit" => 20]);
		$updateData = array();
		foreach($coins as $coin) {
			$symbol = $coin['symbol'];
			$result = getRemoteContents("https://min-api.cryptocompare.com/data/histoday?fsym=".$symbol."&tsym=USD&aggregate=1&limit=14");
			if($result) {
				$result = json_decode($result,true);
				if(isset($result['Response']) && $result['Response'] == "Success") {
					if(isset($result['Data'])) {
						$data = $result['Data'];
						$values = array();
						foreach($data as $index => $value) {
							array_push($values,$value['close']);
						}
						if(count($values) > 0) {
							$cacheVar = "info_last15days_".$symbol;
							$this->cache->save($cacheVar, $values, (86400*120));
						}
					}
				}
			}
			array_push($updateData,["symbol" => $symbol, "updateTimeStamp" => time()]);
		}
		$this->DefaultModel->updateData("coins",$updateData,["batchUpdate" => "symbol"]);
	}
	
	public function update_coins_values() {
		$coins = $this->DefaultModel->getData("coins","multiple",["select" => "symbol","orderBy" => ["name" => "updateTimeStampCoins asc,volume24HourTo desc", "order" => NULL],"limit" => 50]);
		$symbols = array();
		foreach($coins as $row) {
			array_push($symbols,$row['symbol']);
		}
		$symbols = implode(",",$symbols);
		$data = getRemoteContents("https://min-api.cryptocompare.com/data/pricemultifull?fsyms=".$symbols."&tsyms=USD");
		$data=$data? json_decode($data,true):[];
		$updApiC=array();
		$updateArray = array();
		if(isset($data['RAW'])) {
			$btcValues = $this->DefaultModel->getData("coins","single",["select" => "price,marketCap", "where" => ["symbol" => "BTC"]]);
			foreach($data['RAW'] as $coin => $row) {
				$updApiC[]=$coin;
				$coinData = $row['USD'];
				if(($btcValues['price'] > $coinData['PRICE']) && ($btcValues['marketCap'] > $coinData['MKTCAP'])) {
					$values = array();
					$values['symbol'] = $coin;
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
					$values['updateTimeStampCoins'] = time();
					$this->DefaultModel->deleteCacheVar("info_".$coin);
					array_push($updateArray,$values);
				}
			}
		}
		foreach($coins as $index=>$value) 
		{
			$values = array();
			$coinS=$value['symbol'];
			if(!in_array($coinS,$updApiC))
			{
				$updateArray[]=['symbol'=>$coinS,'updateTimeStampCoins'=>time()];
			}
		}
		$this->DefaultModel->updateData("coins",$updateArray,["batchUpdate" => "symbol"]);
	}
}
?>