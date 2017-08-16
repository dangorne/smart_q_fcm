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
        echo '<tr>';
        echo '<td>'.$row->queue_name.'</td>';
        echo '<td>'.$row->serving_atNo.'</td>';
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

      $search_result = $this->main_model->getList();

      foreach ($search_result as $row)
      {

        echo '<div class="list-group-item list-selected">';
        echo '<span class="list-qname"><strong>'.$row->queue_name.'</strong></span>';
        echo '<span class="badge badge-total">'.$row->queue_number.'</span>';
        echo '</div>';
      }
    }

    public function fetchqueuers(){

      $search_result = $this->main_model->fetchqueuers($this->input->post('selected'));

      foreach ($search_result as $row){
        echo '<tr>';
        echo '<td>'.date('h:i:s A, l - d M Y', strtotime($row->join_time)).'</td>';
        echo '<td>'.$row->queue_number.'</td>';
        echo '</tr>';
      }
    }

    public function join(){

      echo json_encode(array('res' => $this->main_model->join($this->input->post('selected'))));
    }
  }

?>
