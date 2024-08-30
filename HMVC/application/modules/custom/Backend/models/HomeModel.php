<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeModel extends CI_Model
{
  // public function sum(){
  //     $a = 10;
  //     $b = 30;
  //     return $a + $b;
  // }
  public function queries()
  {
    // $q =  $this->db->query('select * from clients');
    $q = $this->db->get('clients');
    return $q->result();
  }
}
