<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChartDash extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		if(!$this->session->has_userdata('crc_access') || $this->session->userdata('crc_access') != true || !$this->session->has_userdata('crc_admin_access') || $this->session->userdata('crc_admin_access') != true) {
			redirect(base_url(AUTH_CONTROLLER."/login"),"location");
			exit();
		}
	}
	function array2csv(array &$array)
	{
	   if (count($array) == 0) {
		 return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   fputcsv($df, array_keys(reset($array)));
	   foreach ($array as $row) {
		  fputcsv($df, $row);
	   }
	   fclose($df);
	   return ob_get_clean();
	}
	function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2018 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
	}
	
	public function loadAdminChart()
	{
		$users=$this->DbLayer->getData('accounts',['ANY_VALUE(registered) as registered','count(*) as users'],$where=null,'all_array',$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col='registered',$order_by_type='asc',$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby='date(registered)',$like=null,$likecolumn=null,$distinct=false,$cacheIt=false);
		foreach($users as $index=>$value)
		{
			$date=date('d-m-Y',strtotime($value['registered']));
			$users[$index]['registered']=$date;
		}
		$this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		echo $this->array2csv($users);
		die();
		
	}
	public function getChartAdminStats()
	{
		$users=$this->DbLayer->getData('statistics',['date','pageViews as Page Views','uniqueViews as Unique Views'],$where=null,'all_array',$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col='date',$order_by_type='asc',$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=false);
		foreach($users as $index=>$value)
		{
			$date=date('d-m-Y',strtotime($value['date']));
			$users[$index]['date']=$date;
		}
		$this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		echo $this->array2csv($users);
		die();
		
	}
}