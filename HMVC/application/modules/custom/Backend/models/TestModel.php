<?php defined('BASEPATH') or exit('No direct script aceess allowed');

class TestModel extends CI_Model
{
    public function sum()
    {
        $a = 10;
        $b = 20;
        return $a + $b;
    }
    public function sub()
    {
        $a = 70;
        $b = 20;
        return $a - $b;
    }
    public function arrayData()
    {
        $database = $this->db->get('table');
        return $database->result_array();
    }
    public function arrayData2()
    {
        $database = $this->db->get('table');
        return $database->row_array();
    }
    public function objectData()
    {
        $database = $this->db->get('table');
        return $database->result_object();
    }
    public function objectData2()
    {
        $database = $this->db->get('table');
        return $database->row_object();
    }

    public function formdata($validdata)
    {
        $this->db->insert('table', $validdata);
    }
}
