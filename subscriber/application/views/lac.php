
    // public function login_validated(){
    //
    //   $this->load->helper('form');
    //   $this->load->library('form_validation');
    //   // $this->load->library('form_validation', NULL, 'syntax_validator');
    //   // $syntax = array(
    //   //         array(
    //   //           'field' => 'user',
    //   //           'label' => 'Username',
    //   //           'rules' => 'trim|required|min_length[5]|max_length[12]|alpha_numeric',
    //   //         ),
    //   //         array(
    //   //           'field' => 'pass',
    //   //           'label' => 'Password',
    //   //           'rules' => 'trim|required|min_length[5]|max_length[12]|alpha_numeric',
    //   //         ),
    //   // );
    //   //
    //   // $this->load->library('form_validation', NULL, 'syntax_validator');
    //
    //   // $exist = array(
    //   //         array(
    //   //           'field' => 'user',
    //   //           'label' => 'Username',
    //   //           'rules' => array(
    //   //                       array('existingusername',  array($this->main_model, 'existingUsername'))
    //   //                     ),
    //   //           'errors' => array(
    //   //                         'existingusername' => 'Username does not exist.'
    //   //                       ),
    //   //         ),
    //   //         array(
    //   //           'field' => 'pass',
    //   //           'label' => 'Password',
    //   //           'rules' => array(
    //   //                        array('correctpassword',  array($this->main_model, 'correctPassword'))
    //   //                      ),
    //   //           'errors' => array(
    //   //                         'correctpassword' => 'Incorrect password.'
    //   //                       ),
    //   //         ),
    //   // );
    //   // $this->load->library('form_validation', NULL, 'existence_validator');
    //
    //   // $this->load->library('form_validation');
    //
		//   // $this->form_validation->set_rules('user', 'Username',
    //   //           array(
    //   //             array('existingusername',  array($this->main_model, 'existingUsername'))
    //   //           ),
    //   //             array('existingusername' => 'Username does not exist.')
    //   // );
    //   //
    //   // $this->form_validation->set_rules('pass', 'Password',
    //   //           array(
    //   //             array('correctpassword',  array($this->main_model, 'correctPassword'))
    //   //           ),
    //   //             array('correctpassword' => 'Incorrect password.')
    //   // );
    //   // $this->syntax_validator->set_rules($syntax);
		//   if ($this->form_validation->run()){
    //
    //     // $rules = $this->form_validation->_config_rules;
    //
    //     // $this->login_validated_existing();
    //     // Create new validation object
    //     // $this->form_validation = new CI_Form_validation();
    //     // $this->syntax_validator->set_rules($exist);
    //     // if ($this->existence_validator->run()){
    //     //
    //     //   //  if($this->main_model->existingClient() && $this->main_model->isLoggedIn() == FALSE){
    //     //   //  $this->main_model->logInUser();
    //     //   $userdata = array(
    //     //    'username' => $this->input->post('user')
    //     //   );
    //     //   $this->session->set_userdata($userdata);
    //     //
    //     //     redirect(base_url(). '');
    //     //   }else{
    //     //     $this->session->set_flashdata('error', 'error');
    //     //     $this->login();
    //     // }
  	// 	}else{
    //
    //     $this->session->set_flashdata('error', 'error');
    //     $this->login();
  	// 	}
    // }



        // public function login_validated_existing(){
        //
        //   $this->load->helper('form');
        //   $this->load->library('form_validation');
        //
        //   $exist = array(
        //           array(
        //             'field' => 'user',
        //             'label' => 'Username',
        //             'rules' => array(
        //                         array('existingusername',  array($this->main_model, 'existingUsername'))
        //                       ),
        //             'errors' => array(
        //                           'existingusername' => 'Username does not exist.'
        //                         ),
        //           ),
        //           array(
        //             'field' => 'pass',
        //             'label' => 'Password',
        //             'rules' => array(
        //                          array('correctpassword',  array($this->main_model, 'correctPassword'))
        //                        ),
        //             'errors' => array(
        //                           'correctpassword' => 'Incorrect password.'
        //                         ),
        //           ),
        //   );
        //
        //   $this->form_validation->set_rules($exist);
        //   if ($this->form_validation->run()){
        //
        //     //  if($this->main_model->existingClient() && $this->main_model->isLoggedIn() == FALSE){
        //     //  $this->main_model->logInUser();
        //     $userdata = array(
        //      'username' => $this->input->post('user')
        //     );
        //     $this->session->set_userdata($userdata);
        //
        //       redirect(base_url(). '');
        //     }else{
        //       $this->session->set_flashdata('error', 'error');
        //       $this->login();
        //   }
        // }

        // public function login_validated_existing(){
        //
        //   $this->load->helper('form');
        //   $this->load->library('form_validation');
        //
        //   if ($this->form_validation->run()){
        //
        //     $userdata = array(
        //      'username' => $this->input->post('user')
        //     );
        //     $this->session->set_userdata($userdata);
        //
        //       redirect(base_url(). '');
        //     }else{
        //       $this->session->set_flashdata('error', 'error');
        //       $this->login();
        //   }
        // }
