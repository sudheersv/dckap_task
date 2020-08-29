<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $data = array();

    // protected $layout = "index";

    public function __construct() {
        parent::__construct();
        //$this->data['segments'] = $this->uri->segment_array();

        $this->data['default_img'] = 'assets/img/logo/logo.PNG'; 
    }

    public function __output() {
        //print_r($this->data); 
        $data['yield'] = '';
        if (isset($this->data['page'])) {
            $this->data['yield'] = $this->load->view($this->data['page'], $this->data, true);
        }

        if (isset($this->data['layout'])) {
            $template = $this->load->view($this->data['layout'], $this->data, true);
        } else {
            $template = $this->load->view('index', $this->data, true);
        }

        echo $template;
        exit;
    }

}
