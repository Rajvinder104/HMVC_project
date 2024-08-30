<?php 
class Main_model extends CI_Model {


	    public function __construct()
    {
        $this->load->database();
    }

    public function get_single_record($table, $where, $select, $queryshow = false)
    {
        $this->db->select($select);
        $query = $this->db->get_where($table, $where);
        $res = $query->row_array();
        if ($queryshow == true)
            echo $this->db->last_query();
        return $res;
    }

  public function add($table, $data)
    {
        $this->db->insert($table,$data);
        $res = $this->db->insert_id();
        return $res;
    }
}
