<?php
class User_model extends CI_Model
{


    public function __construct()
    {
        $this->load->database();
    }


    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        $res = $this->db->insert_id();
        return $res;
    }
    public function GetSingleRecord($table, $where, $select)
    {
        $this->db->select($select);
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    public function GetRecords($table, $where, $select)
    {
        $this->db->select($select);
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function GetSum($table, $where, $select)
    {
        $this->db->select($select);
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->row_object();
    }
    public function GetLimitRecords($table, $where, $select, $limit, $offset)
    {
        $this->db->select($select);
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function updateDirects($user_id)
    {
        $this->db->set('directs', 'directs + 1', false);
        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tbl_users');
    }
}
