<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) . "/BaseController.php");
class Site extends BaseController 
{
	public function index()
	{
		$data['options'] = $this->gmsOptions();

		$this->load->library('parser');

		$data = array(
			'blog_title' => 'My Blog Title',
			'blog_heading' => 'My Blog Heading'
		);
	
		$this->parser->parse('blog_template', $data);

		//$this->load->view('frontend/default/head',$data);
		//$this->load->view('frontend/default/index',$data);
		//$this->load->view('frontend/default/foot',$data);
	}
}
