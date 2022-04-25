<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library(array('session','email'));
		$this->load->model('user_model');
		$this->load->model('admin_model');
	}
	
	public function index()
	{
		if(($this->session->userdata('user_name')!=""))
		{
			$this->dashboard();
		}
		else
		{
			$this->login();
		}
	}
	
	public function login($errmsg = '0')
	{
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['title'] = ucfirst("login - $sitename");
		$data['errmsg'] = $errmsg;
		$data['wpcopy'] = $copyrights;
		
		$this->load->view('backend/login');
	}
	
	public function ulogin()
	{
		
		$this->form_validation->set_rules('username','Username','trim|required|alpha_numeric');
		$this->form_validation->set_rules('password','Password','required|trim|min_length[4]|max_length[32]');
		
		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->login();
		}
		else
		{
			$result=$this->user_model->login($username,$password);
			if($result) redirect('welcome/loaddashboard');
			else
			$this->login('err1');
		}
		
	}
	
	public function logout()
	{
		$newdata = array(
		'user_id'   =>'',
		'user_name'  =>'',
		'user_email'     => '',
		'user_type'     => '',
		'logged_in' => FALSE,
		);
		$this->session->unset_userdata($newdata);
		$this->session->sess_destroy();
		redirect('/');
	}
	
	public function register($errmsg = '0')
	{
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['title'] = ucfirst("register - $sitename");
		$data['errmsg'] = $errmsg;
		$data['wpcopy'] = $copyrights;
		$data['projlist'] = $this->admin_model->getprojects();
		$data['msg'] = $errmsg;
		
		$this->load->view('user/regheader', $data);
		$this->load->view('user/register');
		$this->load->view('user/regfooter', $data);
	}
	
	public function registeruser()
	{
		$this->load->library('form_validation');
		$project = $this->input->post('project');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[rpassword]');
		$this->form_validation->set_rules('rpassword', 'Re Password', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.uemail]');
		$this->form_validation->set_rules('fullname', 'Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone No', 'trim|required|min_length[7]|max_length[10]|numeric');
		
		if($project == "other")
		{
		$this->form_validation->set_rules('projectname', 'Project Name', 'trim|required');
		$this->form_validation->set_rules('buildername', 'Builder Name', 'trim|required');
		}
		
		$this->form_validation->set_message('is_unique', 'The %s is already used. Please Try Different.');
		if($this->form_validation->run() == FALSE)
		{
			$this->register();
		}
		else
		{
			/*
			$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => SMTP_HOST,
			'smtp_port' => SMTP_PORT,
			'smtp_user' => SMTP_USER,
			'smtp_pass' => SMTP_PASS,
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
			);
			*/
			
			if($project == "other")
			{
			$this->user_model->register_user2();
			$username = $this->input->post('username');
			$project = $this->user_model->getlastpid();
			$project = $project['id'];
			$this->user_model->buy_project($username,$project);
			$msg = "Registration Successful! New Project Details is sent to admin for verification! Meanwhile Please Complete your payment!";
			$this->makepayment($msg,$username);
			}
			else
			{
			$this->user_model->register_user();	
			$username = $this->input->post('username');
			$project = $this->input->post('project');
			$this->user_model->buy_project($username,$project);
			$msg = "Registration Successful! Please Complete your payment!";
			$this->makepayment($msg,$username);
			}
			
		}
	}
	
	public function makepayment($msg,$username)
	{
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['title'] = ucfirst("Complete Registration Payment - $sitename");
		$data['wpcopy'] = $copyrights;
		$data['msg'] = $msg;
		$data['username'] = $username;
		
		$this->load->view('user/regheader', $data);
		$this->load->view('user/makepayment');
		$this->load->view('user/regfooter', $data);
	}
	
	public function makeppayment($msg = '0',$username,$project)
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$username = $this->session->userdata('username');
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['title'] = ucfirst("Complete Property Payment - $sitename");
		$data['name'] = $name;
		$data['email'] = $email;
		$data['menu'] = "dashboard";
		$data['wpcopy'] = $copyrights;
		$data['msg'] = $msg;
		$data['username'] = $username;
		$data['project'] = $project;
		
		$this->load->view('user/header', $data);
		$this->load->view('user/makeppayment');
		$this->load->view('user/footer', $data);
	}
	
	public function confirm_payment($username)
	{
		$this->user_model->c_payment($username);
		$this->user_model->active_user($username);
		$msg = 'Payment Successful. Please Login!';
		$this->login($msg);
	}
	
	public function confirm_payments($username,$project)
	{
		$this->user_model->c_payments($username,$project);
		$this->ntfyusers($username,$project);
		$this->dashboard();
	}
	
	public function ntfyusers($username,$project)
	{
		$notifyulist = $this->user_model->loadntfyusers($username,$project);
		$udtl = $this->user_model->getudetails($username);
		$pdtl = $this->user_model->getpdetails($project);
		foreach($notifyulist as $row)
		{
			$msg = "New User ".$udtl['uname']." Joined Group: ".$pdtl['projectname'];
			$this->user_model->sendnotify('user',$row['username'],$msg);
		}
		$this->user_model->sendnotify('admin','admin',$msg);
	}
	
	public function dashboard()
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$username = $this->session->userdata('username');
		// add in aech function for profile photo working
		$profphoto = $this->session->userdata('profphoto');
		$data['profphoto'] = $profphoto;
		// till here
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['title'] = ucfirst("user dashbaord - $sitename");
		$data['name'] = $name;
		$data['username'] = $username;
		$data['email'] = $email;
		$data['menu'] = "dashboard";
		$data['wpcopy'] = $copyrights;
		$data['projlist'] = $this->user_model->getmyprojects($username);
		$data['totalntfy'] = $this->user_model->totalnotify($username);
		$data['ntfy'] = $this->user_model->notify($username);
		
		$this->load->view('user/header', $data);
		$this->load->view('user/homepage', $data);
		$this->load->view('user/footer', $data);
	}
	
	public function addproject($msg = '0')
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$username = $this->session->userdata('username');
		$profphoto = $this->session->userdata('profphoto');
		$data['profphoto'] = $profphoto;
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['title'] = ucfirst("add project - $sitename");
		$data['name'] = $name;
		$data['email'] = $email;
		$data['menu'] = "projects";
		$data['wpcopy'] = $copyrights;
		$data['msg'] = $msg;
		$data['projlist'] = $this->admin_model->getprojects();
		$data['totalntfy'] = $this->user_model->totalnotify($username);
		$data['ntfy'] = $this->user_model->notify($username);
		
		$this->load->view('user/header', $data);
		$this->load->view('user/addproject', $data);
		$this->load->view('user/footer', $data);
	}
	
	public function newproject()
	{
		$username = $this->session->userdata('username');
		$project = $this->input->post('project');
		
		if($this->user_model->validateproj($username,$project) == FALSE)
		{
			$msg = "You have already added this property. Please try different property!";
			$this->addproject($msg);
		}
		else
		{
			$this->user_model->buy_project($username,$project);
			$msg = "Property Added Successfully! Please Complete your payment!";
			$this->makeppayment($msg,$username,$project);
		}
	}
	
	public function chat($ctype,$proj)
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$username = $this->session->userdata('username');
		$profphoto = $this->session->userdata('profphoto');
		$data['profphoto'] = $profphoto;
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['pdetails'] = $this->user_model->getpdetails($proj);
		$data['totalmembersinchat'] = $this->user_model->tmchat($proj);
		$data['memlist'] = $this->user_model->getprojmembers($proj);
		$projd = $this->user_model->getpdetails($proj);
		$data['totalntfy'] = $this->user_model->totalnotify($username);
		$data['ntfy'] = $this->user_model->notify($username);
		$data['title'] = ucfirst($projd['projectname']." Chatroom - $sitename");
		$data['name'] = $name;
		$data['username'] = $username;
		$data['email'] = $email;
		$data['menu'] = "dashboard";
		$data['wpcopy'] = $copyrights;
		
		
		$this->load->view('user/header', $data);
		$this->load->view('user/chatroom', $data);
		$this->load->view('user/footer', $data);
	}
	
	public function uchat($ctype,$user)
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$username = $this->session->userdata('username');
		$profphoto = $this->session->userdata('profphoto');
		$data['profphoto'] = $profphoto;
		$data['mydetails'] = $this->user_model->getudetails($username);
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['udetails'] = $this->user_model->getudetails($user);
		$userd = $this->user_model->getudetails($user);
		$data['totalmprojects'] = $this->user_model->countmprojects($username,$user);
		$data['mplist'] = $this->user_model->getmprojects($username,$user);
		$data['totalntfy'] = $this->user_model->totalnotify($username);
		$data['ntfy'] = $this->user_model->notify($username);
		$data['title'] = ucfirst($userd['uname']." Chatroom - $sitename");
		$data['name'] = $name;
		$data['username'] = $username;
		$data['email'] = $email;
		$data['menu'] = "dashboard";
		$data['wpcopy'] = $copyrights;
		
		
		$this->load->view('user/header', $data);
		$this->load->view('user/uchatroom', $data);
		$this->load->view('user/footer', $data);
	}
	
	public function chatsubmit($utype,$fromuser,$touser)
	{
		$msg = $this->input->post('cmsg');
		$this->user_model->uchatsubmit($utype,$fromuser,$touser,$msg,'text');
		//$this->dashboard();
	}
	
	public function getchat($utype,$fromuser,$touser,$ltid)
	{
		$getclist = $this->user_model->getuchat($utype,$fromuser,$touser,$ltid);
		$jsonData = '{"results":[';
		$line = new stdClass;
		$arr = array();
		foreach($getclist AS $crow)
		{
			$fromudtl = $this->user_model->getudetails($fromuser);
			$toudtl = $this->user_model->getudetails($touser);
			$line->id = $crow['id'];
			$line->usertype = $crow['usertype'];
			$line->mcontent = $crow['mcontent'];
			$line->fromuser = $crow['fromuser'];
			$line->touser = $crow['touser'];
			$line->fromuname = $fromudtl['uname'];
			$line->touname = $toudtl['uname'];
			$line->datentime = $crow['datentime'];
			$line->msgtype = $crow['msgtype'];
			$arr[] = json_encode($line);
		}
		$jsonData .= implode(",", $arr);
		$jsonData .= ']}';
		echo $jsonData;
	}
	
	
	public function getgchat($utype,$fromuser,$togroup,$ltid)
	{
		$getclist = $this->user_model->getgchat($utype,$fromuser,$togroup,$ltid);
		$jsonData = '{"results":[';
		$line = new stdClass;
		$arr = array();
		foreach($getclist AS $crow)
		{
			$fromudtl = $this->user_model->getudetails($crow['fromuser']);
			$line->id = $crow['id'];
			$line->usertype = $crow['usertype'];
			$line->mcontent = $crow['mcontent'];
			$line->fromuser = $crow['fromuser'];
			$line->touser = $crow['touser'];
			$line->fromuname = $fromudtl['uname'];
			$line->datentime = $crow['datentime'];
			$line->msgtype = $crow['msgtype'];
			$arr[] = json_encode($line);
		}
		$jsonData .= implode(",", $arr);
		$jsonData .= ']}';
		echo $jsonData;
	}
	
	public function upload()
	{
		$this->load->library('upload');
		$attachment_file=$_FILES["upload"];
		$fromuser = $this->input->post('fromuser');
		$touser = $this->input->post('touser');
		$usertype = $this->input->post('usertype');
		$msgtype = $this->input->post('msgtype');
		
        $output_dir = "uploads/";
        $fileName = $_FILES["upload"]["name"];
		move_uploaded_file($_FILES["upload"]["tmp_name"],$output_dir.$fileName);
		$this->user_model->uchatsubmit($usertype,$fromuser,$touser,$fileName,$msgtype);
		echo "File uploaded successfully";
	}
	
	public function docs($ctype,$proj)
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$username = $this->session->userdata('username');
		$profphoto = $this->session->userdata('profphoto');
		$data['profphoto'] = $profphoto;
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['gdocs'] = $this->user_model->getgdocs($ctype,$proj);
		$projd = $this->user_model->getpdetails($proj);
		$data['totalntfy'] = $this->user_model->totalnotify($username);
		$data['ntfy'] = $this->user_model->notify($username);
		$data['title'] = ucfirst($projd['projectname']." Documents - $sitename");
		$data['name'] = $name;
		$data['username'] = $username;
		$data['email'] = $email;
		$data['menu'] = "dashboard";
		$data['wpcopy'] = $copyrights;
		
		
		$this->load->view('user/header', $data);
		$this->load->view('user/gdocs', $data);
		$this->load->view('user/footer', $data);
	}
	
	public function udocs($fromuser,$touser)
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$username = $this->session->userdata('username');
		$profphoto = $this->session->userdata('profphoto');
		$data['profphoto'] = $profphoto;
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['udocs'] = $this->user_model->getudocs($fromuser,$touser);
		$data['totalntfy'] = $this->user_model->totalnotify($username);
		$data['ntfy'] = $this->user_model->notify($username);
		$data['title'] = ucfirst("Documents - $sitename");
		$data['name'] = $name;
		$data['username'] = $username;
		$data['email'] = $email;
		$data['menu'] = "dashboard";
		$data['wpcopy'] = $copyrights;
		
		
		$this->load->view('user/header', $data);
		$this->load->view('user/udocs', $data);
		$this->load->view('user/footer', $data);
	}
	
	public function getuserdetails($usert)
	{
		$udtl = $this->user_model->getudetails($usert);
		return $udtl;
	} 
	
	public function changepassword($msg = '0')
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$profphoto = $this->session->userdata('profphoto');
		$data['profphoto'] = $profphoto;
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['title'] = ucfirst("Change Password - $sitename");
		$data['name'] = $name;
		$data['email'] = $email;
		$data['menu'] = "dashboard";
		$data['wpcopy'] = $copyrights;
		$data['msg'] = $msg;
		
		
		$this->load->view('user/header', $data);
		$this->load->view('user/cpassword', $data);
		$this->load->view('user/footer', $data);
	}
	
	public function cpassword()
	{
		$this->load->library('form_validation');
		$username = $this->session->userdata('username');
		
		$this->form_validation->set_rules('oldpass', 'Old Password', 'trim|required|min_length[5]|callback_validate_pass');
		$this->form_validation->set_rules('newpass', 'New Password', 'trim|required|min_length[5]|matches[rnewpass]');
		$this->form_validation->set_rules('rnewpass', 'Repeat New Password', 'trim|required|min_length[5]');
		$this->form_validation->set_message('validate_pass','Entered Old Password is not valid. Please Try Again!');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->changepassword();
		}
		else
		{
			$this->admin_model->changepass($username);
			$msg = "Password Successfully Changed!";
			$this->changepassword($msg);
		}
	}
	
	function validate_pass($str)
	{
		$field_value = $str;
		$username = $this->session->userdata('username');
		if($this->admin_model->validate_pass($field_value,$username))
		{
		return TRUE;
		}
		else
		{
		return FALSE;
		}	
	}
	
	public function profilest($msg = '0')
	{
		$name = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$username = $this->session->userdata('username');
		$profphoto = $this->session->userdata('profphoto');
		$data['profphoto'] = $profphoto;
		$sitename = WEBAPP_NAME;
		$copyrights = WEBAPP_COPYRIGHTS;
		$data['udtl'] = $this->user_model->getudetails($username);
		$data['totalntfy'] = $this->user_model->totalnotify($username);
		$data['ntfy'] = $this->user_model->notify($username);
		$data['title'] = ucfirst("Change Profile - $sitename");
		$data['name'] = $name;
		$data['email'] = $email;
		$data['username'] = $username;
		$data['menu'] = "dashboard";
		$data['wpcopy'] = $copyrights;
		$data['msg'] = $msg;
		
		
		$this->load->view('user/header', $data);
		$this->load->view('user/cprofile', $data);
		$this->load->view('user/footer', $data);
	}
	
	public function updateprof()
	{
		$this->load->library('form_validation');
		$username = $this->session->userdata('username');
		
		$this->form_validation->set_rules('uemail', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('uname', 'Name', 'trim|required');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->profilest();
		}
		else
		{
			$this->user_model->profilest($username);
			$msg = "Profile Successfully Updated!";
			$this->profilest($msg);
		}
	}
}
