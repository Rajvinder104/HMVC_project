<?php defined('BASEPATH') or exit('No direct script access allowed');

class HomeModel extends CI_Model
{
   public function __construct()
   {
      $this->load->database();
   }
   public function add_data($table, $userdata)
   {
      $this->db->insert($table, $userdata);
   }
   public function fetch_data($table, $where, $select, $limit, $offset)
   {
      $this->db->limit($limit, $offset);
      $this->db->select($select);
      $this->db->where($where);
      $query = $this->db->get($table);
      $result = $query->result_array();
      return $result;
   }
   public function get_single_record($table, $where, $select)
   {
      $this->db->select($select);
      $this->db->where($where);
      $query = $this->db->get($table);
      $result = $query->row_array();
      return $result;
   }
   public function update($table, $where, $data)
   {
      $this->db->where($where);
      $this->db->update($table, $data);
   }
   public function delete_data($table, $where)
   {
      $this->db->where($where);
      $this->db->delete($table);
   }
   public function get_sum($table, $where, $select)
    {
        $this->db->select($select);
        $query = $this->db->get_where($table, $where);
        $res = $query->row();
        return $res->sum;
    }


}
