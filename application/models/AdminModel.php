<?php
class AdminModel extends CI_Model {
	public function getCoinsData($page,$limit,$sort,$sortOrder,$search) {
		$data = array();
		$like = array();
		if($search != null) { $like['fullName'] = $search; }
		$data['totalCoins'] = $this->db->like($like)->count_all_results("coins");
		$start = ($page - 1) * $limit;
		$data['coins'] = $this->db->like($like)->limit($limit,$start)->order_by($sort, $sortOrder)->get('coins')->result_array();
		return $data;
	}
	
	public function getCurrenciesData($page,$limit,$sort,$sortOrder,$search) {
		$data = array();
		$like = array();
		if($search != null) {
			$like['currency'] = $search;
			$like['name'] = $search;
			$like['symbol'] = $search;
		}
		$data['totalCurrencies'] = $this->db->or_like($like)->count_all_results("currency-rates");
		$start = ($page - 1) * $limit;
		$data['currencies'] = $this->db->or_like($like)->limit($limit,$start)->order_by($sort, $sortOrder)->get('currency-rates')->result_array();
		return $data;
	}
	
	public function getStatsCount($startDate = null, $endDate = null) {
		if($startDate != null && $endDate != null) {
			$this->db->group_start();
			$this->db->where("date BETWEEN '$startDate' AND '$endDate'",null);
			$this->db->group_end();
		}
		$this->db->select_sum('pageViews');
		$this->db->select_sum('uniqueViews');
		$stats = $this->db->get("statistics")->row_array();
		return $stats;
	}
	public function getStatsCountAll() {
		$startDate = date('Y-m-d');
		$endDate = date("Y-m-d");
		$this->db->group_start();
		$this->db->where("date(registered) BETWEEN '$startDate' AND '$endDate'",null);
		$this->db->group_end();
		$this->db->select('count(*) as totalUsersToday');
		$totalUsersToday = $this->db->get("accounts")->row_array();
		$totalUsersToday=$totalUsersToday['totalUsersToday'];
		$allUsers = $this->db->count_all_results("accounts");
		$totalCurrencies = $this->db->count_all_results("currency-rates");
		$totalLanguages = $this->db->count_all_results("languages");
		$totalCoins = $this->db->count_all_results("coins");
		$totalPages = $this->db->count_all_results("pages");
		return ['totalUsersToday'=>$totalUsersToday,'totalCoins'=>$totalCoins,'allUsers'=>$allUsers,'totalCurrencies'=>$totalCurrencies,'totalLanguages'=>$totalLanguages,'totalPages'=>$totalPages];
	}
}
?>