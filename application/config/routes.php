<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'CryptoHub';
$route['404_override'] = 'notFound';
$route['translate_uri_dashes'] = TRUE;
$route['chartLoadMain/([a-zA-Z*@]+)/([a-zA-Z]+)'] = "CryptoHub/chartLoadMain/$1/$2";
$route['coin/([a-zA-Z*@]+)'] = "CryptoHub/openCoinInfo/$1";
$route['sortHome'] = "CryptoHub/sortHome/$1";
$route['getChartAdmin'] = "ChartDash/loadAdminChart";
$route['getChartAdminStats'] = "ChartDash/getChartAdminStats";

$route['search/post'] = "CryptoHub/searchManage";
$route['coins-list-post'] = "CryptoHub/getCoinsListPost";
$route['calc_top_post'] = "Calculator/calcListTopPost";
$route['watchList_top_post'] = "Watch/watchListTopPost";
$route['search/watchList/post'] = "Watch/watchListSearchPost";
$route['search/calculator/post'] = "Calculator/calculatorSearchPost";
$route['watchList_load_more_post'] = "Watch/watchListLoadMorePost";
$route['portfolioList_top_post'] = "Portfolio/portfolioLoadMorePost";
$route['search/portfolio/post'] = "Portfolio/portfolioSearchPost";
$route['manage/watch'] = "Watch/manageWatch";
$route['calculator'] = "Calculator/load";
$route['manage/add/coins/portfolio'] = "Portfolio/addCoins";
$route['manage/edit/coins/portfolio'] = "Portfolio/editCoins";
$route['manage/del/coins/portfolio'] = "Portfolio/delCoins";
$route['watch-list'] = "Watch/loadWatchList";
$route['portfolio'] = "Portfolio/loadPortfolio";
$route['movers'] = "CryptoHub/movers";
$route['portfolio/([a-zA-Z*@]+)'] = "Portfolio/loadPortfolio/$1";
$route['manage/account/new'] = "Accounts/create";
$route['manage/account/restore'] = "Accounts/restore";
$route['manage/account/update_username'] = "Accounts/updateUsername";
$route['logout'] = "Accounts/logout";
$route['page/(:any)'] = "Pages/loadaPage/$1";

$controllerNames = [
	ADMIN_CONTROLLER => "admin",
	AUTH_CONTROLLER => "auth"
];
$controller = $this->uri->segment(1);
if(array_key_exists($controller,$controllerNames)) {
	$controllerValue = $controllerNames[$controller];
	if($controller != $controllerValue) {
		$path = $this->uri->uri_string();
		$route[$path] = str_replace($controller,$controllerValue,$path);
	}
}
else {
	$notAllowed = array("auth","admin");
	if(in_array($controller,$notAllowed)) {
		$path = $this->uri->uri_string();
		$route[$path] = 'notFound';
	}
}
