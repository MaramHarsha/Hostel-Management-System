<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {
    public $burl;
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('session','email'));
        $this->load->model('admin_model');
        $this->burl = $this->baseUrl();
    }
    
    function gmsOptions()
    {
        $optionsres = $this->admin_model->loadOptions();
        foreach ($optionsres as $row)
        {
                $gmsopt[$row['opt_key']] = $row['opt_value'];
        }
        return $gmsopt;
    }

    function timeZones()
    {
        $optionsres = $this->admin_model->loadOptions();
    }
    
    protected function baseUrl()
    {
        $options = $this->gmsOptions();
        if(isset($options['url_rewrite']) && $options['url_rewrite'] == true)
        {
            return base_url();
        }
        else
        {
            return base_url().'index.php/';
        }
    }
}