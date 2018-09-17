<?php
class AuthModel extends CI_Model {
	public function checkUserRecord($uoe,$password) {
		$uoe = $this->DefaultModel->escapeValues($uoe);
		$this->db->group_start();
		$this->db->or_where('username', $uoe);
		$this->db->or_where('email', $uoe);
		$this->db->group_end();
		$this->db->where("password",$password);
		$this->db->limit(1);
		return $this->db->get('users')->row_array();
	}
	
	public function checkUserRecord_I($uoe) {
		$uoe = $this->DefaultModel->escapeValues($uoe);
		$this->db->group_start();
		$this->db->or_where('username', $uoe);
		$this->db->or_where('email', $uoe);
		$this->db->group_end();
		$this->db->limit(1);
		return $this->db->get('users')->row_array();
	}
	
	public function updatePassword($newPassword,$id) {
		$id = $this->DefaultModel->escapeValues($id);
		$this->db->where("id",$id);
		$this->db->set("password",$newPassword);
		$this->db->update("users");
	}
}
?>