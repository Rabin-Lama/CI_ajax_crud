<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contest_model extends CI_Model {

	public function getDistricts() {
		$query = $this->db->get('district');

		foreach($query->result() as $row) {
			$data[] = $row;
		}

		return $data;
	}

	public function getContestants() {
		$query = $this->db->get('contestant');

		foreach($query->result() as $row) {
			$data[] = $row;
		}

		return $data;
	}

	public function select_contestant() {
		$this->db->select('*, district.Id as districtId, contestant.Id as contestantId');
		$this->db->from('contestant');
		$this->db->join('district', 'contestant.DistrictId = district.Id');
		$this->db->order_by("Firstname", "asc");
		$query = $this->db->get();

		foreach($query->result() as $row) {
			$data[] = $row;
		}

		return $data;
	}

	public function select_contestant_by_id($id) {
		$this->db->from('contestant');
		$this->db->where('Id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function insert($data) {
		$this->db->insert('contestant', $data);
	}

	public function update_contestant($where, $data) {
		//$this->db->where('id', $where);
		//$this->db->update('contestant', $data);
		$query = "UPDATE `contestant` SET `Firstname` = '".$data['Firstname']."', `Lastname` = '".$data['Lastname']."', `DateOfBirth` = '".$data['DateOfBirth']."', `IsActive` = ".$data['IsActive'].", `DistrictId` = '".$data['DistrictId']."', `Gender` = '".$data['Gender']."', `PhotoUrl` = '".$data['PhotoUrl']."', `Address` = '".$data['Address']."' WHERE `id` = '".$where."'";
		$this->db->query($query);

		//return $this->db->affected_rows();
	}

	public function delete_contestant($id) {
		$this->db->where('Id', $id);
		$this->db->delete('contestant');
	}

}
