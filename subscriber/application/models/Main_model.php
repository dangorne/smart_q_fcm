<?php
class Main_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function existingusername(){

    $this->db->where('userName', $this->input->post('user'));
    if($this->db->count_all_results('subscriber') == 1){
      return TRUE;
    }

    return FALSE;
	}

  public function correctpassword(){

    $this->db->where('userName', $this->input->post('user'));
    $this->db->where('password', $this->input->post('pass'));

    if($this->db->count_all_results('subscriber') == 1){
      return TRUE;
    }

    return FALSE;
  }

	public function existingsubscriber(){

    $this->db->where('userName', $this->input->post('user'));
    $this->db->where('password', $this->input->post('pass'));

    if($this->db->count_all_results('subscriber') == 1){
      return TRUE;
    }

    return FALSE;
	}

  public function signup(){

		$this->load->helper('url');

    if($this->existingusername()){
      return FALSE;
    }

    $this->db->reset_query();

		$data = array(
      'id_number' => $this->input->post('idnum'),
			'userName' => $this->input->post('user'),
			'password' => $this->input->post('pass'),
      'cell_number' => $this->input->post('phonenum'),
      'subscriber_college' => $this->input->post('college'),
		);

		$this->db->insert('subscriber', $data);

    return TRUE;
	}

  public function hasqueue(){

    $this->db->where('client_userName', $this->session->userdata('username'));
    $this->db->where('queue_name', 'none');
    if($this->db->count_all_results('client_info') == 0){
      return TRUE;
    }

    return FALSE;
  }

  public function getcurrentservicenum($var){

    $this->db->where('queue_name', $var);

    $serving = $this->db->get('client_transaction')->row()->serving_atNo;

    $this->db->where('queue_name', $var);

    $click = $this->db->get('client_transaction')->row()->click;

    return $serving + $click;

  }

  public function getqueue(){

    $this->db->where('client_userName', $this->session->userdata('username'));

    return $this->db->get('client_info')->row()->queue_name;

  }

  public function getstatus($queue){

    $this->db->where('queue_name', $queue);

    $var = $this->db->get('client_transaction')->row();

    if($var->life == 1){
      return 'ONGOING';
    }else if ($var->life == 2){
      return 'PAUSED';
    }else if ($var->life == 3){
      return 'CLOSED';
    }else{
      return 'UNIDENTIFIED';
    }
  }

   public function getsearchresult($match){

    if($match != ''){

      $this->db->like('queue_name', $match)
        ->group_start()
        ->where('life', 1)
        ->or_where('life', 2)
        ->group_end();

      return $this->db->get('client_transaction')->result();
    }

    $this->db->where('life', 1);
    $this->db->or_where('life', 2);
    return $this->db->get('client_transaction')->result();
   }

   public function getlist(){

    $this->db->where('id_number', $this->getsubscriberid());
    $this->db->where('queuer_state', 'in');

    return $this->db->get('queuer')->result();
   }

   public function getself($queue){

    $this->db->where('id_number', $this->getsubscriberid());
    $this->db->where('queue_name', $queue);
    $this->db->where('queuer_state', 'in');

    return $this->db->get('queuer')->row()->queue_number;
   }

   public function fetchpanel($match){

      $this->db->like('queue_name', $match);

      return $this->db->get('client_transaction')->row();
   }

  public function alreadyinqueue($queue){

    $this->db->reset_query();

    $this->db->where('id_number', $this->getsubscriberid());
    $this->db->where('queue_name', $queue);
    $this->db->where('queuer_state', 'in');


    if($this->db->count_all_results('queuer') > 0){
      return TRUE;
    }

    return FALSE;

  }

  public function getsubscriberid(){

    $this->db->reset_query();
    $this->db->where('userName', $this->session->userdata('username'));

    $var = $this->db->get('subscriber')->row();

    if($var){
      return $var->id_number;
    }else{
      return "none";
    }
  }

  public function incrementedlastnumber($queue){

    $this->db->where('queue_name', $queue);
    $this->db->set('total_deployNo', 'total_deployNo+1', FALSE);
    $this->db->update('client_transaction');

    $this->db->reset_query();

    $this->db->where('queue_name', $queue);
    $var = $this->db->get('client_transaction')->row();

    return $var->total_deployNo;
  }

  public function join($queue){

    date_default_timezone_set('Asia/Manila');

    if($this->alreadyinqueue($queue)){
      return "EXIST";
    }

    if($this->getStatus($queue) == "ONGOING"){

      $data = array(
   			 'id_number' => $this->getsubscriberid(),
         'queue_name' => $queue,
   			 'queue_number' => $this->incrementedlastnumber($queue),
         'join_time' => date('Y-m-d H:i:s'),
         'join_type' => 'web',
   		);

      $this->db->insert('queuer', $data);

      return "ONGOING";
    }else{

      return "PAUSED";
    }
 	}

  public function leave($queue){

    if(!$this->AlreadyInQueue($queue)){
      return "NOTINQUEUE";
    }

    $this->db->where('id_number', $this->getsubscriberid());
    $this->db->where('queue_name', $queue);
    $this->db->set('queuer_state', 'out');

    $this->db->update('queuer');

    return "LEFT";
  }

  public function fetchsubdetail(){

    $this->db->where('userName', $this->session->userdata['username']);
    return $this->db->get('subscriber')->row();
  }

  public function savesubdetail($phonenum, $college){

    $this->db->where('userName', $this->session->userdata['username']);

    $this->db->set('cell_number', $phonenum);
    $this->db->set('subscriber_college', $college);
    $this->db->update('subscriber');
  }

}
