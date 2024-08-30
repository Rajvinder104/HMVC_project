<?php defined('BASEPATH') OR exit ('No direct script access allowed');

class HomeController extends MX_Controller {

    // public function index(){

    //     $this->load->model('HomeModel');

    //     $data['sum'] = $this->HomeModel->sum();

    //      $this->load->view('homepage',$data);
    // }


    // public function myfun(){
    //    echo "hello world";
    // }
    public function index(){

    $this->load->model('HomeModel');
   $data = $this->HomeModel->queries();

   foreach($data as $value){
    echo "<br>Name :-".' '. $value->name . "<br>" ;
    echo "Password :-" .' '. $value->password . "<br>";
    echo "email :-" .' '. $value->email . "<br>";
   }

//    echo "Name :-" .' '. $data->name . "<br>";
//    echo "Password :-" .' '. $data->password;
//    echo "<pre>";
//    print_r($data). "<br>    ";
//    echo "</pre>";


}

}