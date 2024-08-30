<?php defined('BASEPATH') or exit('No direct script access allowed');

class NewModel extends CI_model
{

    public function __construct()
    {
        $this->load->database();
    }
    public function add_data($table, $userdata)
    {
        $this->db->insert($table, $userdata);
    }
    public function fetch_Data($table, $where, $select,$limit,$offset)
    {
        $this->db->limit($limit,$offset);
        $this->db->select($select);
        $this->db->where($where);
        $query = $this->db->get($table);
        $result = $query->result_array();
        return $result;
    }
    public function update_data($table, $where, $select)
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
        $this->db->update($table);
    }
    public function getTotalRows($table){
       return $this->db->count_all($table);
    }
}
