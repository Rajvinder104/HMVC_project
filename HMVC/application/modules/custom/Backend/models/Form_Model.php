<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form_Model extends CI_Model
{


    public function add_data($postdata)
    {
        $post['id'] = mt_rand(11111, 99999);
        $post['name'] = $postdata['name'];
        $post['email'] = $postdata['email'];
        $post['password'] = $postdata['password'];
        $post['image'] = $postdata['image'];
        $this->db->insert('clients', $post);
    }
}
