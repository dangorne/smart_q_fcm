<?php

  class Asynch extends CI_Controller{

    public function __construct(){

      parent::__construct();

      $this->load->library('session');
      $this->load->model('main_model');
      $this->load->helper('url_helper');
    }

    public function fetchtable(){

      $var = $this->input->post('search');

      if($var == '' or !is_null($var)){
        $search_result = $this->main_model->getsearchresult($this->input->post('search'), TRUE);
      }else{
        $search_result = $this->main_model->getsearchresult();
      }

      foreach ($search_result as $row){
        $num = $row->serving_atNo + $row->click;
        echo '<tr>';
        echo '<td>'.$row->queue_name.'</td>';
        echo '<td>'.$num.'</td>';
        echo '<td>'.$row->total_deployNo.'</td>';
        echo '<td>'.$row->seats_offered.'</td>';
        echo '<td>'.$row->queue_description.'</td>';
        echo '<td>'.$row->queue_restriction.'</td>';
        echo '<td>'.$row->requirements.'</td>';
        echo '<td>'.$row->venue.'</td>';
        echo '</tr>';
      }

    }

    public function fetchlist(){

      $result = $this->main_model->getlist();

      foreach ($result as $row){

        echo '<div class="list-group-item list-selected">';
        echo '<span class="list-qname"><strong>'.$row->queue_name.'</strong></span>';
        echo '<span class="badge badge-total">'.$row->queue_number.'</span>';
        echo '</div>';
      }
    }

    public function fetchpanel(){

      $var = $this->input->post('selected');

      $search_result = $this->main_model->fetchpanel($this->input->post('selected'));

      $result = array(
        'queue_name' => $search_result->queue_name,
        'status' => $this->main_model->getstatus($search_result->queue_name),
        'serving_atNo' => $this->main_model->getcurrentservicenum($var),
        'total_deployNo' => $search_result->total_deployNo,
        'self' => $this->main_model->getself($var),
        'queue_description' => $search_result->queue_description,
        'queue_restriction' => $search_result->queue_restriction,
        'requirements' => $search_result->requirements,
        'venue' => $search_result->venue,
      );

      echo json_encode($result);
    }

    public function join(){

      $result = array('res' => $this->main_model->join($this->input->post('selected')));
      echo json_encode($result);
    }

    public function leave(){

      $result = array('res' => $this->main_model->leave($this->input->post('selected')));
      echo json_encode($result);
    }
  }

?>
