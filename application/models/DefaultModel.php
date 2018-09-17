<?php
class DefaultModel extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file'));
	}
	
	public function escapeValues($esData) {
		if(is_array($esData)) {
			foreach ($esData as $key => $val) {
				$esData[$key] = $this->db->escape_str($val);
			}
		}
		else {
			$esData = $this->db->escape_str($esData);
		}
		return $esData;
	}
	
	public function deleteCacheVar($cacheVar) {
		if(is_array($cacheVar)) {
			foreach($cacheVar as $value) {
				$this->cache->delete($value);
			}
		}
		else {
			$this->cache->delete($cacheVar);
		}
	}
	
	public function getData($table, $type = "single", $parameters = array()) {
		$data = (isset($parameters['cache']) && isset($parameters['cache']['name']) ? $this->cache->get($parameters['cache']['name']) : NULL);
		if(empty($data)) {
			if(isset($parameters['select'])) { $this->db->select($parameters['select']); }
			if(isset($parameters['where'])) { $this->db->where($parameters['where']); }
			if(isset($parameters['orderBy'])) {
				$orderByValues = $parameters['orderBy'];
				$this->db->order_by($orderByValues['name'],$orderByValues['order']); 
			}
			if(isset($parameters['limit'])) {
				$limit = $parameters['limit'];
				if(is_array($limit)) {
					$this->db->limit($limit['value'],$limit['offset']);
				}
				else {
					$this->db->limit($limit);
				}
			}
			if(isset($parameters['selectMax'])) {
				$this->db->select_max($parameters['selectMax']);
			}
			if($type != "count") {
				$result = $this->db->get($table);
				$data = ($type == "single" ? $result->row_array() : $result->result_array());
				if($data) {
					if(isset($parameters['cache']) && isset($parameters['cache']['name'])) {
						$cacheVar = $parameters['cache']['name'];
						$cacheTime = (isset($parameters['cache']['cacheTime']) ? $parameters['cache']['cacheTime'] : 86400);
						$this->cache->save($cacheVar,$data,$cacheTime);
					}
				}
			}
			else {
				$data = $this->db->count_all_results($table);
			}
		}
		return $data;
	}
	
	public function updateData($table,$values,$parameters = array()) {
		if(isset($parameters['batchUpdate'])) {
			$this->db->update_batch($table,$values,$parameters['batchUpdate']);
		}
		else {
			$values = (isset($parameters['escapeValues']) ? $this->escapeValues($values) : $values);
			if(isset($parameters['where'])) { $this->db->where($parameters['where']); }
			$this->db->update($table,$values);
		}
		if(isset($parameters['cache'])) {
			$action = $parameters['cache']['action'];
			if($action == "delete") {
				$this->deleteCacheVar($parameters['cache']['name']);
			}
		}
	}
	
	public function insertData($table,$values,$parameters = array()) {
		if(isset($parameters['batchInsert'])) {
			$this->db->insert_batch($table,$values);
		}
		else {
			$values = (isset($parameters['escapeValues']) ? $this->escapeValues($values) : $values);
			$this->db->insert($table,$values);
			if(isset($parameters['lastInsertId'])) {
				return $this->db->insert_id();
			}
		}
		if(isset($parameters['cache'])) {
			$action = $parameters['cache']['action'];
			if($action == "delete") {
				$this->deleteCacheVar($parameters['cache']['name']);
			}
		}
	}
	
	public function deleteData($table,$parameters = array()) {
		if(isset($parameters['where'])) { $this->db->where($parameters['where']); }
		$this->db->delete($table);
		if(isset($parameters['cache'])) {
			$action = $parameters['cache']['action'];
			if($action == "delete") {
				$this->deleteCacheVar($parameters['cache']['name']);
			}
		}
	}
}
?>