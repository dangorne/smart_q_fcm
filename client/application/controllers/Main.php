<?php

  class Main extends CI_Controller{

    public function __construct(){

      parent::__construct();

      $this->load->library('session');
      $this->load->model('main_model');
      $this->load->helper('url_helper');
      // $this->load->helper('form');
      // $this->load->library('form_validation');

    }

    public function index(){

      if($this->session->userdata('username') != '' ){
        // if($this->main_model->hasQueue()){
          redirect('dashboard');
        // }else{
          // redirect('dashboard');
          // redirect('createq');
        // }
        // $this->load->view('templates/header_logout');
        // $this->load->view('home');
        // $this->load->view('templates/footer');
      }else{
        // $this->load->view('templates/header_login_signup');
        // $this->load->view('home');
        // $this->load->view('templates/footer');
        redirect('login');
      }

    }

    public function window(){

      $this->load->view('window');
      $this->load->view('windowjs');

    }

    public function logout(){

      // if($this->session->userdata('username') != '' && $this->main_model->isLoggedIn()){
      if($this->session->userdata('username') != ''){

        //logout user by setting fieldname to false
        // $this->main_model->isLoggedIn();

        // $this->main_model->logoutUser();
        // //unset user and type
        unset($_SESSION['username']);
      }

      //go back to home page with no session
      redirect(base_url(). '');

    }

    public function login(){

      $this->load->helper('form');
      $this->load->library('form_validation');
      // echo "<pre>";
      // print_r ($this->session->all_userdata());
      // echo "</pre>";
      if($this->session->userdata('username') == '' ){
        $this->load->view('templates/header_login_signup');
        $this->load->view('login');
        $this->load->view('templates/footer');
      // }else if($this->session->userdata('username') != '' && $this->main_model->hasQueue()){
      //   redirect('dashboard');
      // }else if($this->session->userdata('username') != '' && !$this->main_model->hasQueue()){
      //   redirect('createq');
      }

    }

    public function signup(){

      $this->load->helper('form');
      $this->load->library('form_validation');

      if($this->session->userdata('username') == '' ){
        $this->load->view('templates/header_login_signup');
        $this->load->view('signup');
        $this->load->view('templates/footer');
      }

    }

    public function dashboard(){

      $this->load->helper('form');
      $this->load->library('form_validation');

      // if($this->session->userdata('username') == '' ){
      //   redirect('login');
      // }else if($this->session->userdata('username') != '' && $this->main_model->hasQueue()){
      //
      //   $data['qnum'] = $this->main_model->getCurrentServiceNum();
      //   $data['idnum'] = $this->main_model->getCurrentID();
      //   $data['status'] = $this->main_model->getStatus();
      //   $data['dbupdate'] = $this->main_model->getUpdate();

      $this->load->view('templates/header_logout');
      $this->load->view('modal');
      $this->load->view('client');
      $this->load->view('dashboard');
      $this->load->view('templates/footer');
      // }else if($this->session->userdata('username') != '' && !$this->main_model->hasQueue()){
      //   redirect('createq');
      // }
    }

    public function login_validated(){

      $this->load->helper('form');
      $this->load->library('form_validation');

		  if ($this->form_validation->run('syntax')){

        if ($this->main_model->existingusername()){

          unset($_SESSION['user_error']);
          if($this->main_model->correctpassword()){

              $userdata = array(
               'username' => $this->input->post('user')
              );
              $this->session->set_userdata($userdata);

                redirect('dashboard');

          }else{

            $this->session->set_flashdata('pass_error', 'error');
            $this->login();
          }
       }else{

          $this->session->set_flashdata('user_error', 'error');
          $this->login();
       }
  	 }else{

        if ($this->main_model->existingusername()){

          if(!$this->main_model->correctpassword()){

            $this->session->set_flashdata('pass_error', 'error');
          }
        }else{

          $this->session->set_flashdata('user_error', 'error');
        }

        $this->session->set_flashdata('syntax_error', 'error');
        $this->login();
  	 }
   }

    public function signup_validated(){

      $this->load->helper('form');
			$this->load->library('form_validation');

			$this->form_validation->set_rules('user', 'User', 'required');
			// $this->form_validation->set_rules('pass', 'Pass', 'required');
      // $this->form_validation->set_rules('office', 'Office', 'required');
      // $this->form_validation->set_rules('permcode', 'Permission Code', 'required');

      //check if user is unregistered
      //login the user if success
			if ($this->form_validation->run()){

        //check if  does not exists
        if(!$this->main_model->existingclient()){

          //register user
          if($this->main_model->signup()){
            //set user session with username
            //the actual login
            $userdata = array(
              'username' => $this->input->post('user')
            );
            $this->session->set_userdata($userdata);

            //after login redirect to homepage
    				redirect(base_url(). '');
          }else{

            $this->signup();
          }
        }else{

         //go back to same page and
         //alert user that username already exists
         //only username must be checked for existingClient
         //no need for password
         $this->signup();

  			}
			}else{

        //user or pass is invalid
        // redirect(base_url(). 'login');
        $this->signup();
      }
    }

  }

?>
