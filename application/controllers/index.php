<?php

class Index extends CI_Controller{
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Shanghai');
	}

	public function index(){
		$this->load->view('index');
	}



}