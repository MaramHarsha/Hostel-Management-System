<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) . "/BaseController.php");
class Website extends BaseController {
    function __construct() {
		parent::__construct();

		$data['burl'] = $this->burl;
		$data['options'] = $this->gmsOptions();
		$this->load->vars($data);
    }
    
    function index()
    {
      $this->load->library('parser');

      $data = array(
        'blog_title' => 'My Blog Title',
        'blog_heading' => 'My Blog Heading'
      );
      $data['options'] = $this->gmsOptions();
      $data['title'] = ucfirst($data['options']['dhp_name']." | Calgary HMS");
      $data['gallery'] = $this->admin_model->loadGallery();
      $data['webpages'] = $this->admin_model->getWebPages();
      $data['webpage'] = $this->admin_model->getWebPage('home-page');
      
      $this->parser->parse('templates/'.$data['options']['web_template'].'/header', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/index', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/footer', $data);
    }

    function gallery()
    {
      $this->load->library('parser');
      $data['options'] = $this->gmsOptions();
      $data['title'] = ucfirst($data['options']['dhp_name']." | Calgary HMS");
      $data['gallery'] = $this->admin_model->loadGallery();
      $data['webpages'] = $this->admin_model->getWebPages();
      $data['webpage'] = $this->admin_model->getWebPage('home-page');
      
      $this->parser->parse('templates/'.$data['options']['web_template'].'/header', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/gallery', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/footer', $data);
    }

    function page($slug)
    {
      $this->load->library('parser');
      $data['options'] = $this->gmsOptions();
      $data['webpage'] = $this->admin_model->getWebPage($slug);
      $data['title'] = ucfirst($data['webpage']['web_page_name']." | ".$data['options']['dhp_name']." | Calgary HMS");
      $data['webpages'] = $this->admin_model->getWebPages();
      
      
      $this->parser->parse('templates/'.$data['options']['web_template'].'/header', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/page', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/footer', $data);
    }

    function contact()
    {
      $this->load->library('parser');
      $data['options'] = $this->gmsOptions();
      $data['title'] = ucfirst("Contact Us | ".$data['options']['dhp_name']." | Calgary HMS");
      $data['webpages'] = $this->admin_model->getWebPages();
      
      
      $this->parser->parse('templates/'.$data['options']['web_template'].'/header', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/contactus', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/footer', $data);
    }

    function blog()
    {
      $this->load->library('parser');
      $data['options'] = $this->gmsOptions();
      $data['title'] = ucfirst("Blog | ".$data['options']['dhp_name']." | Calgary HMS");
      $data['webpages'] = $this->admin_model->getWebPages();
      $data['blog'] = $this->admin_model->getBlogPosts();
      
      $this->parser->parse('templates/'.$data['options']['web_template'].'/header', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/blog', $data);
      $this->parser->parse('templates/'.$data['options']['web_template'].'/footer', $data);
    }

    function contactpost()
    {
      $data['options'] = $this->gmsOptions();

      if(empty($_POST['name'])      ||
        empty($_POST['email'])     ||
        empty($_POST['phone'])     ||
        empty($_POST['message'])   ||
        !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
        echo "No arguments Provided!";
        return false;
        }
        
      $name = strip_tags(htmlspecialchars($_POST['name']));
      $email_address = strip_tags(htmlspecialchars($_POST['email']));
      $phone = strip_tags(htmlspecialchars($_POST['phone']));
      $message = strip_tags(htmlspecialchars($_POST['message']));
        
      // Create the email and send the message
      $to = $data['options']['email'];
      $email_subject = "Website Contact Form:  $name";
      $email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
      $headers = "From: ".$data['options']['smtp_username']."\n"; 
      $headers .= "Reply-To: $email_address";   
      mail($to,$email_subject,$email_body,$headers);
      return true;
    }
}