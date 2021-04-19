<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_404 extends CI_Controller {

	/**
	 * Copyright
	 * Hilanproject.com
	 * November 2016
	 */

	public function index() 
    { 
        $this->output->set_status_header('404');         
        $this->load->view('home/404');
    } 
}
