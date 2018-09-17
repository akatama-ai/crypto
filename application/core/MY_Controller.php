<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		checkRedirect();
		if(!$this->input->is_ajax_request()) {
			/*** Count Stats For Front-End ***/
			$class = $this->router->fetch_class();
			$forbiddenClasses = array("admin","auth","logout","cron");
			if(!in_array($class,$forbiddenClasses)) {
				$countUnique = 0;
				if($this->input->cookie("crc_uv",true) == NULL) {
					$this->input->set_cookie("crc_uv",md5(uniqid()),86400);
					$countUnique = 1;
				}
				$date = date("Y-m-d");
				$cacheVar = "crc_stats_entry_".$date;
				$statsEntry = $this->cache->get($cacheVar);
				if(!is_null($statsEntry) && is_array($statsEntry) && count($statsEntry) > 0) {
					$statsEntry['pageViews'] = $statsEntry['pageViews'] + 1;
					$statsEntry['uniqueViews'] = ($countUnique == 1 ? $statsEntry['uniqueViews'] + 1 : $statsEntry['uniqueViews']);
					$this->DefaultModel->updateData("statistics",$statsEntry,["where" => ["date" => $date]]);
					$this->cache->save($cacheVar,$statsEntry,86400);
				}
				else {
					$entryRecord = $this->DefaultModel->getData("statistics","single",["where" => ["date" => $date], "limit" => 1]);
					if(is_array($entryRecord) && count($entryRecord > 0)) {
						$values = array();
						$values['date'] = $entryRecord['date'];
						$values['pageViews'] = $entryRecord['pageViews'] + 1;
						$values['uniqueViews'] = ($countUnique == 1 ? $entryRecord['uniqueViews'] + 1 : $entryRecord['uniqueViews']);
						$this->DefaultModel->updateData("statistics",$values,["where" => ["date" => $date]]);
						$this->cache->save($cacheVar,$values,86400);
					}
					else {
						$statsEntry = array();
						$statsEntry['date'] = $date;
						$statsEntry['pageViews'] = 1;
						$statsEntry['uniqueViews'] = ($countUnique == 1 ? 1 : 0);
						$this->DefaultModel->insertData("statistics",$statsEntry);
						$this->cache->save($cacheVar,$statsEntry,86400);
					}
				}
			}
			/*** END -- Count Stats For Front-End ***/
		}
	}
}
?>