<?php 
class DbLayer extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
		$this->checkAliveDb();
	}
	
	function getIpAddress()
	{
		switch(true) {
		case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
		case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
		case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
		default : return $_SERVER['REMOTE_ADDR'];
		}
	}
	
	function checkAliveDb()
	{
		if ($this->db->conn_id->ping() === FALSE)
		{
			sleep(1);
			$this->db->reconnect();
		}
	}
	
	function updateData($table,$data,$where=false,$batchColumn=false,$cacheIt=false)
	{
		
		if($where!==false)
		$this->db->where($where);
	
		if(!$batchColumn)
		$this->db->update($table,$data);
		else
		$this->db->update_batch($table,$data,$batchColumn);
		
		if($cacheIt)
		{
			$cacheIndex=$cacheIt['index'];
			$cacheValue=$cacheIt['cacheValue'];
			$this->cache->save($cacheValue, $return, 24*60*60);
		}
	}
	
	function deleteData($table,$where=false)
	{
		if($where!==false)
		$this->db->where($where);
		$this->db->delete($table);
	}
	
	function getData($table,$select=null,$where=null,$resultType="all_array",$join=false,$joinTable=null,$joinStatement=null,$joinType=null,$order_by_Col=null,$order_by_type=null,$limit=null,$wherep1=null,$whereinarray=null,$wherep2=null,$wherenotinarray=null,$groupby=null,$like=null,$likecolumn=null,$distinct=false,$cacheIt=false)
	{
		if($cacheIt)
		{
			if($cacheIt['getSet']==true)
			{
				if($coins=$this->cache->get($cacheIt['index']))
				{
					return $coins;
				}
			}
		}
		
		if($wherep1)
		{
			$this->db->where_in($wherep1,$whereinarray);
		}
		if(!$wherep1 && $where)
		{
			$this->db->where($where);
		}
		
		if($wherep2)
		$this->db->where_not_in($wherep2,$wherenotinarray);
		
		if($select)
		{
			$this->db->select($select);
		}
		if($join)
		{
			$this->db->join($joinTable,$joinStatement,$joinType);
		}
		if($like)
		{
			$this->db->like($likecolumn,$like);
		}
		if($order_by_Col)
		{
			$this->db->order_by($order_by_Col,$order_by_type);
		}
		if($groupby)
		{
			$this->db->group_by($groupby);
		}
		if($limit)
		{
			$this->db->limit($limit[0],$limit[1]);
		}
		if($distinct)
		{
			$this->db->distinct($distinct);
		}
		$record=$this->db;
		$return=null;
		// if($wherep1){
		// echo $record->get_compiled_select($table);
		// exit;
		// }
		if($resultType=="all_array")
		{
			$return=$record->get($table)->result_array();
		}
		else if($resultType=="row_array")
		{
			$return=$record->get($table)->row_array();
		}
		else
		{
			$return=$record->count_all_results($table);
		}
		
		if($cacheIt)
		{
			$cacheIndex=$cacheIt['index'];
			$this->cache->save($cacheIndex, $return,$cacheIt['time']);
		}	
		
		return $return;
	}
	function insertData($table,$insert,$batch=false)
	{
		
		if(!$batch)
		$this->db->insert($table,$insert);
		else
		$this->db->insert_batch($table,$insert);
		
	}
	function rawQuery($query,$resultType)
	{
		$record=$this->db;
		$res=$record->query($query);
		if($resultType=="all_array")
		{
			return $res->result_array();
		}
		else if($resultType=="row_array")
		{
			return $res->row_array();
		}
		else
		{
			return $res->count_all_results($table);
		}
	}
}