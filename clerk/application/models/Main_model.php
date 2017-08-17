<?php
class Main_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function existingusername(){

    $this->db->where('username', $this->input->post('user'));
    if($this->db->count_all_results('clerk') == 1){
      return TRUE;
    }

    return FALSE;
	}

  public function correctpassword(){

    $this->db->where('username', $this->input->post('user'));
    $this->db->where('password', $this->input->post('pass'));

    if($this->db->count_all_results('clerk') == 1){
      return TRUE;
    }

    return FALSE;
  }

  public function existingcode($user_type, $code){

    if($user_type == "client"){

      $this->db->where('code', $code);

      if($this->db->count_all_results('permission_code') == 1){
        return TRUE;
      }
    }else if($user_type == "clerk"){

      $this->db->where('code', $code);

      if($this->db->count_all_results('clerk_code') == 1){
        return TRUE;
      }
    }

    return FALSE;
  }

	public function signup(){
		$this->load->helper('url');

    if($this->existingusername()){
      return FALSE;
    }

    if(!$this->existingcode("clerk", $this->input->post('code'))){
      return FALSE;
    }

    $this->db->reset_query();

		$data = array(
			'username' => $this->input->post('user'),
			'password' => $this->input->post('pass'),
		);

		$this->db->insert('clerk', $data);

    return TRUE;
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

  public function fetchqueuers($queue){

    $this->db->where('id_number', 'walk-in');
    $this->db->where('queue_name', $queue);
    $this->db->where('clerk_userName', $this->session->userdata['username']);

    return $this->db->get('queuer')->result();
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

  public function join($queue){

    date_default_timezone_set('Asia/Manila');

    if($this->getstatus($queue) == "ONGOING"){

      $data = array(
   			 'id_number' => 'walk-in',
         'queue_name' => $queue,
   			 'queue_number' => $this->incrementedlastnumber($queue),
         'clerk_userName' => $this->session->userdata['username'],
         'join_time' => date('Y-m-d H:i:s'),
         'join_type' => 'web',
   		);

      $this->db->insert('queuer', $data);

      return "ONGOING";
    }else{

      return "PAUSED";
    }
 	}

}
