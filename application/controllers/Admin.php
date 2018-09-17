<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
	public function __construct() {
		parent::__construct();
		if(!$this->session->has_userdata('crc_access') || $this->session->userdata('crc_access') != true || !$this->session->has_userdata('crc_admin_access') || $this->session->userdata('crc_admin_access') != true) {
			redirect(base_url(AUTH_CONTROLLER."/login"),"location");
			exit();
		}
		$this->load->model("AdminModel");
	}
	
	public function index() {
		redirect(base_url(ADMIN_CONTROLLER."/dashboard"),"location");
		exit();
	}
	
	public function dashboard() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		
		$cacheVar = "crc_admin_stats";
		if(!$stats = $this->cache->get($cacheVar)) {
			$stats = $this->AdminModel->getStatsCountAll();
			
			$record = array();
			$record['type'] = "Today";
			$startDate = date('Y-m-d');
			$endDate = date("Y-m-d");
			$stats['pageViewsToday'] = $this->AdminModel->getStatsCount($startDate,$endDate);
			$this->cache->save($cacheVar,$stats,1000);
		}
		
		$data['stats'] = $stats;
		$this->load->view("admin/dashboard",$data);
	}
	
	public function general_settings() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$currencyRates = $this->DefaultModel->getData("currency-rates","multiple",["cache" => ["name" => "crc_currency_rates"]]);
		$data['currencyRates'] = $currencyRates;
		$sortByColumns = array("coinName" => "Coin Name", "price" => "Price", "volume24HourTo" => "Volume", "marketCap" => "Market Cap", "supply" => "Coins" ,"changePercentage24Hour" => "24H Change", "highDay" => "High/Low");
		$data['sortByColumns'] = $sortByColumns;
		$error = false;
		if(isset($_POST['submit'])) {
			$values = array();
			
			$title = clearString($this->security->xss_clean($this->input->post("title")));
			$data['title'] = $title;
			$values['title'] = $title;
			if(empty($title)) {
				$error = true;
				$data['titleError'] = "Should not be empty";
			}
			
			$description = clearString($this->security->xss_clean($this->input->post("description")));
			$data['description'] = $description;
			$values['description'] = $description;
			if(empty($description)) {
				$error = true;
				$data['descriptionError'] = "Should not be empty";
			}
			
			$keywords = clearString($this->security->xss_clean($this->input->post("keywords")));
			$data['keywords'] = $keywords;
			$values['keywords'] = $keywords;
			if(empty($keywords)) {
				$error = true;
				$data['keywordsError'] = "Should not be empty";
			}
			
			$oldCoverImage = clearString($this->security->xss_clean($this->input->post("oldCoverImage")));
			$coverImage = $oldCoverImage;
			if(!$error) {
				if(!empty($_FILES['coverImage']['name'])) {
					$base = explode(".", strtolower(basename($_FILES["coverImage"]["name"])));
					$ext = end($base);
					$extArr = array("jpeg","jpg","png");
					if(in_array($ext,$extArr)) {
						$oldFile = "assets/images/".$oldCoverImage;
						if(file_exists($oldFile)) {
							unlink($oldFile);
						}
						$coverImage = "cover.".$ext;
						move_uploaded_file($_FILES["coverImage"]["tmp_name"], "assets/images/".$coverImage);
					} else {
						$data['coverImageError'] = "Only image types allowed";
						$error = true;
					}
				}
			}
			$data['coverImage'] = $coverImage;
			$values['coverImage'] = $coverImage;
			
			$oldLightLogo = clearString($this->security->xss_clean($this->input->post("oldLightLogo")));
			$lightLogo = $oldLightLogo;
			if(!$error) {
				if(!empty($_FILES['lightLogo']['name'])) {
					$base = explode(".", strtolower(basename($_FILES["lightLogo"]["name"])));
					$ext = end($base);
					$extArr = array("jpeg","jpg","png");
					if(in_array($ext,$extArr)) {
						$oldFile = "assets/images/".$oldLightLogo;
						if(file_exists($oldFile)) {
							unlink($oldFile);
						}
						$lightLogo = "lightLogo.".$ext;
						move_uploaded_file($_FILES["lightLogo"]["tmp_name"], "assets/images/".$lightLogo);
					} else {
						$data['lightLogoError'] = "Only image types allowed";
						$error = true;
					}
				}
			}
			$data['lightLogo'] = $lightLogo;
			$values['lightLogo'] = $lightLogo;
			
			$oldDarkLogo = clearString($this->security->xss_clean($this->input->post("oldDarkLogo")));
			$darkLogo = $oldDarkLogo;
			if(!$error) {
				if(!empty($_FILES['darkLogo']['name'])) {
					$base = explode(".", strtolower(basename($_FILES["darkLogo"]["name"])));
					$ext = end($base);
					$extArr = array("jpeg","jpg","png");
					if(in_array($ext,$extArr)) {
						$oldFile = "assets/images/".$oldDarkLogo;
						if(file_exists($oldFile)) {
							unlink($oldFile);
						}
						$darkLogo = "darkLogo.".$ext;
						move_uploaded_file($_FILES["darkLogo"]["tmp_name"], "assets/images/".$darkLogo);
					} else {
						$data['darkLogoError'] = "Only image types allowed";
						$error = true;
					}
				}
			}
			$data['darkLogo'] = $darkLogo;
			$values['darkLogo'] = $darkLogo;
			
			$oldFavicon = clearString($this->security->xss_clean($this->input->post("oldFavicon")));
			$favicon = $oldFavicon;
			if(!$error) {
				if(!empty($_FILES['favicon']['name'])) {
					$base = explode(".", strtolower(basename($_FILES["favicon"]["name"])));
					$ext = end($base);
					$extArr = array("jpeg","jpg","png","ico");
					if(in_array($ext,$extArr)) {
						$oldFile = "assets/images/".$oldFavicon;
						if(file_exists($oldFile)) {
							unlink($oldFile);
						}
						$favicon = "favicon.".$ext;
						move_uploaded_file($_FILES["favicon"]["tmp_name"], "assets/images/".$favicon);
					} else {
						$data['faviconError'] = "Only image types allowed";
						$error = true;
					}
				}
			}
			$data['favicon'] = $favicon;
			$values['favicon'] = $favicon;
			
			$affiliateLink = clearString($this->security->xss_clean($this->input->post("affiliateLink")));
			$data['affiliateLink'] = $affiliateLink;
			$values['affiliateLink'] = $affiliateLink;
			if(!filter_var($affiliateLink, FILTER_VALIDATE_URL)) {
				$error = true;
				$data['affiliateLinkError'] = "Not a valid url";
			}
			
			$defaultCurrency = clearString($this->security->xss_clean($this->input->post("defaultCurrency")));
			$data['defaultCurrency'] = $defaultCurrency;
			$values['defaultCurrency'] = $defaultCurrency;
			
			$facebookAppId = clearString($this->security->xss_clean($this->input->post("facebookAppId")));
			$data['facebookAppId'] = $facebookAppId;
			$values['facebookAppId'] = $facebookAppId;
			
			$openexchangeratesApiKey = clearString($this->security->xss_clean($this->input->post("openexchangeratesApiKey")));
			$data['openexchangeratesApiKey'] = $openexchangeratesApiKey;
			$values['openexchangeratesApiKey'] = $openexchangeratesApiKey;
			
			$sortByColumn = clearString($this->security->xss_clean($this->input->post("sortByColumn")));
			$data['sortByColumn'] = $sortByColumn;
			$values['sortByColumn'] = $sortByColumn;
			
			$sortByType = clearString($this->security->xss_clean($this->input->post("sortByType")));
			$data['sortByType'] = $sortByType;
			$values['sortByType'] = $sortByType;
			
			$theme = clearString($this->security->xss_clean($this->input->post("theme")));
			$data['theme'] = $theme;
			$values['theme'] = $theme;
			
			$www = clearString($this->security->xss_clean($this->input->post("www")));
			$www = ($www == "on" ? 1 : 0);
			$data['www'] = $www;
			$values['www'] = $www;
			
			$https = clearString($this->security->xss_clean($this->input->post("https")));
			$https = ($https == "on" ? 1 : 0);
			$data['https'] = $https;
			$values['https'] = $https;
			
			$version = clearString($this->security->xss_clean($this->input->post("version")));
			$data['version'] = $version;
			 
			if($error == false) {
				$this->DefaultModel->updateData("general-settings",$values,["cache" => ["action" => "delete", "name" => "crc_general_settings"]]);
				$oldBaseUrl = base_url();
				$directoryName = preg_replace('{/$}', '', dirname($_SERVER['SCRIPT_NAME']))."/";
				$newBaseUrl = ($https == 1 ? "https://" : "http://").($www == 1 ? "www." : "").getDomain($_SERVER['SERVER_NAME']).$directoryName;
				if($oldBaseUrl != $newBaseUrl) {
					 $configPath = APPPATH.'config/config.php';
					$configFile = file_get_contents($configPath);
					$configFile = str_replace($oldBaseUrl,$newBaseUrl,$configFile);
					file_put_contents($configPath,$configFile);
					redirect(base_url("logout"),"location");
					exit(); 
				}
				else {
					$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
					$data['settings'] = $settings;
				}
			}
		}
		else {
			$data['title'] = $settings['title'];
			$data['description'] = $settings['description'];
			$data['keywords'] = $settings['keywords'];
			$data['coverImage'] = $settings['coverImage'];
			$data['lightLogo'] = $settings['lightLogo'];
			$data['darkLogo'] = $settings['darkLogo'];
			$data['favicon'] = $settings['favicon'];
			$data['affiliateLink'] = $settings['affiliateLink'];
			$data['defaultCurrency'] = $settings['defaultCurrency'];
			$data['facebookAppId'] = $settings['facebookAppId'];
			$data['openexchangeratesApiKey'] = $settings['openexchangeratesApiKey'];
			$data['sortByColumn'] = $settings['sortByColumn'];
			$data['sortByType'] = $settings['sortByType'];
			$data['theme'] = $settings['theme'];
			$data['www'] = $settings['www'];
			$data['https'] = $settings['https'];
			$data['version'] = $settings['version'];
		}
		$data['error'] = $error;
		$this->load->view("admin/general_settings",$data);
	}
	
	public function coins() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$currencyRates = $this->DefaultModel->getData("currency-rates","multiple",["cache" => ["name" => "crc_currency_rates"]]);
		$data['currencyRates'] = $currencyRates;
		$data['currency'] = "USD";
		$this->load->view("admin/coins",$data);
	}
	
	public function get_coins() {
		if(isset($_POST['deleteCoin']) && $_POST['deleteCoin'] == "deleteCoin") {
			$symbol = clearString($this->security->xss_clean($this->input->post("symbol")));
			 $this->DefaultModel->deleteData("coins",['where' => ['symbol' => $symbol], "cache" => ["action" => "delete", "name" => ["info_".$symbol, "hist_".$symbol, "info_24hour_".$symbol]]]);
		}
		
		$data = array();
		$currency = clearString($this->security->xss_clean($this->input->post("currency")));
		$data['currency'] = $currency;
		$currencyRate = $this->DefaultModel->getData("currency-rates","single",["where" => ["currency" => $currency], "limit" => 1, "cache" => ["name" => "crc_currency_".$currency]]);
		$data['currencyRate'] = $currencyRate;
		$page = isset($_POST['page']) && is_numeric($_POST['page']) ? clearString($this->security->xss_clean($this->input->post("page"))) : 1;
		$data['page'] = $page;
		$limit = 15;
		$sort = isset($_POST['sort']) && !empty($_POST['sort']) ? clearString($this->security->xss_clean($this->input->post("sort"))) : "marketCap";
		$data['sort'] = $sort;
		$sortOrder = isset($_POST['sortOrder']) && !empty($_POST['sortOrder']) ? clearString($this->security->xss_clean($this->input->post("sortOrder"))) : "desc";
		$data['sortOrder'] = $sortOrder;
		$search = isset($_POST['search']) && !empty($_POST['search']) ? clearString($this->security->xss_clean($this->input->post("search"))) : null;
		$search = trim($search);
		$data['search'] = $search;
		$coinsData = $this->AdminModel->getCoinsData($page,$limit,$sort,$sortOrder,$search);
		$data['coins'] = $coinsData['coins'];
		$totalCoins = $coinsData['totalCoins'];
		$data['totalCoins'] = $totalCoins;
		$totalPages = ceil($totalCoins / $limit);
		$data['totalPages'] = $totalPages;
		$this->load->view("admin/coins_data",$data);
	}
	
	public function change_coin_status() {
		if(isset($_POST['changeCoinStatus']) && $_POST['changeCoinStatus'] == "changeCoinStatus") {
			$symbol = clearString($this->security->xss_clean($this->input->post("symbol")));
			$status = clearString($this->security->xss_clean($this->input->post("status")));
			 $this->DefaultModel->updateData("coins",["status" => $status],["where" => ["symbol" => $symbol],"cache" => ["action" => "delete", "name" => "info_".$symbol]]);
			$response['status'] = "success";
			$response['message'] = "Status Updated Successfully.";
			echo json_encode($response);
		}
	}
	
	public function add_coin() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$values = array();
			
			$name = clearString($this->security->xss_clean($this->input->post("name")));
			$data['name'] = $name;
			$values['name'] = $name;
			if(empty($name)) {
				$error = true;
				$data['nameError'] = "Name should not be empty";
			}
			
			$symbol = clearString($this->security->xss_clean($this->input->post("symbol")));
			$data['symbol'] = $symbol;
			$values['symbol'] = $symbol;
			if(empty($symbol)) {
				$error = true;
				$data['symbolError'] = "Symbol should not be empty";
			}
			else if($this->DefaultModel->getData("coins","count",["where" => ["symbol" => $symbol]]) > 0) {
				$error = true;
				$data['symbolError'] = "Symbol already exists please choose another";
			}
			
			$coinName = clearString($this->security->xss_clean($this->input->post("coinName")));
			$data['coinName'] = $coinName;
			$values['coinName'] = $coinName;
			if(empty($coinName)) {
				$error = true;
				$data['coinNameError'] = "Should not be empty";
			}
			
			$fullName = clearString($this->security->xss_clean($this->input->post("fullName")));
			$data['fullName'] = $fullName;
			$values['fullName'] = $fullName;
			if(empty($fullName)) {
				$error = true;
				$data['fullNameError'] = "Full name should not be empty";
			}
			
			$price = clearString($this->security->xss_clean($this->input->post("price")));
			$data['price'] = $price;
			$values['price'] = $price;
			if(!is_numeric($price) && !is_float($price)) {
				$error = true;
				$data['priceError'] = "Not a valid value";
			}
			
			$volume24Hour = clearString($this->security->xss_clean($this->input->post("volume24Hour")));
			$data['volume24Hour'] = $volume24Hour;
			$values['volume24Hour'] = $volume24Hour;
			if(!is_numeric($volume24Hour) && !is_float($volume24Hour)) {
				$error = true;
				$data['volume24HourToError'] = "Not a valid value";
			}
			
			$volume24HourTo = clearString($this->security->xss_clean($this->input->post("volume24HourTo")));
			$data['volume24HourTo'] = $volume24HourTo;
			$values['volume24HourTo'] = $volume24HourTo;
			if(!is_numeric($volume24HourTo) && !is_float($volume24HourTo)) {
				$error = true;
				$data['volume24HourToError'] = "Not a valid value";
			}
			
			$openDay = clearString($this->security->xss_clean($this->input->post("openDay")));
			$data['openDay'] = $openDay;
			$values['openDay'] = $openDay;
			if(!is_numeric($openDay) && !is_float($openDay)) {
				$error = true;
				$data['openDayError'] = "Not a valid value";
			}
			
			$highDay = clearString($this->security->xss_clean($this->input->post("highDay")));
			$data['highDay'] = $highDay;
			$values['highDay'] = $highDay;
			if(!is_numeric($highDay) && !is_float($highDay)) {
				$error = true;
				$data['highDayError'] = "Not a valid value";
			}
			
			$lowDay = clearString($this->security->xss_clean($this->input->post("lowDay")));
			$data['lowDay'] = $lowDay;
			$values['lowDay'] = $lowDay;
			if(!is_numeric($lowDay) && !is_float($lowDay)) {
				$error = true;
				$data['lowDayError'] = "Not a valid value";
			}
			
			$change24Hour = clearString($this->security->xss_clean($this->input->post("change24Hour")));
			$data['change24Hour'] = $change24Hour;
			$values['change24Hour'] = $change24Hour;
			if(!is_numeric($change24Hour) && !is_float($change24Hour)) {
				$error = true;
				$data['change24HourError'] = "Not a valid value";
			}
			
			$changePercentage24Hour = clearString($this->security->xss_clean($this->input->post("changePercentage24Hour")));
			$data['changePercentage24Hour'] = $changePercentage24Hour;
			$values['changePercentage24Hour'] = $changePercentage24Hour;
			if(!is_numeric($changePercentage24Hour) && !is_float($changePercentage24Hour)) {
				$error = true;
				$data['changePercentage24HourError'] = "Not a valid value";
			}
			
			$supply = clearString($this->security->xss_clean($this->input->post("supply")));
			$data['supply'] = $supply;
			$values['supply'] = $supply;
			if(!is_numeric($supply) && !is_float($supply)) {
				$error = true;
				$data['supplyError'] = "Not a valid value";
			}
			
			$marketCap = clearString($this->security->xss_clean($this->input->post("marketCap")));
			$data['marketCap'] = $marketCap;
			$values['marketCap'] = $marketCap;
			if(!is_numeric($marketCap) && !is_float($marketCap)) {
				$error = true;
				$data['marketCapError'] = "Not a valid value";
			}
			
			$affiliateLink = clearString($this->security->xss_clean($this->input->post("affiliateLink")));
			$data['affiliateLink'] = $affiliateLink;
			$values['affiliateLink'] = $affiliateLink;
			if(!empty($affiliateLink)) {
				if(!filter_var($affiliateLink, FILTER_VALIDATE_URL)) {
					$error = true;
					$data['affiliateLinkError'] = "Not a valid link";
				}
			}
			
			$description = clearString($this->security->xss_clean($this->input->post("description")));
			$data['description'] = $description;
			$values['description'] = $description;
			
			$website = clearString($this->security->xss_clean($this->input->post("website")));
			$data['website'] = $website;
			$values['website'] = $website;
			if(!empty($website)) {
				if(!filter_var($website, FILTER_VALIDATE_URL)) {
					$error = true;
					$data['websiteError'] = "Not a valid link";
				}
			}
			
			$status = clearString($this->security->xss_clean($this->input->post("status")));
			$status = ($status == "on" ? 1 : 0);
			$data['status'] = $status;
			$values['status'] = $status;
			
			if(!$error) {
				if(!empty($_FILES['image']['name'])) {
					$base = explode(".", strtolower(basename($_FILES["image"]["name"])));
					$ext = end($base);
					$extArr = array("jpeg","jpg","png","svg");
					if(in_array($ext,$extArr)) {
						$imageName = str_replace(["*","@"],["_","_"],$symbol);
						$image = $imageName.".".$ext;
						move_uploaded_file($_FILES["image"]["tmp_name"], "assets/images/coins/".$image);
					} else {
						$data['imageError'] = "Only image types allowed";
						$error = true;
					}
				}
				else {
					$error = true;
					$data['imageError'] = "Image must be uploaded";
				}
			}
			
			if(!$error) {
				$values['image'] = $image;
				$values['imageType'] = ($ext == "svg" ? "vector" : "pixel");
				$maxSortOrderResult = $this->DefaultModel->getData("coins","single",["selectMax" => "sortOrder"]);
				$values['sortOrder'] = $maxSortOrderResult['sortOrder'] + 1;
				 $this->DefaultModel->insertData("coins",$values,["cache" => ["action" => "delete", "name" => ["crc_all_stats_coin", "coin_prices_list"]]]);
			}
		}
		$data['error'] = $error;
		$this->load->view("admin/add_coin",$data);
	}
	
	public function edit_coin($id = NULL) {
		if(is_numeric($id)) {
			$data = array();
			$id = clearString($this->security->xss_clean($id));
			$data['id'] = $id;
			$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
			$data['settings'] = $settings;
			$error = false;
			if(isset($_POST['submit'])) {
				$values = array();
			
				$name = clearString($this->security->xss_clean($this->input->post("name")));
				$data['name'] = $name;
				$values['name'] = $name;
				if(empty($name)) {
					$error = true;
					$data['nameError'] = "Name should not be empty";
				}
				
				$oldSymbol = clearString($this->security->xss_clean($this->input->post("oldSymbol")));
				$data['oldSymbol'] = $oldSymbol;
				$symbol = clearString($this->security->xss_clean($this->input->post("symbol")));
				$data['symbol'] = $symbol;
				$values['symbol'] = $symbol;
				if($symbol != $oldSymbol) {
					if(empty($symbol)) {
						$error = true;
						$data['symbolError'] = "Symbol should not be empty";
					}
					else if($this->DefaultModel->getData("coins","count",["where" => ["symbol" => $symbol]]) > 0) {
						$error = true;
						$data['symbolError'] = "Symbol already exists please choose another";
					}
				}
				
				$oldCryptoId = clearString($this->security->xss_clean($this->input->post("oldCryptoId")));
				$data['oldCryptoId'] = $oldCryptoId;
				$cryptoId = clearString($this->security->xss_clean($this->input->post("cryptoId")));
				$data['cryptoId'] = $cryptoId;
				$values['cryptoId'] = $cryptoId;
				if($cryptoId != $oldCryptoId) {
					if(!is_numeric($cryptoId)) {
						$error = true;
						$data['cryptoIdError'] = "Should be a numeric value";
					}
					else if($this->DefaultModel->getData("coins","count",["where" => ["cryptoId" => $cryptoId]]) > 0) {
						$error = true;
						$data['cryptoIdError'] = "CryptoCompare ID already exists please choose another";
					}
				}
				
				$coinName = clearString($this->security->xss_clean($this->input->post("coinName")));
				$data['coinName'] = $coinName;
				$values['coinName'] = $coinName;
				if(empty($coinName)) {
					$error = true;
					$data['coinNameError'] = "Should not be empty";
				}
				
				$fullName = clearString($this->security->xss_clean($this->input->post("fullName")));
				$data['fullName'] = $fullName;
				$values['fullName'] = $fullName;
				if(empty($fullName)) {
					$error = true;
					$data['fullNameError'] = "Full name should not be empty";
				}
				
				$price = clearString($this->security->xss_clean($this->input->post("price")));
				$data['price'] = $price;
				$values['price'] = $price;
				if(!is_numeric($price) && !is_float($price)) {
					$error = true;
					$data['priceError'] = "Not a valid value";
				}
				
				$volume24Hour = clearString($this->security->xss_clean($this->input->post("volume24Hour")));
				$data['volume24Hour'] = $volume24Hour;
				$values['volume24Hour'] = $volume24Hour;
				if(!is_numeric($volume24Hour) && !is_float($volume24Hour)) {
					$error = true;
					$data['volume24HourToError'] = "Not a valid value";
				}
				
				$volume24HourTo = clearString($this->security->xss_clean($this->input->post("volume24HourTo")));
				$data['volume24HourTo'] = $volume24HourTo;
				$values['volume24HourTo'] = $volume24HourTo;
				if(!is_numeric($volume24HourTo) && !is_float($volume24HourTo)) {
					$error = true;
					$data['volume24HourToError'] = "Not a valid value";
				}
				
				$openDay = clearString($this->security->xss_clean($this->input->post("openDay")));
				$data['openDay'] = $openDay;
				$values['openDay'] = $openDay;
				if(!is_numeric($openDay) && !is_float($openDay)) {
					$error = true;
					$data['openDayError'] = "Not a valid value";
				}
				
				$highDay = clearString($this->security->xss_clean($this->input->post("highDay")));
				$data['highDay'] = $highDay;
				$values['highDay'] = $highDay;
				if(!is_numeric($highDay) && !is_float($highDay)) {
					$error = true;
					$data['highDayError'] = "Not a valid value";
				}
				
				$lowDay = clearString($this->security->xss_clean($this->input->post("lowDay")));
				$data['lowDay'] = $lowDay;
				$values['lowDay'] = $lowDay;
				if(!is_numeric($lowDay) && !is_float($lowDay)) {
					$error = true;
					$data['lowDayError'] = "Not a valid value";
				}
				
				$change24Hour = clearString($this->security->xss_clean($this->input->post("change24Hour")));
				$data['change24Hour'] = $change24Hour;
				$values['change24Hour'] = $change24Hour;
				if(!is_numeric($change24Hour) && !is_float($change24Hour)) {
					$error = true;
					$data['change24HourError'] = "Not a valid value";
				}
				
				$changePercentage24Hour = clearString($this->security->xss_clean($this->input->post("changePercentage24Hour")));
				$data['changePercentage24Hour'] = $changePercentage24Hour;
				$values['changePercentage24Hour'] = $changePercentage24Hour;
				if(!is_numeric($changePercentage24Hour) && !is_float($changePercentage24Hour)) {
					$error = true;
					$data['changePercentage24HourError'] = "Not a valid value";
				}
				
				$supply = clearString($this->security->xss_clean($this->input->post("supply")));
				$data['supply'] = $supply;
				$values['supply'] = $supply;
				if(!is_numeric($supply) && !is_float($supply)) {
					$error = true;
					$data['supplyError'] = "Not a valid value";
				}
				
				$marketCap = clearString($this->security->xss_clean($this->input->post("marketCap")));
				$data['marketCap'] = $marketCap;
				$values['marketCap'] = $marketCap;
				if(!is_numeric($marketCap) && !is_float($marketCap)) {
					$error = true;
					$data['marketCapError'] = "Not a valid value";
				}
				
				$affiliateLink = clearString($this->security->xss_clean($this->input->post("affiliateLink")));
				$data['affiliateLink'] = $affiliateLink;
				$values['affiliateLink'] = $affiliateLink;
				if(!empty($affiliateLink)) {
					if(!filter_var($affiliateLink, FILTER_VALIDATE_URL)) {
						$error = true;
						$data['affiliateLinkError'] = "Not a valid link";
					}
				}
				
				$description = $this->input->post("description");
				$data['description'] = $description;
				$values['description'] = $description;
				
				$website = clearString($this->security->xss_clean($this->input->post("website")));
				$data['website'] = $website;
				$values['website'] = $website;
				if(!empty($website)) {
					if(!filter_var($website, FILTER_VALIDATE_URL)) {
						$error = true;
						$data['websiteError'] = "Not a valid link";
					}
				}
				
				$status = clearString($this->security->xss_clean($this->input->post("status")));
				$status = ($status == "on" ? 1 : 0);
				$data['status'] = $status;
				$values['status'] = $status;
				
				if(!$error) {
					$oldImage = clearString($this->security->xss_clean($this->input->post("oldImage")));
					$image = $oldImage;
					if(!empty($_FILES['image']['name'])) {
						$base = explode(".", strtolower(basename($_FILES["image"]["name"])));
						$ext = end($base);
						$extArr = array("jpeg","jpg","png","svg");
						if(in_array($ext,$extArr)) {
							$oldFile = "assets/images/coins/".$oldImage;
							if(file_exists($oldFile)) {
								unlink($oldFile);
							}
							$imageName = str_replace(["*","@"],["_","_"],$symbol);
							$image = $imageName.".".$ext;
							move_uploaded_file($_FILES["image"]["tmp_name"], "assets/images/coins/".$image);
							$values['imageType'] = ($ext == "svg" ? "vector" : "pixel");
						} else {
							$data['imageError'] = "Only image types allowed";
							$error = true;
						}
					}
					$data['image'] = $image;
					$values['image'] = $image;
				}
				
				if(!$error) {
					$data['oldSymbol'] = $symbol;
					$data['oldCryptoId'] = $cryptoId;
					$this->DefaultModel->updateData("coins",$values,["where" => ["id" => $id], "cache" => ["action" => "delete", "name" => ["crc_all_stats_coin", "coin_prices_list","info_".$oldSymbol, "hist_".$oldSymbol, "info_last15days_".$oldSymbol]]]);
				}
			}
			else {
				$coinData = $this->DefaultModel->getData("coins","single",["where" => ["id" => $id]]);
				if($coinData) {
					$data['name'] = $coinData['name'];
					$data['cryptoId'] = $coinData['cryptoId'];
					$data['symbol'] = $coinData['symbol'];
					$data['coinName'] = $coinData['coinName'];
					$data['fullName'] = $coinData['fullName'];
					$data['price'] = $coinData['price'];
					$data['volume24Hour'] = $coinData['volume24Hour'];
					$data['volume24HourTo'] = $coinData['volume24HourTo'];
					$data['openDay'] = $coinData['openDay'];
					$data['highDay'] = $coinData['highDay'];
					$data['lowDay'] = $coinData['lowDay'];
					$data['change24Hour'] = $coinData['change24Hour'];
					$data['changePercentage24Hour'] = $coinData['changePercentage24Hour'];
					$data['supply'] = $coinData['supply'];
					$data['marketCap'] = $coinData['marketCap'];
					$data['affiliateLink'] = $coinData['affiliateLink'];
					$data['description'] = $coinData['description'];
					$data['website'] = $coinData['website'];
					$data['image'] = $coinData['image'];
					$data['status'] = $coinData['status'];
				}
				else {
					redirect(base_url(ADMIN_CONTROLLER."/coins"),"location");
					exit();
				}
			}
			$data['error'] = $error;
			$this->load->view("admin/edit_coin",$data);
		}
		else {
			redirect(base_url(ADMIN_CONTROLLER."/coins"),"location");
			exit();
		}
	}
	
	public function update_data() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$coins = $this->DefaultModel->getData("coins","multiple",["select" => "symbol,fullName,cryptoId"]);
		$data['coins'] = $coins;
		$this->load->view("admin/update_data",$data);
	}
	
	public function update_all_coins_data() {
		if(isset($_POST['updateAllCoinsData']) && $_POST['updateAllCoinsData'] == 'updateAllCoinsData') {
			$response = array();
			$symbols = json_decode($this->input->post("coinsSymbols"));
			if(is_array($symbols)) {
				$symbols = implode(",",$symbols);
				$data = getRemoteContents("https://min-api.cryptocompare.com/data/pricemultifull?fsyms=".$symbols."&tsyms=USD");
				if($data) {
					$btcValues = $this->DefaultModel->getData("coins","single",["select" => "price,marketCap", "where" => ["symbol" => "BTC"]]);
					$data = json_decode($data,true);
					$updateArray = array();
					foreach($data['RAW'] as $coin => $row) {
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
							array_push($updateArray,$values);
							$this->DefaultModel->deleteCacheVar("info_".$coin);
						}
					}
					$this->DefaultModel->updateData("coins",$updateArray,["batchUpdate" => "symbol"]);
					$response['status'] = "success";
					$response['message'] = "Coin Updated Successfully.";
				}
			}
			if(!isset($response['status']) || $response['status'] != "success") {
				$response['status'] = "success";
				$response['message'] = "Unable to update data for coins.";
			}
			echo json_encode($response);
		}
	}
	
	public function change_coin_affiliate_link() {
		if(isset($_POST['changeCoinAffiliateLink']) && $_POST['changeCoinAffiliateLink'] == "changeCoinAffiliateLink") {
			$symbol = clearString($this->security->xss_clean($this->input->post("symbol")));
			$link = clearString($this->security->xss_clean($this->input->post("link")));
			$link = urldecode($link);
			$response = array();
			if(filter_var($link, FILTER_VALIDATE_URL)) {
				 $this->DefaultModel->updateData("coins",["affiliateLink" => $link],["where" => ["symbol" => $symbol], "cache" => ["action" => "delete", "name" => "info_".$symbol]]);
				$response['status'] = "success";
				$response['message'] = "Affiliate Link Changed Successfully.";
			}
			else {
				$response['status'] = "error";
				$response['message'] = "Can't Update Invalid Affiliate Link.";
			}
			echo json_encode($response);
		}
	}
	
	public function currencies() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$this->load->view("admin/currencies",$data);
	}
	
	public function get_currencies() {
		$data = array();
		$currencyDeleted = 0;
		if(isset($_POST['deleteCurrency']) && $_POST['deleteCurrency'] == "deleteCurrency") {
			$currency = clearString($this->security->xss_clean($this->input->post("currency")));
			if($this->DefaultModel->getData("general-settings","count",["where" => ["defaultCurrency" => $currency]]) == 0) {
				 $this->DefaultModel->deleteData("currency-rates",['where' => ['currency' => $currency], "cache" => ["action" => "delete", "name" => ["crc_currency_rates","crc_currency_".$currency]]]);
				$currencyDeleted = 1;
			}
		}
		$data['currencyDeleted'] = $currencyDeleted;
		$page = isset($_POST['page']) && is_numeric($_POST['page']) ? clearString($this->security->xss_clean($this->input->post("page"))) : 1;
		$data['page'] = $page;
		$limit = 15;
		$sort = isset($_POST['sort']) && !empty($_POST['sort']) ? clearString($this->security->xss_clean($this->input->post("sort"))) : "currency";
		$data['sort'] = $sort;
		$sortOrder = isset($_POST['sortOrder']) && !empty($_POST['sortOrder']) ? clearString($this->security->xss_clean($this->input->post("sortOrder"))) : "asc";
		$data['sortOrder'] = $sortOrder;
		$search = isset($_POST['search']) && !empty($_POST['search']) ? clearString($this->security->xss_clean($this->input->post("search"))) : null;
		$search = trim($search);
		$data['search'] = $search;
		$CurrenciesData = $this->AdminModel->getCurrenciesData($page,$limit,$sort,$sortOrder,$search);
		$data['currencies'] = $CurrenciesData['currencies'];
		$totalCurrencies = $CurrenciesData['totalCurrencies'];
		$data['totalCurrencies'] = $totalCurrencies;
		$totalPages = ceil($totalCurrencies / $limit);
		$data['totalPages'] = $totalPages;
		$countries = json_decode(file_get_contents("assets/countries/names.json"),true);
		$data['countries'] = $countries;
		$this->load->view("admin/currencies_data",$data);
	}
	
	public function add_currency() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$currency = clearString($this->security->xss_clean($this->input->post("currency")));
			$data['currency'] = $currency;
			$values['currency'] = $currency;
			if(empty($currency)) {
				$error = true;
				$data['currencyError'] = "Currency should not be empty";
			}
			else if($this->DefaultModel->getData("currency-rates","count",["where" => ["currency" => $currency]]) > 0) {
				$error = true;
				$data['currencyError'] = "Currency code already exists";
			}
			
			$rate = clearString($this->security->xss_clean($this->input->post("rate")));
			$data['rate'] = $rate;
			$values['rate'] = $rate;
			if((!is_numeric($rate) && !is_float($rate)) || $rate == 0) {
				$error = true;
				$data['rateError'] = "Not a valid value";
			}
			
			$name = clearString($this->security->xss_clean($this->input->post("name")));
			$data['name'] = $name;
			$values['name'] = $name;
			if(empty($name)) {
				$error = true;
				$data['nameError'] = "Name should not be empty";
			}
			
			$symbol = clearString($this->security->xss_clean($this->input->post("symbol")));
			$data['symbol'] = $symbol;
			$values['symbol'] = $symbol;
			if(empty($symbol)) {
				$error = true;
				$data['symbolError'] = "Symbol should not be empty";
			}
			
			$countryCode = clearString($this->security->xss_clean($this->input->post("countryCode")));
			$data['countryCode'] = $countryCode;
			$values['countryCode'] = $countryCode;
			if(empty($countryCode)) {
				$error = true;
				$data['countryCodeError'] = "Please select a country";
			}
			
			if($error == false) {
				$this->DefaultModel->insertData("currency-rates",$values,["cache" => ["action" => "delete", "name" => "crc_currency_rates"]]);
			}
		}
		$data['error'] = $error;
		$countries = json_decode(file_get_contents("assets/countries/names.json"),true);
		$data['countries'] = $countries;
		$this->load->view("admin/add_currency",$data);
	}
	
	public function edit_currency() {
		if(isset($_GET['currency']) && !empty($_GET['currency'])) {
			$data = array();
			$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
			$data['settings'] = $settings;
			$error = false;
			$currencyValue = clearString($this->security->xss_clean($this->input->get("currency")));
			$data['currencyValue'] = $currencyValue;
			if(isset($_POST['submit'])) {
				$currency = clearString($this->security->xss_clean($this->input->post("currency")));
				$data['currency'] = $currency;
				$values['currency'] = $currency;
				if($currency != $currencyValue) {
					if(empty($currency)) {
						$error = true;
						$data['currencyError'] = "Currency should not be empty";
					}
					else if($this->DefaultModel->getData("currency-rates","count",["where" => ["currency" => $currency]]) > 0) {
						$error = true;
						$data['currencyError'] = "Currency code already exists";
					}
				}
				
				$rate = clearString($this->security->xss_clean($this->input->post("rate")));
				$data['rate'] = $rate;
				$values['rate'] = $rate;
				if((!is_numeric($rate) && !is_float($rate)) || $rate == 0) {
					$error = true;
					$data['rateError'] = "Not a valid value";
				}
				
				$name = clearString($this->security->xss_clean($this->input->post("name")));
				$data['name'] = $name;
				$values['name'] = $name;
				if(empty($name)) {
					$error = true;
					$data['nameError'] = "Name should not be empty";
				}
				
				$symbol = clearString($this->security->xss_clean($this->input->post("symbol")));
				$data['symbol'] = $symbol;
				$values['symbol'] = $symbol;
				if(empty($symbol)) {
					$error = true;
					$data['symbolError'] = "Symbol should not be empty";
				}
				
				$countryCode = clearString($this->security->xss_clean($this->input->post("countryCode")));
				$data['countryCode'] = $countryCode;
				$values['countryCode'] = $countryCode;
				
				if($error == false) {
					$data['currencyValue'] = $currency;
					 $this->DefaultModel->updateData("currency-rates",$values,["where" => ["currency" => $currencyValue], "cache" => ["action" => "delete", "name" => ["crc_currency_rates","crc_currency_".$currencyValue]]]);
				}
			}
			else {
				$currencyData = $this->DefaultModel->getData("currency-rates","single",["where" => ["currency" => $currencyValue], "limit" => 1, "cache" => ["name" => "crc_currency_".$currencyValue]]);
				if(is_array($currencyData) && count($currencyData) > 0) {
					$data['currency'] = $currencyData['currency']; 
					$data['rate'] = $currencyData['rate']; 
					$data['countryCode'] = $currencyData['countryCode'];
					$data['name'] = $currencyData['name'];
					$data['symbol'] = $currencyData['symbol'];
				}
				else {
					redirect(base_url(ADMIN_CONTROLLER."/currencies"),"location");
					exit();
				}
			}
			$data['error'] = $error;
			$countries = json_decode(file_get_contents("assets/countries/names.json"),true);
			$data['countries'] = $countries;
			$this->load->view("admin/edit_currency",$data);
		}
		else {
			redirect(base_url(ADMIN_CONTROLLER."/currencies"),"location");
			exit();
		}
	}
	
	public function update_currency_prices() {
		if(isset($_POST['updateCurrencyPrices']) && $_POST['updateCurrencyPrices'] == 'updateCurrencyPrices') {
			$response = array();
			$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
			$result = getRemoteContents("https://openexchangerates.org/api/latest.json?app_id=".$settings['openexchangeratesApiKey']);
			if($result) {
				$result = json_decode($result,true);
				if(isset($result['rates'])) {
					$data = $result['rates'];
					$tableData = array();
					foreach($data as $currency => $rate) {
						$values = array();
						$values['currency'] = $currency;
						$values['rate'] = $rate;
						array_push($tableData,$values);
					}
					$this->DefaultModel->updateData("currency-rates", $tableData, ["batchUpdate" => "currency", "cache" => ["action" => "delete", "name" => "crc_currency_rates"]]);
					$response['status'] = "success";
					$response['message'] = "Currency rates updated successfully.";
				}
				else {
					$response['status'] = "error";
					$response['message'] = "Unable to fetch data form API.";
				}
			}
			else {
				$response['status'] = "error";
				$response['message'] = "Unable to fetch data form API.";
			}
			echo json_encode($response);
		}
	}
	
	public function captcha_settings() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$values = array();
			
			$siteKey = clearString($this->security->xss_clean($this->input->post("siteKey")));
			$data['siteKey'] = $siteKey;
			$values['siteKey'] = $siteKey;
			if(empty($siteKey)) {
				$error = true;
				$data['siteKeyError'] = "Site key should not be empty";
			}
			
			$secretKey = clearString($this->security->xss_clean($this->input->post("secretKey")));
			$data['secretKey'] = $secretKey;
			$values['secretKey'] = $secretKey;
			if(empty($secretKey)) {
				$error = true;
				$data['secretKeyError'] = "Secret key should not be empty";
			}
			
			$loginCaptcha = clearString($this->security->xss_clean($this->input->post("loginCaptcha")));
			$loginCaptcha = ($loginCaptcha == "on" ? 1 : 0);
			$data['loginCaptcha'] = $loginCaptcha;
			$values['loginCaptcha'] = $loginCaptcha;
			
			$forgotPasswordCaptcha = clearString($this->security->xss_clean($this->input->post("forgotPasswordCaptcha")));
			$forgotPasswordCaptcha = ($forgotPasswordCaptcha == "on" ? 1 : 0);
			$data['forgotPasswordCaptcha'] = $forgotPasswordCaptcha;
			$values['forgotPasswordCaptcha'] = $forgotPasswordCaptcha;
			
			$resetPasswordCaptcha = clearString($this->security->xss_clean($this->input->post("resetPasswordCaptcha")));
			$resetPasswordCaptcha = ($resetPasswordCaptcha == "on" ? 1 : 0);
			$data['resetPasswordCaptcha'] = $resetPasswordCaptcha;
			$values['resetPasswordCaptcha'] = $resetPasswordCaptcha;
			
			$contactCaptcha = clearString($this->security->xss_clean($this->input->post("contactCaptcha")));
			$contactCaptcha = ($contactCaptcha == "on" ? 1 : 0);
			$data['contactCaptcha'] = $contactCaptcha;
			$values['contactCaptcha'] = $contactCaptcha;
			
			$captchaShowFailedAttempts = clearString($this->security->xss_clean($this->input->post("captchaShowFailedAttempts")));
			$data['captchaShowFailedAttempts'] = $captchaShowFailedAttempts;
			$values['captchaShowFailedAttempts'] = $captchaShowFailedAttempts;
			if(!is_numeric($captchaShowFailedAttempts)) {
				$error = true;
				$data['captchaShowFailedAttemptsError'] = "Should be a numeric value";
			}
			
			if(!$error) {
				$this->DefaultModel->updateData("captcha-settings",$values,["cache" => ["action" => "delete", "name" => "crc_captcha_settings"]]);
			}
		}
		else {
			$captchaSettings = $this->DefaultModel->getData("captcha-settings","single",["cache" => ["name" => "crc_captcha_settings"]]);
			$data['siteKey'] = $captchaSettings['siteKey'];
			$data['secretKey'] = $captchaSettings['secretKey'];
			$data['loginCaptcha'] = $captchaSettings['loginCaptcha'];
			$data['forgotPasswordCaptcha'] = $captchaSettings['forgotPasswordCaptcha'];
			$data['resetPasswordCaptcha'] = $captchaSettings['resetPasswordCaptcha'];
			$data['contactCaptcha'] = $captchaSettings['contactCaptcha'];
			$data['captchaShowFailedAttempts'] = $captchaSettings['captchaShowFailedAttempts'];
		}
		$data['error'] = $error;
		$this->load->view("admin/captcha_settings",$data);
	}
	
	public function analytics_settings() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$values = array();
			
			$code = htmlspecialchars(trim($this->input->post("code")),ENT_QUOTES, "UTF-8");
			$data['code'] = $code;			
			
			$values['code'] = $code;
			if(empty($code)) {
				$error = true;
				$data['codeError'] = "Should not be empty";
			}
			
			if(!$error) {
				$this->DefaultModel->updateData("analytics-settings",$values,["cache" => ["action" => "delete", "name" => "crc_analytics_settings"]]);
			}
			
		}
		else {
			$analyticsSettings = $this->DefaultModel->getData("analytics-settings","single",["cache" => ["name" => "crc_analytics_settings"]]);
			$data['status'] = $analyticsSettings['status'];
			$data['code'] = $analyticsSettings['code'];
		}
		$data['error'] = $error;
		$this->load->view("admin/analytics_settings",$data);
	}
	
	public function ads_settings() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$values = array();
			
			$ad728x90Status = clearString($this->security->xss_clean($this->input->post("ad728x90Status")));
			$ad728x90Status = ($ad728x90Status == "on" ? 1 : 0);
			$data['ad728x90Status'] = $ad728x90Status;
			$values['ad728x90Status'] = $ad728x90Status;
			
			$ad728x90ResponsiveStatus = clearString($this->security->xss_clean($this->input->post("ad728x90ResponsiveStatus")));
			$ad728x90ResponsiveStatus = ($ad728x90ResponsiveStatus == "on" ? 1 : 0);
			$data['ad728x90ResponsiveStatus'] = $ad728x90ResponsiveStatus;
			$values['ad728x90ResponsiveStatus'] = $ad728x90ResponsiveStatus;
			
			$ad728x90 = htmlspecialchars(trim($this->input->post("ad728x90")),ENT_QUOTES, "UTF-8");
			$data['ad728x90'] = $ad728x90;	
			$values['ad728x90'] = $ad728x90;			
			if($ad728x90Status == 1) {
				if(empty($ad728x90)) {
					$error = true;
					$data['ad728x90Error'] = "Should not be empty";
				}
			}
			
			$displayOnHomePage = clearString($this->security->xss_clean($this->input->post("displayOnHomePage")));
			$displayOnHomePage = ($displayOnHomePage == "on" ? 1 : 0);
			$data['displayOnHomePage'] = $displayOnHomePage;
			$values['displayOnHomePage'] = $displayOnHomePage;
			
			$displayOnCoinPage = clearString($this->security->xss_clean($this->input->post("displayOnCoinPage")));
			$displayOnCoinPage = ($displayOnCoinPage == "on" ? 1 : 0);
			$data['displayOnCoinPage'] = $displayOnCoinPage;
			$values['displayOnCoinPage'] = $displayOnCoinPage;
			
			$displayOnDynamicPages = clearString($this->security->xss_clean($this->input->post("displayOnDynamicPages")));
			$displayOnDynamicPages = ($displayOnDynamicPages == "on" ? 1 : 0);
			$data['displayOnDynamicPages'] = $displayOnDynamicPages;
			$values['displayOnDynamicPages'] = $displayOnDynamicPages;
			
			$displayOnContactPage = clearString($this->security->xss_clean($this->input->post("displayOnContactPage")));
			$displayOnContactPage = ($displayOnContactPage == "on" ? 1 : 0);
			$data['displayOnContactPage'] = $displayOnContactPage;
			$values['displayOnContactPage'] = $displayOnContactPage;
			
			$displayOnWatchlistPage	 = clearString($this->security->xss_clean($this->input->post("displayOnWatchlistPage")));
			$displayOnWatchlistPage	 = ($displayOnWatchlistPage	 == "on" ? 1 : 0);
			$data['displayOnWatchlistPage'] = $displayOnWatchlistPage;
			$values['displayOnWatchlistPage'] = $displayOnWatchlistPage;
			
			$displayOnPortfolioPage = clearString($this->security->xss_clean($this->input->post("displayOnPortfolioPage")));
			$displayOnPortfolioPage = ($displayOnPortfolioPage == "on" ? 1 : 0);
			$data['displayOnPortfolioPage'] = $displayOnPortfolioPage;
			$values['displayOnPortfolioPage'] = $displayOnPortfolioPage;
			
			$displayOnMoversPage = clearString($this->security->xss_clean($this->input->post("displayOnMoversPage")));
			$displayOnMoversPage = ($displayOnMoversPage == "on" ? 1 : 0);
			$data['displayOnMoversPage'] = $displayOnMoversPage;
			$values['displayOnMoversPage'] = $displayOnMoversPage;
			
			if(!$error) {
				$this->DefaultModel->updateData("ads-settings",$values,["cache" => ["action" => "delete", "name" => "crc_ads_settings"]]);
			}
		}
		else {
			$adsSettings = $this->DefaultModel->getData("ads-settings","single",["cache" => ["name" => "crc_ads_settings"]]);
			$data['ad728x90Status'] = $adsSettings['ad728x90Status'];
			$data['ad728x90ResponsiveStatus'] = $adsSettings['ad728x90ResponsiveStatus'];
			$data['ad728x90'] = $adsSettings['ad728x90'];
			$data['displayOnHomePage'] = $adsSettings['displayOnHomePage'];
			$data['displayOnCoinPage'] = $adsSettings['displayOnCoinPage'];
			$data['displayOnDynamicPages'] = $adsSettings['displayOnDynamicPages'];
			$data['displayOnContactPage'] = $adsSettings['displayOnContactPage'];
			$data['displayOnWatchlistPage'] = $adsSettings['displayOnWatchlistPage'];
			$data['displayOnPortfolioPage'] = $adsSettings['displayOnPortfolioPage'];
			$data['displayOnMoversPage'] = $adsSettings['displayOnMoversPage'];
		}
		$data['error'] = $error;
		$this->load->view("admin/ads_settings",$data);
	}
	
	public function mail_settings() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$values = array();
			
			$smtpStatus = clearString($this->security->xss_clean($this->input->post("smtpStatus")));
			$smtpStatus = ($smtpStatus == "on" ? 1 : 0);
			$data['smtpStatus'] = $smtpStatus;
			$values['smtpStatus'] = $smtpStatus;
				
			$host = clearString($this->security->xss_clean($this->input->post("host")));
			$data['host'] = $host;
				
			$port = clearString($this->security->xss_clean($this->input->post("port")));
			$data['port'] = $port;
			
			$username = clearString($this->security->xss_clean($this->input->post("username")));
			$data['username'] = $username;
			
			$password = clearString($this->security->xss_clean($this->input->post("password")));
			$data['password'] = $password;
			
			if($smtpStatus == 1) {
				$values['host'] = $host;
				if(empty($host)) {
					$error = true;
					$data['hostError'] = "Should not be empty";
				}
				
				$values['port'] = $port;
				if(!is_numeric($port)) {
					$error = true;
					$data['portError'] = "Should be a numeric value";
				}
				
				$values['username'] = $username;
				if(empty($username)) {
					$error = true;
					$data['usernameError'] = "Should not be empty";
				}
				
				$values['password'] = $password;
				if(empty($password)) {
					$error = true;
					$data['passwordError'] = "Should not be empty";
				}
			}
			
			$contactEmail = clearString($this->security->xss_clean($this->input->post("contactEmail")));
			$data['contactEmail'] = $contactEmail;
			$values['contactEmail'] = $contactEmail;
			if(!validEmail($contactEmail)) {
				$error = true;
				$data['contactEmailError'] = "Invalid email address";
			}
			
			if(!$error) {
				$this->DefaultModel->updateData("mail-settings",$values,["cache" => ["action" => "delete", "name" => "crc_mail_settings"]]);
			}
		}
		else {
			$mailSettings = $this->DefaultModel->getData("mail-settings","single",["cache" => ["name" => "crc_mail_settings"]]);
			$data['smtpStatus'] = $mailSettings['smtpStatus'];
			$data['host'] = $mailSettings['host'];
			$data['port'] = $mailSettings['port'];
			$data['username'] = $mailSettings['username'];
			$data['password'] = $mailSettings['password'];
			$data['contactEmail'] = $mailSettings['contactEmail'];
		}
		$data['error'] = $error;
		$this->load->view("admin/mail_settings",$data);
	}
	
	
	public function add_language() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$name = clearString($this->security->xss_clean($this->input->post("name")));
			$data['name'] = $name;
			$values['name'] = $name;
			if(empty($name)) {
				$error = true;
				$data['nameError'] = "Name should not be empty";
			}
			
			$code = clearString($this->security->xss_clean($this->input->post("code")));
			$data['code'] = $code;
			$values['code'] = $code;
			if(empty($code)) {
				$error = true;
				$data['codeError'] = "Code should not be empty";
			}
			else if($this->DefaultModel->getData("languages","count",["where" => ["code" => $code]]) > 0) {
				$error = true;
				$data['codeError'] = "Code already exist";
			}
			
			$flag = clearString($this->security->xss_clean($this->input->post("flag")));
			$data['flag'] = $flag;
			$values['flag'] = $flag;
			if(empty($flag)) {
				$error = true;
				$data['flagError'] = "Please select a value";
			}
			
			if($error == false) {
				$maxOrderResult = $this->DefaultModel->getData("languages","single",["selectMax" => "displayOrder"]);
				$values['displayOrder'] = $maxOrderResult['displayOrder'] + 1;
				$id = $this->DefaultModel->insertData("languages",$values,["lastInsertId" => true, "cache" => ["action" => "delete", "name" => ["crc_languages","crc_languages_variables_count"]]]);
				$file = fopen("lang-files/".$id.".json", "w");
				fclose($file);
			}
		}
		$data['error'] = $error;
		$countries = json_decode(file_get_contents("assets/countries/names.json"),true);
		$data['countries'] = $countries;
		$this->load->view("admin/add_language",$data);
	}
	
	public function languages() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$languages = $this->DefaultModel->getData("languages","multiple");
		$data['languages'] = $languages;
		
		$cacheVar = "crc_total_language_variables";
		if(!$totalLangVars = $this->cache->get($cacheVar)) {
			$this->load->helper("language");
			$totalLangVars = count(getLanguageRec());
			$this->cache->save($cacheVar,$totalLangVars,(86400*30));
		}
		$data['totalLangVars'] = $totalLangVars;
		
		$cacheVar = "crc_languages_variables_count";
		if(!$langVarsCount = $this->cache->get($cacheVar)) {
			$langVarsCount = array();
			foreach($languages as $language) {
				$id = $language['id'];
				$languageValues = file_get_contents("lang-files/".$id.".json");
				$languageValues = json_decode($languageValues,true);
				$langVarsCount[$id] = (is_array($languageValues) && count($languageValues) > 0 ? count(array_filter($languageValues)) : 0);
			}
			$this->cache->save($cacheVar,$langVarsCount,(86400*30));
		}
		
		$data['langVarsCount'] = $langVarsCount;
		$this->load->view("admin/languages",$data);
	}
	
	public function edit_language($id = null) {
		if(is_numeric($id)) {
			$id = clearString($this->security->xss_clean($id));
			$data = array();
			$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
			$data['settings'] = $settings;
			$data['id'] = $id;
			$error = false;
			if(isset($_POST['submit'])) {
				$name = clearString($this->security->xss_clean($this->input->post("name")));
				$data['name'] = $name;
				$values['name'] = $name;
				if(empty($name)) {
					$error = true;
					$data['nameError'] = "Name should not be empty";
				}
				
				$oldCode = clearString($this->security->xss_clean($this->input->post("oldCode")));
				$data['oldCode'] = $oldCode;
				$code = clearString($this->security->xss_clean($this->input->post("code")));
				$data['code'] = $code;
				$values['code'] = $code;
				if($code != $oldCode) {
					if(empty($code)) {
						$error = true;
						$data['codeError'] = "Code should not be empty";
					}
					else if($this->DefaultModel->getData("languages","count",["where" => ["code" => $code]]) > 0) {
						$error = true;
						$data['codeError'] = "Language code already exists";
					}
				}
				
				$flag = clearString($this->security->xss_clean($this->input->post("flag")));
				$data['flag'] = $flag;
				$values['flag'] = $flag;
				
				$status = clearString($this->security->xss_clean($this->input->post("status")));
				$status = ($status == "on" ? 1 : 0);
				$data['status'] = $status;
				$values['status'] = $status;
				
				if($error == false) {
					$data['oldCode'] = $code;
					$this->DefaultModel->updateData("languages",$values,["where" => ["id" => $id], "cache" => ["action" => "delete", "name" => ["crc_languages","crc_default_language","crc_language_".$id]]]);
				}
			}
			else {
				$language = $this->DefaultModel->getData("languages","single",["where" => ["id" => $id], "limit" => 1]);
				if(is_array($language) && count($language) > 0) {
					$data['name'] = $language['name'];
					$data['code'] = $language['code'];
					$data['flag'] = $language['flag'];
					$data['status'] = $language['status'];
				}
				else {
					redirect(base_url(ADMIN_CONTROLLER."/languages"),"location");
					exit();
				}
			}
			$data['error'] = $error;
			$countries = json_decode(file_get_contents("assets/countries/names.json"),true);
			$data['countries'] = $countries;
			$this->load->view("admin/edit_language",$data);
		}
		else {
			redirect(base_url(ADMIN_CONTROLLER."/languages"),"location");
			exit();
		}
	}
	
	public function edit_language_values($id = null) {
		if(is_numeric($id)) {
			$id = clearString($this->security->xss_clean($id));
			$language = $this->DefaultModel->getData("languages","single",["where" => ["id" => $id], "limit" => 1]);
			if(is_array($language) && count($language) > 0) {
				if(file_exists("lang-files/".$id.".json")) {
					$data = array();
					$data['settings'] = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
					$data['id'] = $id;
					$data['language'] = $language;
					$this->load->helper("language");
					$data['languageRec'] = getLanguageRec();
					$error = false;
					$data['error'] = $error;
					if(isset($_POST['submit'])) {
						array_pop($_POST);
						$languageValues = $_POST;
						file_put_contents("lang-files/".$id.".json",json_encode($languageValues));
						$_POST['submit'] = "submit";
						$this->DefaultModel->deleteCacheVar("crc_languages_variables_count");
					}
					else {
						$languageValues = file_get_contents("lang-files/".$id.".json");
						$languageValues = json_decode($languageValues,true);
					}
					$data['languageValues'] = $languageValues;
					$this->load->view("admin/edit_language_values",$data);
				}
				else {
					redirect(base_url(ADMIN_CONTROLLER."/languages"),"location");
					exit();
				}
			}
			else {
				redirect(base_url(ADMIN_CONTROLLER."/languages"),"location");
				exit();
			}
		}
	}
	
	public function update_languages_order() {
		if(isset($_POST['updateLanguagesOrder']) && $_POST['updateLanguagesOrder'] == 'updateLanguagesOrder') {
			$order = $_POST['order'];
			if(is_array($order)) {
				$data = array();
				$count = count($order);
				for ($i = 0,$j = 1; $i < $count; $i++,$j++)  {
					$values = array();
					$id = $order[$i];
					$values['id'] = $id;
					$values['displayOrder'] = $j;
					array_push($data,$values);
				}
				$this->DefaultModel->updateData("languages",$data,["batchUpdate" => "id", "cache" => ["action" => "delete","name" => ["crc_languages","crc_default_language"]]]);
			}
		}
	}
	
	public function delete_language() {
		if(isset($_POST['deleteLanguage']) && $_POST['deleteLanguage'] == 'deleteLanguage') {
			$status = clearString($this->security->xss_clean($this->input->post("status")));
			if($status == 0 || ($status == 1 && $this->DefaultModel->getData("languages","count",["where" => ["status" => 1]]) > 1)) {
				$id = clearString($this->security->xss_clean($this->input->post("id")));
				$this->DefaultModel->deleteData("languages",["where" => ["id" => $id], "cache" => ["action" => "delete", "name" => ["crc_languages","crc_languages_variables_count","crc_default_language","crc_language_".$id]]]);
				$file = "lang-files/".$id.".json";
				if(file_exists($file)) {
					unlink($file);
				}
				echo json_encode(["status" => "success"]);
			}
			else {
				echo json_encode(["status" => "error", "message" => "Could not delete that langauge"]);
			}
		}
	}
	
	public function pages() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$pages = $this->DefaultModel->getData("pages","multiple",["select" => "id,title,permalink,status", "orderBy" => ["name" => "displayOrder" , "order" => "asc"]]);
		$data['pages'] = $pages;
		$this->load->view("admin/pages",$data);
	}
	
	public function update_pages_order() {
		if(isset($_POST['updatePagesOrder']) && $_POST['updatePagesOrder'] == 'updatePagesOrder') {
			$order = $_POST['order'];
			if(is_array($order)) {
				$data = array();
				$count = count($order);
				for ($i = 0,$j = 1; $i < $count; $i++,$j++)  {
					$values = array();
					$id = $order[$i];
					$values['id'] = $id;
					$values['displayOrder'] = $j;
					array_push($data,$values);
				}
				$this->DefaultModel->updateData("pages",$data,["batchUpdate" => "id", "cache" => ["action" => "delete","name" => "crc_pages"]]);
			}
		}
	}
	
	public function delete_page() {
		if(isset($_POST['deletePage']) && $_POST['deletePage'] == 'deletePage') {
			$id = clearString($this->security->xss_clean($this->input->post("id")));
			$permalink = clearString($this->security->xss_clean($this->input->post("permalink")));
			$this->DefaultModel->deleteData("pages",['where' => ['id' => $id], "cache" => ["action" => "delete", "name" => ["crc_pages","crc_page_".$permalink]]]);
		}
	}
	
	public function add_page() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$title = clearString($this->security->xss_clean($this->input->post("title")));
			$data['title'] = $title;
			$values['title'] = $title;
			if(empty($title)) {
				$error = true;
				$data['titleError'] = "Title should not be empty";
			}
			
			$permalink = clearString($this->security->xss_clean($this->input->post("permalink")));
			$permalink = (!empty($permalink) ? generatePermalink($permalink) : generatePermalink($title));
			$data['permalink'] = $permalink;
			$values['permalink'] = $permalink;
			if($this->DefaultModel->getData("pages","count",["where" => ["permalink" => $permalink]]) > 0) {
				$error = true;
				$data['permalinkError'] = "Permalink already exists";
			}
			
			$description = clearString($this->security->xss_clean($this->input->post("description")));
			$data['description'] = $description;
			$values['description'] = $description;
			if(empty($description)) {
				$error = true;
				$data['descriptionError'] = "Description should not be empty";
			}
			
			$keywords = clearString($this->security->xss_clean($this->input->post("keywords")));
			$data['keywords'] = $keywords;
			$values['keywords'] = $keywords;
			if(empty($keywords)) {
				$error = true;
				$data['keywordsError'] = "Keywords field should not be empty";
			}
			
			$content = htmlspecialchars(trim($this->security->xss_clean($this->input->post("content"))),ENT_QUOTES, "UTF-8");
			$data['content'] = $content;
			$values['content'] = $content;
			if(empty($content)) {
				$error = true;
				$data['contentError'] = "Content field should not be empty";
			}
			
			$status = clearString($this->security->xss_clean($this->input->post("status")));
			$status = ($status == "on" ? 1 : 0);
			$data['status'] = $status;
			$values['status'] = $status;
			
			if($error == false) {
				$maxOrderResult = $this->DefaultModel->getData("pages","single",["selectMax" => "displayOrder"]);
				$values['displayOrder'] = $maxOrderResult['displayOrder'] + 1;
				$this->DefaultModel->insertData("pages",$values,["cache" => ["action" => "delete", "name" => "crc_pages"]]);
			}
		}
		$data['error'] = $error;
		$this->load->view("admin/add_page",$data);
	}
	
	public function edit_page($id = NULL) {
		if(is_numeric($id)) {
			$id = clearString($this->security->xss_clean($id));
			$data = array();
			$data['id'] = $id;
			$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
			$data['settings'] = $settings;
			$error = false;
			if(isset($_POST['submit'])) {
				$title = clearString($this->security->xss_clean($this->input->post("title")));
				$data['title'] = $title;
				$values['title'] = $title;
				if(empty($title)) {
					$error = true;
					$data['titleError'] = "Title should not be empty";
				}
				
				$oldPermalink = clearString($this->security->xss_clean($this->input->post("oldPermalink")));
				$data['oldPermalink'] = $oldPermalink;
				$permalink = clearString($this->security->xss_clean($this->input->post("permalink")));
				$permalink = (!empty($permalink) ? generatePermalink($permalink) : generatePermalink($title));
				$data['permalink'] = $permalink;
				$values['permalink'] = $permalink;
				if($permalink != $oldPermalink) {
					if($this->DefaultModel->getData("pages","count",["where" => ["permalink" => $permalink]]) > 0) {
						$error = true;
						$data['permalinkError'] = "Permalink already exists";
					}
				}
				
				$description = clearString($this->security->xss_clean($this->input->post("description")));
				$data['description'] = $description;
				$values['description'] = $description;
				if(empty($description)) {
					$error = true;
					$data['descriptionError'] = "Description should not be empty";
				}
				
				$keywords = clearString($this->security->xss_clean($this->input->post("keywords")));
				$data['keywords'] = $keywords;
				$values['keywords'] = $keywords;
				if(empty($keywords)) {
					$error = true;
					$data['keywordsError'] = "Keywords field should not be empty";
				}
				
				$content = htmlspecialchars(trim($this->security->xss_clean($this->input->post("content"))),ENT_QUOTES, "UTF-8");
				$data['content'] = $content;
				$values['content'] = $content;
				if(empty($content)) {
					$error = true;
					$data['contentError'] = "Content field should not be empty";
				}
				
				$status = clearString($this->security->xss_clean($this->input->post("status")));
				$status = ($status == "on" ? 1 : 0);
				$data['status'] = $status;
				$values['status'] = $status;
				
				if($error == false) {
					$data['oldPermalink'] = $permalink;
					$this->DefaultModel->updateData("pages",$values,["where" => ["id" => $id], "cache" => ["action" => "delete", "name" => ["crc_pages","crc_page_".$oldPermalink]]]);
				}
			}
			else {
				$page = $this->DefaultModel->getData("pages","single",['where' => ["id" => $id]]);
				if(is_array($page) && count($page) > 0) {
					$data['title'] = $page['title'];
					$data['permalink'] = $page['permalink'];
					$data['description'] = $page['description'];
					$data['keywords'] = $page['keywords'];
					$data['content'] = $page['content'];
					$data['status'] = $page['status'];
				}
				else {
					redirect(base_url(ADMIN_CONTROLLER."/pages"),"location");
					exit();
				}
			}
			$data['error'] = $error;
			$this->load->view("admin/edit_page",$data);
		}
		else {
			redirect(base_url(ADMIN_CONTROLLER."/pages"),"location");
			exit();
		}
	}
	
	public function profile() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$username = clearString($this->security->xss_clean($this->input->post("username")));
			$data['username'] = $username;
			$values['username'] = $username;
			if(!isAlphaNum($username)) {
				$error = true;
				$data['usernameError'] = "Only A-z and 0-9 allowed";
			}
			
			$email = clearString($this->security->xss_clean($this->input->post("email")));
			$data['email'] = $email;
			$values['email'] = $email;
			if(!validEmail($email)) {
				$error = true;
				$data['emailError'] = "Not a valid email address";
			}
			
			if(!$error) {
				$this->DefaultModel->updateData("users",["username" => $username, "email" => $email]);
				$userInfo = $this->session->userdata("crc_user");
				$userInfo['username'] = $username;
				$userInfo['email'] = $email;
				delete_cookie('crc_ud');
				$this->session->set_userdata("crc_user",$userInfo);
			}
		}
		else {
			$data['username'] = $this->session->userdata("crc_user")['username'];
			$data['email'] = $this->session->userdata("crc_user")['email'];
		}
		$data['error'] = $error;
		$this->load->view("admin/profile",$data);
	}
	
	public function change_password() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		$error = false;
		if(isset($_POST['submit'])) {
			$oldPassword = $this->input->post("oldPassword");
			$data['oldPassword'] = $oldPassword;
			
			$newPassword = $this->input->post("newPassword");
			$data['newPassword'] = $newPassword;
			
			$confirmNewPassword = $this->input->post("confirmNewPassword");
			$data['confirmNewPassword'] = $confirmNewPassword;
			
			$userInfo = $this->session->userdata("crc_user");
			
			if(md5($oldPassword) != $userInfo['password']) {
				$error = true;
				$data['oldPasswordError'] = "Invalid old password";
			}
			else if(empty($newPassword)) {
				$error = true;
				$data['newPasswordError'] = "Should not be empty";
			}
			else if(empty($confirmNewPassword)) {
				$error = true;
				$data['confirmNewPasswordError'] = "Should not be empty";
			}
			else if($newPassword != $confirmNewPassword) {
				$error = true;
				$data['newPasswordError'] = "Passwords does not match";
			}
			else {
				$newPass = md5($newPassword);
				$this->DefaultModel->updateData("users",["password" => $newPass],["where" => ["id" => $userInfo['id']]]);
				$userInfo['password'] = $newPass;
				$this->session->set_userdata("crc_user",$userInfo);
			}
		}
		$data['error'] = $error;
		$this->load->view("admin/change_password",$data);
	}
	
	public function clear_cache() {
		$data = array();
		$settings = $this->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
		$data['settings'] = $settings;
		if(isset($_POST['submit'])) {
			$check = $this->input->post("check");
			if($check == 1) {
				$this->cache->clean();
			}
		}
		$this->load->view("admin/clear_cache",$data);
	}
}
?>