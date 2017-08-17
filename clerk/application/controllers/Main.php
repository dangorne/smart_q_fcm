<?php

  class Main extends CI_Controller{

    public function __construct(){

      parent::__construct();

      $this->load->library('session');
      $this->load->model('main_model');
      $this->load->helper('url_helper');
    }

    public function index(){

      if($this->session->userdata('username') != '' ){

        redirect('dashboard');
      }else{
        redirect('login');
      }
    }

    public function dashboard(){

      $this->load->helper('form');
      $this->load->library('form_validation');

      // if($this->session->userdata('username') != '' ){
        $this->load->view('templates/header_logout');
        $this->load->view('dashboard');
        $this->load->view('clerk');
        $this->load->view('templates/footer');
      // }
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

      if($this->session->userdata('username') == '' ){
        $this->load->view('templates/header_login_signup');
        $this->load->view('login');
        $this->load->view('templates/footer');
      }else if($this->session->userdata('username') != '' && $this->main_model->hasQueue()){
        redirect('controlq');
      }else if($this->session->userdata('username') != '' && !$this->main_model->hasQueue()){
        redirect('createq');
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

    public function login_validated(){

      $this->load->helper('form');
      $this->load->library('form_validation');

      if ($this->form_validation->run('syntax_login')){

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

      if ($this->form_validation->run('syntax_signup')){

        $this->session->unset_userdata('SYNTAX_ERROR');

        if($this->input->post('pass') != $this->input->post('confirmpass')){

          $this->session->set_flashdata('PASS_NOT_MATCH', 'TRUE');
          $this->signup();
          return;
        }

        if(!$this->main_model->existingcode("clerk", $this->input->post('code'))){

          $this->session->set_flashdata('CODE_NOT_EXIST', 'TRUE');
          $this->signup();
          return;
        }

        $this->session->unset_userdata('PASS_NOT_MATCH');

        if(!$this->main_model->existingusername()){

          $this->session->unset_userdata('USER_EXIST');

          if($this->main_model->signup()){

            $userdata = array(
              'username' => $this->input->post('user')
            );
            $this->session->set_userdata($userdata);

            redirect(base_url(). '');
          }else{

            $this->signup();
          }
        }else{

         $this->session->set_flashdata('USER_EXIST', 'TRUE');
         $this->signup();
         return;

        }
      }else{

        $this->session->set_flashdata('SYNTAX_ERROR', 'TRUE');
        $this->signup();
      }
    }
  }

?>
