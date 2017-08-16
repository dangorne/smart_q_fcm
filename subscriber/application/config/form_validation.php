<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
  'syntax' => array(
          array(
            'field' => 'user',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[10]',
          ),
          array(
            'field' => 'pass',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[8]|alpha_numeric',
          ),
  ),
);
