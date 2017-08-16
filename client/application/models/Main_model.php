<?php
class Main_model extends CI_Model {

  public function __construct(){
    $this->load->database();
  }

  public function existingusername(){

    $this->db->where('client_userName', $this->input->post('user'));
    if($this->db->count_all_results('client_info') == 1){
      return TRUE;
    }

    return FALSE;
	}

  public function correctpassword(){

    $this->db->where('client_userName', $this->input->post('user'));
    $this->db->where('client_password', $this->input->post('pass'));

    if($this->db->count_all_results('client_info') == 1){
      return TRUE;
    }

    return FALSE;
  }

  public function fetchlist(){

   return $this->db->get('client_transaction')->result();
  }

  public function getclients(){

    $this->db->where('queue_name', $this->getqueuename());

    $result = $this->db->get('client_info');

    return $result;
  }

  public function edit($type, $content){

    if($type=="name"){

      $qname = $this->getqueuename();

      $this->db->where('queue_name', $qname);
      $this->db->set('queue_name', $content);
      $this->db->update('client_transaction');

      $this->db->reset_query();

      $this->db->where('queue_name', $qname);
      $this->db->set('queue_name', $content);
      $this->db->update('client_info');
    }

    $result = array(
      'success' => TRUE,
      'error' => "Wrong Input"
    );

    return $result;
  }

	public function existingclient(){

    $this->db->where('client_userName', $this->input->post('user'));
    $this->db->where('client_password', $this->input->post('pass'));

    if($this->db->count_all_results('client_info') == 1){
      return TRUE;
    }

    return FALSE;

	}

  public function existingQueue(){

    $this->db->where('queue_name', $this->input->post('input')['name']);
    $this->db->where('queue_name', $this->input->post('input')['code']);

    if($this->db->count_all_results('client_transaction') == 1){

      return TRUE;

    }

    return FALSE;
	}

	public function signup()
	{
		$this->load->helper('url');

    if($this->existingclient()){
      return FALSE;
    }

    $this->db->where('code', $this->input->post('permcode'));

    if($this->db->count_all_results('permission_code') == 0){
      return FALSE;
    }

    $this->db->reset_query();

		$data = array(
			'client_userName' => $this->input->post('user'),
			'client_password' => $this->input->post('pass'),
		);

		$this->db->insert('client_info', $data);

    return TRUE;
	}

  public function create(){

    $this->load->helper('url');

    if($this->existingqueue()){
      return FALSE;
    }

    $data = array(
      'queue_name' => $this->input->post('input')['name'],
      'queue_code' => $this->input->post('input')['code'],
      'seats_offered' => $this->input->post('input')['seat'],
      'requirements' => $this->input->post('input')['req'],
      'venue' => $this->input->post('input')['venue'],
      'queue_description' => $this->input->post('input')['desc'],
      'queue_restriction' => $this->input->post('input')['rest'],
      'serving_atNo' => 0,
      'total_deployNo' => 0,
      'life' => 1,
      'click' => 0
    );

    $this->db->insert('client_transaction', $data);

    return TRUE;
  }

  public function join(){

    $this->load->helper('url');

    if($this->hasqueue()){
      return FALSE;
    }

    $this->db->set('queue_name', $this->input->post('selected'));
    $this->db->where('client_userName', $this->session->userdata['username']);
    $this->db->update('client_info');

    return TRUE;
  }

  public function close(){

    $this->db->set('serving_atNo', 0);
    $this->db->set('total_deployNo', 0);
    $this->db->set('life', 3);
    $this->db->set('click', 0);

    $this->db->where('queue_name', $this->getqueuename());

    $this->db->update('client_transaction');

	}

  public function leave(){

    $this->load->helper('url');

    if(!$this->hasqueue()){
      return FALSE;
    }

    $this->db->where('client_userName', $this->session->userdata('username'));
    $this->db->set('queue_name', 'none');
    $this->db->update('client_info');

    return TRUE;
  }

	public function incrementcurrent(){

    $this->db->where('queue_name', $this->getqueuename());
    $this->db->set('click', 'click+1', FALSE);
    $this->db->update('client_transaction');

    $this->db->reset_query();

    $this->db->set('current', $this->getcurrentservicenum());
    $this->db->where('client_userName', $this->session->userdata('username'));
    $this->db->update('client_info');

    return $this->getcurrentservicenum();
	}


	public function incrementid(){

   $this->db->where('queue_name', $this->getqueuename());
   $this->db->where('queue_number', $this->getcurrentservicenum());

   $var = $this->db->get('queuer')->row();

   if($var){
     return $var->id_number;;
   }else{
     return "none";
   }
	}

  public function hasqueue(){

    $this->db->where('client_userName', $this->session->userdata('username'));
    $this->db->where('queue_name', 'none');//is code NULL

    if($this->db->count_all_results('client_info') == 0){
      return TRUE;
    }

    return FALSE;
  }

  public function fetchdetail(){

    $this->db->where('queue_name', $this->getqueuename());

    return $this->db->get('client_transaction')->row();
  }

  public function getqueuename(){

    $this->db->where('client_userName', $this->session->userdata('username'));

    return $this->db->get('client_info')->row()->queue_name;
  }

  public function getcurrentservicenum(){

    $this->db->where('queue_name', $this->getqueuename());

    $serving = $this->db->get('client_transaction')->row()->serving_atNo;

    $this->db->where('queue_name', $this->getqueuename());

    $click = $this->db->get('client_transaction')->row()->click;

    return $serving + $click;
  }

  public function getcurrentid(){

    $this->db->where('queue_name', $this->getqueuename());
    $this->db->where('queue_number', $this->getcurrentservicenum());

    $var = $this->db->get('queuer')->row();

    if($var){
      return $var->id_number;;
    }else{
      return "none";
    }
  }

  public function getdeployno(){

    $this->db->where('queue_name', $this->getqueuename());

    $var = $this->db->get('client_transaction')->row();

    if($var->total_deployNo){
      return $var->total_deployNo;
    }else{
      return "none";
    }
	}

  public function getstatus(){

    $this->db->where('queue_name', $this->getqueuename());

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

  public function setstatus($var){

    $this->db->set('life', $var);

    $this->db->where('queue_name', $this->getqueuename());
    $this->db->update('client_transaction');
	}


  public function editq($type, $content){

    $this->db->where('queue_name', $this->getqueuename());

    if($type=="seat"){

      $this->db->set('seats_offered', $content);

    }else if($type=="desc"){

      $this->db->set('queue_description', $content);

    }else if($type=="req"){

      $this->db->set('requirements', $content);

    }else if($type=="venue"){

      $this->db->set('venue', $content);

    }else if($type=="rest"){

      $this->db->set('queue_restriction', $content);
    }

    $this->db->update('client_transaction');

    $result = array(
      'success' => TRUE,
      'error' => "Wrong Input"
    );

    return $result;
  }

  public function editdisplay($content){

    $this->db->where('client_userName', $this->session->userdata['username']);
    $this->db->set('display_name', $content);
    $this->db->update('client_info');

    $result = array(
      'success' => TRUE,
      'error' => "Wrong Input"
    );

    return $result;
  }

}
