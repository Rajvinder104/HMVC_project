<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrudeModel extends CI_Model
{
  public function add_data($insertdata)
  {
    $q = $this->db->insert('crudeform', $insertdata);
    if ($q) {
      return true;
    } else {
      return false;
    }
  }
  public function update_data($insertdata)
  {
    $q = $this->db->where('id', $insertdata['id'])->update('crudeform', $insertdata);
    if ($q) {
      return true;
    } else {
      return false;
    }
  }

  public function update($table,$where,$data)
  {
    $this->db->where($where);
    $this->db->update($table,$data);
  }

  public function get_records($table, $where, $select)
  {
    $this->db->select($select);
    $this->db->where($where);
    $query = $this->db->get($table);
    $res = $query->result_array();
    return $res;
  }

  public function get_single_record($table, $where, $select)
  {
    $this->db->select($select);
    $this->db->where($where);
    $query = $this->db->get($table);
    $res = $query->row_array();
    return $res;
  }
}
