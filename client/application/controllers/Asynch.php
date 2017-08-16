<?php
  class Asynch extends CI_Controller{

    public function __construct(){

      parent::__construct();

      $this->load->library('session');
      $this->load->model('main_model');
      $this->load->helper('url_helper');

    }

    public function fetchwindow(){

      $query = $this->main_model->getclients();
      $result = $query->result();

      echo '<tr>';
      echo '<td class="table-data name" colspan="'.$query->num_rows().'">'.$this->main_model->getqueuename().'</td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="table-data total" colspan="'.$query->num_rows().'">'.$this->main_model->getdeployno().'</td>';
      echo '</tr>';

      echo '<tr>';
      foreach ($query->result() as $row){
        echo '<td class="table-data display">'.$row->display_name.'</td>';
      }
      echo '</tr>';

      echo '<tr>';
      foreach ($query->result() as $row){
        echo '<td class="table-data current">'.$row->current.'</td>';
      }
      echo '</tr>';

    }

    public function fetchlist(){

      $search_result = $this->main_model->fetchlist();

      foreach ($search_result as $row){
        echo '<div class="list-group-item list-selected">';
        echo '<span class="list-qname"><strong>'.$row->queue_name.'</strong></span>';
        echo '</div>';
      }
    }

    public function leave(){

      echo json_encode(array( 'success' => $this->main_model->leave($this->input->post('selected'))));
    }

    public function editdetail(){

      echo json_encode($this->main_model->editq($this->input->post('type'), $this->input->post('content')));
    }

    public function editdisplay(){

      echo json_encode($this->main_model->editdisplay($this->input->post('content')));
    }

    public function status(){

      $result = array(
        'qnum' => $this->main_model->getcurrentservicenum(),
        'idnum' => $this->main_model->getcurrentid(),
        'qstatus' => $this->main_model->getstatus(),
        'totalsub' => $this->main_model->getdeployno(),
      );

      echo json_encode($result);
    }

    public function fetchdetail(){

      if($this->main_model->hasqueue()){

        $query_result = $this->main_model->fetchdetail();

        $result = array(
          'display' => "true",
          'qname' => $query_result->queue_name,
          'code' => $query_result->queue_code,
          'seats' => $query_result->seats_offered,
          'desc' => $query_result->queue_description,
          'req' => $query_result->requirements,
          'venue' => $query_result->venue,
          'rest' => $query_result->queue_restriction,
        );

      }else{

        $result = array(
          'display' => "false",
        );
      }

      echo json_encode($result);
    }

    public function join(){
      echo json_encode($this->main_model->join());
    }

    public function create(){

      //validation here
      //'queue_restriction' => $this->input->post('input')['rest'],
      echo json_encode($this->main_model->create());
    }

    public function pause(){
      $this->main_model->setstatus(2);
      echo json_encode($this->main_model->getstatus());
    }

    public function resume(){
      $this->main_model->setstatus(1);
      echo json_encode($this->main_model->getstatus());
    }

    public function close(){

      $this->main_model->close();
    }

    public function stop(){
      $this->main_model->setstatus(3);
      echo json_encode($this->main_model->getstatus());
    }

    public function next(){

      if($this->main_model->getcurrentservicenum() < $this->main_model->getdeployno()){
        echo json_encode(array('servicenum' => $this->main_model->incrementcurrent(), 'idnum' => $this->main_model->incrementid()));
      }else{
        echo json_encode(array('servicenum' => $this->main_model->getcurrentservicenum(), 'idnum' => $this->main_model->getcurrentid()));
      }


    }

  }
?>
