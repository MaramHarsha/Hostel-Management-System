<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) . "/BaseController.php");
class Admin extends BaseController {
	protected $branchid;
	public $lan;
	
	function __construct() {
		parent::__construct();
		
		$data['burl'] = $this->burl;
		$data['options'] = $this->gmsOptions();
		$data['userdata'] = $this->session->userdata;
		$data['branches'] = $this->admin_model->getAllBranches();
		$data['languages'] = $this->admin_model->getAllLangs();
		$data['isadmin'] = (isset($data['userdata']['user_type']) && $data['userdata']['user_type'] == 'admin') ? true : false;
		$data['branch'] = (isset($data['userdata']['branch'])) ? $this->admin_model->getBranch($data['userdata']['branch']) : '';
		$data['branchid'] = (isset($data['userdata']['branch'])) ? $data['userdata']['branch'] : '';
		$this->branchid = $data['branchid'];
		$this->branchd = $data['branch'];
		$data['modulecounts'] = $this->admin_model->modulecounts($data['branchid']);
		$data['language'] = (isset($data['userdata']['lang'])) ? $data['userdata']['lang'] : $data['options']['lang'];
		$data['languageabbr'] = $this->admin_model->getLanguageAbbr($data['language']);
		$this->config->set_item('language', $data['language']); 
		$this->lang->load('dhpms_main',$data['language']);
		$gcconfig = $this->load->config('grocery_crud');
		$this->config->set_item('grocery_crud_default_language', $data['language']);
		$data['lang'] = $this->lang->language;
		$this->lan = $data['lang'];
		$this->load->vars($data);
	}

	function index()
	{
		if(($this->session->userdata('logged_in')))
		{
			$this->dashboard();
		}
		else
		{
			$this->login();
		}	
	}
	
	function test($data)
	{
		echo "<pre>";print_r($data);exit;
	}
	
	function chkLogin($onlyAdmin = true)
	{
		if(!($this->session->userdata('logged_in')))
		{
			 redirect($this->burl.'admin/login/');
		}
		else
		{
			$usertype = $this->session->userdata('user_type');
			if($onlyAdmin && $usertype != 'admin' && $usertype != 'branch admin')
			{
				die($this->lan['not_authorised_msg']);
			}
		}
	}
	
	function login($errmsg = '0')
	{
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['signin']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['errmsg'] = $errmsg;
		
		$this->load->view('backend/login',$data);
	}

	function register($errmsg = '0')
	{
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['register']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['errmsg'] = $errmsg;
		$data['branches'] = $this->admin_model->getAllBranches();
		
		$this->load->view('backend/register',$data);
	}
	
	function ulogin()
	{
		
		$this->form_validation->set_rules('user_email',$this->lan['email'],'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('user_password',$this->lan['password'],'required|trim|max_length[32]|xss_clean');
		
		$email=html_escape($this->input->post('user_email'));
		$password=md5(html_escape($this->input->post('user_password')));
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->login();
		}
		else
		{
			$result=$this->admin_model->login($email,$password);
			if($result){
				$user = $this->session->userdata;
				if($user['user_type'] == 'branch admin')
				{
					$branch=$this->admin_model->getUserBranch($email);
					$this->selectbranch($branch);
				}
				else
				redirect('admin/dashboard');
			}
			else
			$this->login('err1');
		}
		
	}

	function signup()
	{
		$this->form_validation->set_rules('ten_branch',$this->lan['branch'],'required|trim|max_length[32]|xss_clean');
		$this->form_validation->set_rules('user_name',$this->lan['name'],'required|trim|max_length[32]|xss_clean');
		$this->form_validation->set_rules('user_email',$this->lan['email'],'trim|required|valid_email|xss_clean|is_unique[tbl_tenants.ten_email]');
		$this->form_validation->set_rules('user_password',$this->lan['password'],'required|trim|max_length[32]|xss_clean');
		
		$email=html_escape($this->input->post('user_email'));
		$password=md5(html_escape($this->input->post('user_password')));
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->register();
		}
		else
		{
			$options = $this->gmsOptions();
			$lastmem = $this->admin_model->getLastTenant('ten_uid');
			if(is_array($lastmem) && count($lastmem) <= 0)
			{
				$newtenuid = $options['tid_start'];
			}
			else 
			{
				$newtenuid = $lastmem['ten_uid']+1;
			}

			$result=$this->admin_model->register($newtenuid);
			if($result){
				$this->register('success1');
			}
		}
		
	}
	
	public function logout()
	{
		$newdata = array(
		'user_id'  => '',
		'user_name'  => '',
		'user_email'    => '',
		'user_type'    => '',
		'profphoto'    => '',
		'logged_in'  => FALSE
		);
		$this->session->unset_userdata($newdata);
		$this->session->sess_destroy();
		redirect('/admin/login/');
	}

	function selectbranch($branchid)
	{		
		$userdata = $this->session->userdata;
		$this->session->set_flashdata('dash_msg', $this->lan['branch_changed_success']);
		if(isset($userdata['branch']) && $userdata['branch']==$branchid) {
			$bdata = array(
				'branch'
			);
			$this->session->unset_userdata($bdata);
			echo $userdata['branch'];
			redirect('/admin/');
		}
		else
		{
			$bdata = array(
				'branch' => $branchid
			);
			$this->session->set_userdata($bdata);
			redirect('/admin/');
		}
	}

	function lang($selectedlang)
	{
		$userdata = $this->session->userdata;
		$this->session->set_flashdata('dash_msg', $this->lan['language_changed_success']);
		$bdata = array(
			'lang' => $selectedlang
		);
		$this->session->set_userdata($bdata);
		redirect('/admin/');
	}

	function changepassword()
	{
		$this->chkLogin(false);
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['changepassword']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'changepassword';
		$data['userdata'] = $this->session->userdata;
		
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/changepassword',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function updatepassword()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('c_pass',$this->lan['currentpassword'],'trim|required|xss_clean|callback_checkCurrentPassword');
		$this->form_validation->set_rules('n_pass',$this->lan['newpassword'],'trim|required|xss_clean');
		$this->form_validation->set_rules('cn_pass',$this->lan['confirmpassword'],'trim|required|xss_clean|matches[n_pass]');
		
		$userdata = $this->session->userdata;
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->changepassword();
		}
		else
		{
			$result=$this->admin_model->changepassword($userdata);
			$this->session->set_flashdata('dash_msg', $this->lan['password_changed_success']);
			redirect('admin/dashboard');
		}
	}

	function checkCurrentPassword()
	{
		$this->form_validation->set_message('checkCurrentPassword', $this->lan['incorrect_cur_password']);
		$udata = $this->session->userdata;

		if($udata['user_type'] != 'admin')
		{
			if ($this->admin_model->checkCurrentPassowrdOfTenant(html_escape($_POST['c_pass']),$udata)) {
					return true;
			}else{
					return false;
			}
		}
		else
		{
			if ($this->admin_model->checkCurrentPassowrdOfAdmin(html_escape($_POST['c_pass']),$udata)) {
					return true;
			}else{
					return false;
			}
		}
		
	}
	
	function dashboard()
	{
		$this->chkLogin(false);
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['dashboard']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'dashboard';
		$data['userdata'] = $this->session->userdata;
		$data['usercounts'] = $this->admin_model->getTenantStats($this->session->userdata['user_id']);
		$dash_msg = $this->session->flashdata('dash_msg');
		$data['notify_msg'] = isset($dash_msg) ? $dash_msg : '';
		$data['notify_type'] = 'success';
		
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/index',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function tenant_report($tenuid,$report)
	{
		$this->load->library('grocery_CRUD');

		switch ($report) {
			case "all_inv":
				$crud = new grocery_CRUD();
				$crud->where('inv_ten_uid',$tenuid);
				$crud->set_table('tbl_invoice');
				$crud->columns(['inv_id','inv_for','inv_status','inv_total','inv_created']);
				$crud->display_as('inv_id',$this->lan['invoiceid'])
				->display_as('inv_for',$this->lan['invcat'])
				->display_as('inv_status',$this->lan['invoice'].' '.$this->lan['status'])
				->display_as('inv_total',$this->lan['invoice'].' '.$this->lan['total'])
				->display_as('inv_created',$this->lan['invoice'].' '.$this->lan['created']);
				$crud->callback_column('inv_id',array($this,'_callback_invoice_id'));
				$crud->callback_column('inv_total',array($this,'_callback_invoice_total'));
				$crud->callback_column('inv_created',array($this,'_callback_invoice_created'));
				$crud->unset_add(); $crud->unset_edit(); $crud->unset_delete(); $crud->unset_clone(); $crud->unset_read();
				$output = $crud->render();
				$data['gc'] = $output;
				break;
			case "paid_inv":
				$crud2 = new grocery_CRUD();
				$crud2->where('inv_ten_uid',$tenuid);
				$crud2->where('inv_status','PAID');
				$crud2->set_table('tbl_invoice');
				$crud2->columns(['inv_id','inv_for','inv_status','inv_total','inv_created']);
				$crud2->display_as('inv_id',$this->lan['invoiceid'])
				->display_as('inv_for',$this->lan['invcat'])
				->display_as('inv_status',$this->lan['invoice'].' '.$this->lan['status'])
				->display_as('inv_total',$this->lan['invoice'].' '.$this->lan['total'])
				->display_as('inv_created',$this->lan['invoice'].' '.$this->lan['created']);
				$crud2->callback_column('inv_id',array($this,'_callback_invoice_id'));
				$crud2->callback_column('inv_total',array($this,'_callback_invoice_total'));
				$crud2->callback_column('inv_created',array($this,'_callback_invoice_created'));
				$crud2->unset_add(); $crud2->unset_edit(); $crud2->unset_delete(); $crud2->unset_clone(); $crud2->unset_read();
				$output = $crud2->render();
				$data['gc'] = $output;
				break;
			case "pen_inv":
				$crud3 = new grocery_CRUD();
				$crud3->where('inv_ten_uid',$tenuid);
				$crud3->where('inv_status !=','PAID');
				$crud3->set_table('tbl_invoice');
				$crud3->columns(['inv_id','inv_for','inv_status','inv_total','inv_created']);
				$crud3->display_as('inv_id',$this->lan['invoiceid'])
				->display_as('inv_for',$this->lan['invcat'])
				->display_as('inv_status',$this->lan['invoice'].' '.$this->lan['status'])
				->display_as('inv_total',$this->lan['invoice'].' '.$this->lan['total'])
				->display_as('inv_created',$this->lan['invoice'].' '.$this->lan['created']);
				$crud3->callback_column('inv_id',array($this,'_callback_invoice_id'));
				$crud3->callback_column('inv_total',array($this,'_callback_invoice_total'));
				$crud3->callback_column('inv_created',array($this,'_callback_invoice_created'));
				$crud3->unset_add(); $crud3->unset_edit(); $crud3->unset_delete(); $crud3->unset_clone(); $crud3->unset_read();
				$output = $crud3->render();
				$data['gc'] = $output;
				break;
			case "all_pay":
				$crud4 = new grocery_CRUD();
				$crud4->set_model('custom_query_model');
				$crud4->set_table('tbl_invoice_payments');
				$crud4->columns(['inv_id','payment_id','payment_method','payment_trans_id','payment_amnt','payment_date','payment_status','payment_details']);
				$crud4->display_as('inv_id',$this->lan['invoiceid'])
				->display_as('payment_id',$this->lan['paymentid'])
				->display_as('payment_method',$this->lan['payment'].' '.$this->lan['method'])
				->display_as('payment_trans_id',$this->lan['transactionid'])
				->display_as('payment_amnt',$this->lan['amount'])
				->display_as('payment_date',$this->lan['payment'].' '.$this->lan['date'])
				->display_as('payment_status',$this->lan['payment'].' '.$this->lan['status'])
				->display_as('payment_details',$this->lan['payment'].' '.$this->lan['details']);
				$crud4->callback_column('inv_id',array($this,'_callback_invoice_id'));
				$crud4->callback_column('payment_amnt',array($this,'_callback_invoice_total'));
				$crud4->callback_column('payment_date',array($this,'_callback_payment_created'));
				$crud4->unset_add(); $crud4->unset_edit(); $crud4->unset_delete(); $crud4->unset_clone(); $crud4->unset_read();
				$crud4->basic_model->set_custom_query("SELECT * FROM tbl_invoice_payments a,tbl_invoice b WHERE a.inv_id = b.inv_id AND b.inv_ten_uid = '$tenuid'"); 
				$output = $crud4->render();
				$data['gc'] = $output;
				break;
			case "all_aes":
				$crud5 = new grocery_CRUD();
				$crud5->set_model('custom_query_model');
				$crud5->set_table('tbl_es_assign');
				$crud5->columns(['es_name','total_amnt','dt_from','dt_to','assigned_on']);
				$crud5->display_as('es_name',$this->lan['extraservice'].' '.$this->lan['name'])
				->display_as('total_amnt',$this->lan['total'].' '.$this->lan['amount'])
				->display_as('dt_from',$this->lan['date'].' '.$this->lan['from'])
				->display_as('dt_to',$this->lan['date'].' '.$this->lan['to'])
				->display_as('assigned_on',$this->lan['assignedon']);
				$crud5->callback_column('total_amnt',array($this,'_callback_invoice_total'));
				$crud5->callback_column('dt_from',array($this,'_callback_invoice_created'));
				$crud5->callback_column('dt_to',array($this,'_callback_invoice_created'));
				$crud5->callback_column('assigned_on',array($this,'_callback_payment_created'));
				$crud5->unset_add(); $crud5->unset_edit(); $crud5->unset_delete(); $crud5->unset_clone(); $crud5->unset_read();
				$crud5->add_action('Retrieve', '', 'admin/retrievees/');
				$crud5->basic_model->set_custom_query("SELECT a.*,b.es_name FROM tbl_es_assign a, tbl_extra_services b WHERE a.es_id = b.id AND a.ten_uid = '$tenuid' AND a.retrived_on = '0000-00-00 00:00:00'"); 
				$output = $crud5->render();
				$data['gc'] = $output;
				break;
		}
		$this->load->view('backend/ten_report',$data);
	}

	function tenant($tenuid,$view='admin')
	{
		$this->chkLogin(false);
		$this->load->library('grocery_CRUD');
		$data['options'] = $this->gmsOptions();
		$data['userdata'] = $this->session->userdata;
		$data['tenant'] = $this->admin_model->getTenantDetails($tenuid);
		$data['tenantstats'] = $this->admin_model->getTenantStats($tenuid);
		$data['tendata'] = $this->admin_model->getTenantDetails($tenuid);
		$data['title'] = ucfirst($this->lan['tenant'].' '.$this->lan['profile']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'tenants';
		$data['burl'] = $this->burl;
		$data['tenuid'] = $tenuid;
		$data['view'] = $view;
		$tenant_flash = $this->session->flashdata('tenant_flash');
		$data['notify_msg'] = isset($tenant_flash) ? $tenant_flash : '';
		$data['notify_type'] = 'success';

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/tenantprofile',$data);
		$this->load->view('backend/common/footer',$data);
	}

	public function _callback_invoice_id($value, $row)
	{
	return "<a href='".site_url('admin/invoice/'.$value)."' target='_parent'>$value</a>";
	}

	public function _callback_invoice_total($value, $row)
	{
		$this->chkLogin(false);
		$options = $this->gmsOptions();
		return $options['currency_symbol'].' '.amnt($value);
	}

	public function _callback_invoice_created($value, $row)
	{
		if($value != '0000-00-00')
			return date("d M Y", strtotime($value));
		else
			return '';
	}

	public function _callback_payment_created($value, $row)
	{
		return date("d M Y H:i:s", strtotime($value));
	}

	function retrievees($esid)
	{
		$tenuid = $this->admin_model->retrievees($esid);

		$this->session->set_flashdata('tenant_flash', $this->lan['es_retrive_success']);
		redirect('admin/tenant/'.$tenuid, 'refresh');
	}
	
	function tenants($target = '', $tenuid = '')
	{
            $this->chkLogin();

            if(!empty($target))
            {
                if($target == 'add')
                {
                    $this->newtenant();
                }
                else if($target == 'edit' && !empty($tenuid))
                {
                    $this->edittenant($tenuid);
				}
				else if($target == 'assignbed' && !empty($tenuid))
                {
                    $this->assignTenantBed($tenuid);
                }
            }
            else 
            {
				$data['options'] = $this->gmsOptions();
                $data['tenlist'] = $this->admin_model->getAllTenants($this->branchid);
                $data['title'] = ucfirst($this->lan['tenants']." - ".$data['options']['dhp_name']." | Calgary HMS");
                $data['cpage'] = 'tenants';
                $ten_list_msg = $this->session->flashdata('ten_list_msg');
                $data['notify_msg'] = isset($ten_list_msg) ? $ten_list_msg : '';
                $data['notify_type'] = 'success';

                $this->load->view('backend/common/header',$data);
                $this->load->view('backend/tenants',$data);
                $this->load->view('backend/common/footer',$data);
            }
	}
	
	function newtenant()
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['allrooms'] = $this->admin_model->getAllRooms();
		$data['branches'] = $this->admin_model->getAllBranches();
		$data['title'] = ucfirst($this->lan['new'].' '.$this->lan['tenant']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newtenant';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newtenant',$data);
		$this->load->view('backend/common/footer',$data);
	}
        
	function edittenant($tenuid)
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['userdata'] = $this->session->userdata;
		$data['tendata'] = $this->admin_model->getTenantDetails($tenuid);
		$data['title'] = ucfirst($this->lan['edit'].' '.$this->lan['tenant']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newtenant';
		$data['burl'] = $this->burl;
        $data['tenuid'] = $tenuid;
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newtenant',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function deleteTenant()
	{
		$this->chkLogin();
		$tenuid = html_escape($this->input->post('tenantid'));
		$resp = $this->admin_model->delTenant($tenuid);
		echo json_encode(array('status' => $resp['status'], 'msg' => $resp['msg']));
	}

	function assignTenantBed($tenuid)
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['tenlist'] = $this->admin_model->getAllTenants($this->branchid);
		$data['allrooms'] = $this->admin_model->getAllRooms($this->branchid);
		$data['allbeds'] = $this->admin_model->getAllBeds();
		$data['title'] = ucfirst($this->lan['assign'].' '.$this->lan['bed']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newtenant';
		$data['tenuid'] = $tenuid;
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/assigntenbed',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function newinvoice()
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['tenlist'] = $this->admin_model->getAllTenants($this->branchid);
		$data['allrooms'] = $this->admin_model->getAllRooms($this->branchid);
		$data['allbeds'] = $this->admin_model->getAllBeds($this->branchid);
		$invoice_list_msg = $this->session->flashdata('invoice_list_msg');
		$data['notify_msg'] = isset($invoice_list_msg) ? $invoice_list_msg : '';
		$data['notify_type'] = 'success';
		$data['title'] = ucfirst($this->lan['generate'].' '.$this->lan['invoice']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'invoices';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newinvoice',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function deleteRoom()
	{
		$this->chkLogin();
		$roomid = html_escape($this->input->post('roomid'));
		$resp = $this->admin_model->delRoom($roomid);
		echo json_encode(array('status' => $resp['status'], 'msg' => $resp['msg']));
	}

	function deleteBed()
	{
		$this->chkLogin();
		$bedid = html_escape($this->input->post('bedid'));
		$resp = $this->admin_model->delBed($bedid);
		echo json_encode(array('status' => $resp['status'], 'msg' => $resp['msg']));
	}

	function deleteEs()
	{
		$this->chkLogin();
		$esid = html_escape($this->input->post('esid'));
		$resp = $this->admin_model->delEs($esid);
		echo json_encode(array('status' => $resp['status'], 'msg' => $resp['msg']));
	}

	function retractBed()
	{
		$this->chkLogin();
		$bed_uid = html_escape($this->input->post('bedUid'));
		$resp = $this->admin_model->retractBed($bed_uid);
		echo json_encode(array('status' => $resp['status'], 'msg' => $resp['msg']));
	}

	function retractTenBed()
	{
		$this->chkLogin();
		$tenuid = html_escape($this->input->post('tenuid'));
		$ten_data = $this->admin_model->getTenantDetails($tenuid);
		$bed_uid = $ten_data['ten_bed'];
		$resp = $this->admin_model->retractBed($bed_uid);
		echo json_encode(array('status' => $resp['status'], 'msg' => $resp['msg']));
	}

	function alpha_dash_space($fullname){
		if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
			$this->form_validation->set_message('alpha_dash_space', '%s '.$this->lan['alpha_num_issue']);
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function updatetenant()
	{
		$this->load->library('form_validation');
		$options = $this->gmsOptions();
		$tenuid = html_escape($this->input->post('ten_uid'));

		$this->form_validation->set_rules('ten_dob', $this->lan['dob'], 'trim|required|xss_clean');
		$this->form_validation->set_rules('ten_contact', $this->lan['contact'].' '.$this->lan['number'], 'trim|required|min_length[7]|max_length[12]|numeric|xss_clean');
		$this->form_validation->set_rules('ten_emc_name', $this->lan['emergency'].' '.$this->lan['contact'].' '.$this->lan['name'], 'trim|required|xss_clean');
		$this->form_validation->set_rules('ten_emc_contact', $this->lan['emergency'].' '.$this->lan['contact'].' '.$this->lan['number'], 'trim|required|min_length[7]|max_length[12]|numeric|xss_clean');
		$this->form_validation->set_rules('ten_tax_company_email', $this->lan['company_email'], 'trim|valid_email|xss_clean');

		if (null != ($_FILES['ten_photo_select']['tmp_name']))
		{
		  $this->form_validation->set_rules('ten_photo_select', 'Photo', 'callback_checkPostedPhotoSize');
		  $this->form_validation->set_rules('ten_photo_select', 'Photo', 'callback_checkPostedPhotoType');
		}
		
		$this->form_validation->set_message('is_unique', '%s '.$this->lan['unique_error']);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
				$this->tenant($tenuid,'tenantview');
		}
		else
		{
			$this->admin_model->updateTenantData($tenuid);
			$msg = $this->lan['tenant_data_Update_successful'];
			$this->session->set_flashdata('tenant_flash', $msg);
			redirect('admin/tenant/'.$tenuid.'/tenantview', 'refresh');
		}
	}
	
	function savetenant()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		$options = $this->gmsOptions();
		
		$tenuid = html_escape($this->input->post('ten_uid'));
		if($tenuid == 0)
			$this->form_validation->set_rules('ten_email', $this->lan['tenant'].' '.$this->lan['email'], 'trim|required|valid_email|xss_clean|is_unique[tbl_tenants.ten_email]');
		else
			$this->form_validation->set_rules('ten_email', $this->lan['tenant'].' '.$this->lan['email'], 'trim|required|valid_email|xss_clean');
                
		$this->form_validation->set_rules('ten_name', $this->lan['tenant'].' '.$this->lan['name'], 'trim|required|xss_clean|callback_alpha_dash_space');
		$this->form_validation->set_rules('ten_dob', $this->lan['dob'], 'trim|required|xss_clean');
		$this->form_validation->set_rules('ten_contact', $this->lan['contact'].' '.$this->lan['number'], 'trim|required|min_length[7]|max_length[12]|numeric|xss_clean');
		$this->form_validation->set_rules('ten_emc_name', $this->lan['emergency'].' '.$this->lan['contact'].' '.$this->lan['name'], 'trim|required|xss_clean');
		$this->form_validation->set_rules('ten_emc_contact', $this->lan['emergency'].' '.$this->lan['contact'].' '.$this->lan['number'], 'trim|required|min_length[7]|max_length[12]|numeric|xss_clean');
		$this->form_validation->set_rules('ten_tax_company_email', $this->lan['company_email'], 'trim|valid_email|xss_clean');

		if (null != ($_FILES['ten_photo_select']['tmp_name']))
		{
		  $this->form_validation->set_rules('ten_photo_select', 'Photo', 'callback_checkPostedPhotoSize');
		  $this->form_validation->set_rules('ten_photo_select', 'Photo', 'callback_checkPostedPhotoType');
		}
		
		$this->form_validation->set_message('is_unique', '%s '.$this->lan['unique_error']);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		
		$options = $this->gmsOptions();
		$lastmem = $this->admin_model->getLastTenant('ten_uid');
		if(is_array($lastmem) && count($lastmem) <= 0)
		{
			$newtenuid = $options['tid_start'];
		}
		else 
		{
			$newtenuid = $lastmem['ten_uid']+1;
		}
                
		if($this->form_validation->run() == FALSE)
		{
			if($tenuid == 0)
				$this->newtenant();
			else
				$this->edittenant($tenuid);
		}
		else
		{
			$this->admin_model->addTenant($tenuid,$newtenuid);
			if($tenuid == 0)
			{
				if(!empty($options['smtp_host']) && !empty($options['smtp_username']) && !empty($options['smtp_pass']))
				{
					$content = getEmailTemplate('email_tenant_create');
					$maildata = array(
						'{{ten_name}}' => html_escape($this->input->post('ten_name')),
						'{{dhpm_name}}' => $options['dhp_name'],
						'{{ten_email}}' => html_escape($this->input->post('ten_email'))
					);
					$content = str_replace(array_keys($maildata), $maildata, $content);
					$subject = 'Your account details';
					sendMail($options['email'],$options['dhp_name'],html_escape($this->input->post('ten_email')),$subject,$content);
				}
				$msg = $this->lan['tenant'].' '.$this->lan['successfully'].' '.$this->lan['inserted'];
			}	
			else
			{
				$msg = $this->lan['tenant'].' '.$this->lan['successfully'].' '.$this->lan['updated'];                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
			}
			
			$this->session->set_flashdata('ten_list_msg', $msg);
			redirect('admin/tenants', 'refresh');
		}
	}
	
	function rooms($target = '', $roomuid = '')
	{
            $this->chkLogin();

            if(!empty($target))
            {
                if($target == 'add')
                {
                    $this->newroom();
                }
                else if($target == 'edit' && !empty($roomuid))
                {
                    $this->editroom($roomuid);
                }
            }
            else 
            {
				$data['options'] = $this->gmsOptions();
                $data['roomlist'] = $this->admin_model->getAllRooms($this->branchid);
                $data['title'] = ucfirst($this->lan['rooms']." - ".$data['options']['dhp_name']." | Calgary HMS");
                $data['cpage'] = 'rooms';
                $room_list_msg = $this->session->flashdata('room_list_msg');
                $data['notify_msg'] = isset($room_list_msg) ? $room_list_msg : '';
                $data['notify_type'] = 'success';

                $this->load->view('backend/common/header',$data);
                $this->load->view('backend/rooms',$data);
                $this->load->view('backend/common/footer',$data);
            }
	}
	
	function newroom()
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['new'].' '.$this->lan['room']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newroom';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newroom',$data);
		$this->load->view('backend/common/footer',$data);
	}
	
	function editroom($roomuid)
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['roomdata'] = $this->admin_model->getRoomDetails($roomuid);
		$data['title'] = ucfirst($this->lan['edit'].' '.$this->lan['room']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'editroom';
		$data['roomuid'] = $roomuid;
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newroom',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function roomstructure($roomuid)
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['roomdata'] = $this->admin_model->getRoomDetails($roomuid);
		$data['bedsdata'] = $this->admin_model->getBedsForRoom($roomuid);
		$data['title'] = ucfirst($this->lan['room'].' '.$this->lan['structure']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'rooms';
		$data['roomuid'] = $roomuid;
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/roomstructure',$data);
		$this->load->view('backend/common/footer',$data);
	}
	
	function saveroom()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		
		$roomuid = html_escape($this->input->post('room_uid'));
                
		$this->form_validation->set_rules('room_name', $this->lan['room'].' '.$this->lan['name'], 'trim|required|xss_clean');
		$this->form_validation->set_rules('room_price', $this->lan['room'].' '.$this->lan['price'], 'trim|required|numeric|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		
		$options = $this->gmsOptions();
		$lastroom = $this->admin_model->getLastRoom('room_uid');
		if(is_array($lastroom) && count($lastroom) <= 0)
		{
			$newroomuid = $options['rid_start'];
		}
		else 
		{
			$newroomuid = $lastroom['room_uid']+1;
		}
                
		if($this->form_validation->run() == FALSE)
		{
			if($roomuid == 0)
				$this->newroom();
			else
				$this->editroom($roomuid);
		}
		else
		{
			$this->admin_model->addRoom($roomuid,$newroomuid);
			if($roomuid == 0)
				$msg = $this->lan['room'].' '.$this->lan['successfully'].' '.$this->lan['inserted'];
			else
				$msg = $this->lan['room'].' '.$this->lan['successfully'].' '.$this->lan['updated'];
			
			$this->session->set_flashdata('room_list_msg', $msg);
			redirect('admin/rooms', 'refresh');
		}
	}

	function compareDate() 
	{
		$startDate = strtotime(html_escape($_POST['lease_from']));
		$endDate = strtotime(html_escape($_POST['lease_to']));
	  
		if ($endDate >= $startDate)
		  return True;
		else {
		  $this->form_validation->set_message('compareDate', '%s '.$this->lan['compare_date_error']);
		  return False;
		}
	}
	
	function checkPostedPhotoSize()
	{
		$this->form_validation->set_message('checkPostedPhotoSize', $this->lan['photo_size_error']);
		if ($_FILES["ten_photo_select"]["size"] > 5000000) {
				return false;
			}else{
				return true;
			}
	}
	
	function checkPostedPhotoType()
	{
		$this->form_validation->set_message('checkPostedPhotoType', $this->lan['photo_type_error']);
		if (($_FILES["ten_photo_select"]["type"] == "image/gif") || ($_FILES["ten_photo_select"]["type"] == "image/jpeg") || ($_FILES["ten_photo_select"]["type"] == "image/png" )){
				return true;
			}else{
				return false;
			}
	}

	
	function beds($target = '', $beduid = '',  $tenuid = '', $reqid = '')
	{
            $this->chkLogin();

            if(!empty($target))
            {
                if($target == 'add')
                {
                    $this->newbed();
                }
                else if($target == 'edit' && !empty($beduid))
                {
                    $this->editbed($beduid);
				}
				else if($target == 'assign' && !empty($beduid))
                {
                    $this->assignbed($beduid, $tenuid, $reqid);
                }
            }
            else 
            {
				$data['options'] = $this->gmsOptions();
				$data['title'] = ucfirst($this->lan['beds']." - ".$data['options']['dhp_name']." | Calgary HMS");
				$data['bedlist'] = $this->admin_model->getAllBeds($this->branchid);
                $data['cpage'] = 'beds';
                $bed_list_msg = $this->session->flashdata('bed_list_msg');
                $data['notify_msg'] = isset($bed_list_msg) ? $bed_list_msg : '';
                $data['notify_type'] = 'success';

                $this->load->view('backend/common/header',$data);
                $this->load->view('backend/beds',$data);
                $this->load->view('backend/common/footer',$data);
            }
	}
	
	function newbed()
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['allrooms'] = $this->admin_model->getAllRooms($this->branchid);
		$data['title'] = ucfirst($this->lan['new'].' '.$this->lan['bed']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newbed';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newbed',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function editbed($beduid)
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['allrooms'] = $this->admin_model->getAllRooms();
		$data['beddata'] = $this->admin_model->getBedDetails($beduid);
		$data['title'] = ucfirst($this->lan['edit'].' '.$this->lan['bed']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newbed';
		$data['beduid'] = $beduid;
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newbed',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function assignbed($beduid, $tenuid = '', $reqid = '')
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['tenlist'] = $this->admin_model->getAllTenants($this->branchid);
		$data['allrooms'] = $this->admin_model->getAllRooms($this->branchid);
		$data['beddata'] = $this->admin_model->getBedDetails($beduid);
		$data['title'] = ucfirst($this->lan['assign'].' '.$this->lan['bed']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newbed';
		$data['beduid'] = $beduid;
		$data['tenuid'] = $tenuid;
		$data['reqid'] = $reqid;

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/assignbed',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function requestbed()
	{
		$this->chkLogin(false);
		$data['options'] = $this->gmsOptions();
		$data['allrooms'] = $this->admin_model->getAllRooms($this->branchid);
		$data['allbeds'] = $this->admin_model->getAllBeds();
		$data['title'] = ucfirst($this->lan['requestbed']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['tenuid'] = $this->session->userdata['user_id'];
		$data['cpage'] = 'makerequest';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/requestbed',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function requestes()
	{
		$this->chkLogin(false);
		$data['options'] = $this->gmsOptions();
		$data['alles'] = $this->admin_model->getAllEs($this->branchid);
		$data['title'] = ucfirst($this->lan['requestes']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['tenuid'] = $this->session->userdata['user_id'];
		$data['cpage'] = 'makerequest';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/requestes',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function allrequests()
	{
		$this->chkLogin(false);
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['allrequests']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['tenuid'] = $this->session->userdata['user_id'];
		$usertype = $this->session->userdata['user_type'];
		$tenid = ($usertype == 'tenant') ? $data['tenuid'] : '';
		$data['requests'] = $this->admin_model->getAllRequests($tenid);
		$data['cpage'] = 'makerequest';
		$req_list_msg = $this->session->flashdata('req_list_msg');
		$data['notify_msg'] = isset($req_list_msg) ? $req_list_msg : '';
		$data['notify_type'] = 'success';

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/allrequests',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function rejectrequest($reqid)
	{
		$this->chkLogin();
		$this->admin_model->rejectReq($reqid);
		$msg = $this->lan['rejectedmsg'];
		$this->session->set_flashdata('req_list_msg', $msg);
		redirect('admin/allrequests', 'refresh');
	}


	function savebed()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		
		$beduid = html_escape($this->input->post('bed_uid'));
                
		$this->form_validation->set_rules('bed_name', $this->lan['bed'].' '.$this->lan['name'], 'trim|required|xss_clean');
		$this->form_validation->set_rules('bed_room', $this->lan['room'], 'trim|required|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		
		$options = $this->gmsOptions();
		$lastbed = $this->admin_model->getLastBed('bed_uid');
		if(is_array($lastbed) && count($lastbed) <= 0)
		{
			$newbeduid = $options['bid_start'];
		}
		else 
		{
			$newbeduid = $lastbed['bed_uid']+1;
		}
                
		if($this->form_validation->run() == FALSE)
		{
			if($beduid == 0)
				$this->newbed();
			else
				$this->editbed($beduid);
		}
		else
		{
			$this->admin_model->addBed($beduid,$newbeduid);
			if($beduid == 0)
				$msg = $this->lan['bed'].' '.$this->lan['successfully'].' '.$this->lan['inserted'];
			else
				$msg = $this->lan['bed'].' '.$this->lan['successfully'].' '.$this->lan['updated'];
			
			$this->session->set_flashdata('bed_list_msg', $msg);
			redirect('admin/beds', 'refresh');
		}
	}

	function processbed()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		$options = $this->gmsOptions();

		$beduid = html_escape($this->input->post('bed_uid'));

		$this->form_validation->set_rules('assignbed_tenant', $this->lan['tenant'], 'trim|required');
		$this->form_validation->set_rules('total_amnt', $this->lan['total'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('paid_amnt', $this->lan['paid'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('bal_amnt', $this->lan['balance'].' '.$this->lan['amount'], 'trim|required|numeric');

		$this->form_validation->set_rules('tax_per', $options['tax_name'], 'trim|numeric');
		$this->form_validation->set_rules('tax2_per', $options['tax2_name'], 'trim|numeric');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		

		if($this->form_validation->run() == FALSE)
		{
			$this->assignbed($beduid);
		}
		else
		{
			$reqid = $this->input->post('requestid');
			$tax1 = calcTax(html_escape($this->input->post('tax_per')),html_escape($this->input->post('base_amnt')));
			$tax2 = calcTax(html_escape($this->input->post('tax2_per')),html_escape($this->input->post('base_amnt')));

			$assbed = $this->admin_model->assignBed($beduid,$tax1,$tax2);

			if(!empty($reqid))
			{
				$this->admin_model->approveReq($reqid);
			}

			$msg = $this->lan['bed'].' '.$this->lan['successfully'].' '.$this->lan['assigned'];

			if(!empty($options['smtp_host']) && !empty($options['smtp_username']) && !empty($options['smtp_pass']))
			{
				$ten = $this->admin_model->getTenantDetails(html_escape($this->input->post('assignbed_tenant')));
				$content = getEmailTemplate('room_asigned');
				$maildata = array(
					'{{ten_name}}' => $ten['ten_name'],
					'{{dhpm_name}}' => $options['dhp_name'],
					'{{room_name}}' => html_escape($this->input->post('room_name')),
					'{{bed_name}}' => html_escape($this->input->post('bed_name')),
					'{{total_amount}}' => html_escape($this->input->post('total_amnt')),
					'{{invoice_status}}' => $assbed['inv_status']
				);
				$content = str_replace(array_keys($maildata), $maildata, $content);
				$subject = $this->lan['bed_assign_email_subject'];
				sendMail($options['email'],$options['dhp_name'],$ten['ten_email'],$subject,$content);
			}

			$this->session->set_flashdata('bed_list_msg', $msg);
			redirect('admin/beds', 'refresh');
		}
	}

	function processTenBed()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		$options = $this->gmsOptions();

		$tenuid = html_escape($this->input->post('assignbed_tenant'));

		$this->form_validation->set_rules('room_uid', $this->lan['room'], 'trim|required');
		$this->form_validation->set_rules('bed_uid', $this->lan['bed'], 'trim|required');
		$this->form_validation->set_rules('total_amnt', $this->lan['total'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('paid_amnt', $this->lan['paid'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('bal_amnt', $this->lan['balance'].' '.$this->lan['amount'], 'trim|required|numeric');

		$this->form_validation->set_rules('tax_per', $options['tax_name'], 'trim|numeric');
		$this->form_validation->set_rules('tax2_per', $options['tax2_name'], 'trim|numeric');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
			$this->assignTenantBed($tenuid);
		}
		else
		{
			$tax1 = calcTax(html_escape($this->input->post('tax_per')),html_escape($this->input->post('base_amnt')));
			$tax2 = calcTax(html_escape($this->input->post('tax2_per')),html_escape($this->input->post('base_amnt')));

			$this->admin_model->assignBed($tenuid,$tax1,$tax2);
			$msg = $this->lan['bed'].' '.$this->lan['successfully'].' '.$this->lan['assigned'];
			$this->session->set_flashdata('ten_list_msg', $msg);
			redirect('admin/tenants', 'refresh');
		}
	}

	function processRequestBed()
	{
		$this->chkLogin(false);
		$this->load->library('form_validation');
		$options = $this->gmsOptions();

		$tenuid = html_escape($this->input->post('assignbed_tenant'));

		$this->form_validation->set_rules('room_uid', $this->lan['room'], 'trim|required');
		$this->form_validation->set_rules('bed_uid', $this->lan['bed'], 'trim|required');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
			$this->requestbed();
		}
		else
		{
			$this->admin_model->requestbed($tenuid);
			$msg = $this->lan['bed_s_req'];
			$this->session->set_flashdata('dash_msg', $msg);
			redirect('admin/dashboard', 'refresh');
		}
	}

	function processRequestEs()
	{
		$this->chkLogin(false);
		$this->load->library('form_validation');
		$options = $this->gmsOptions();

		$tenuid = html_escape($this->input->post('assignbed_tenant'));

		$this->form_validation->set_rules('es_uid', $this->lan['extraservice'], 'trim|required');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
			$this->requestes();
		}
		else
		{
			$this->admin_model->requestes($tenuid);
			$msg = $this->lan['es_s_req'];
			$this->session->set_flashdata('dash_msg', $msg);
			redirect('admin/dashboard', 'refresh');
		}
	}

	function processes()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		$options = $this->gmsOptions();

		$esid = html_escape($this->input->post('esid'));

		$this->form_validation->set_rules('assignbed_tenant', $this->lan['tenant'], 'trim|required');
		$this->form_validation->set_rules('total_amnt', $this->lan['total'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('paid_amnt', $this->lan['paid'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('bal_amnt', $this->lan['balance'].' '.$this->lan['amount'], 'trim|required|numeric');

		$this->form_validation->set_rules('tax_per', $options['tax_name'], 'trim|numeric');
		$this->form_validation->set_rules('tax2_per', $options['tax2_name'], 'trim|numeric');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		

		if($this->form_validation->run() == FALSE)
		{
			$this->assignextraservices($esid);
		}
		else
		{
			$reqid = $this->input->post('requestid');
			$tax1 = calcTax(html_escape($this->input->post('tax_per')),html_escape($this->input->post('base_amnt')));
			$tax2 = calcTax(html_escape($this->input->post('tax2_per')),html_escape($this->input->post('base_amnt')));

			$assignEs = $this->admin_model->assignEs($esid,$tax1,$tax2);

			if(!empty($reqid))
			{
				$this->admin_model->approveReq($reqid);
			}

			$msg = $this->lan['extraservices'].' '.$this->lan['successfully'].' '.$this->lan['assigned'];

			if(!empty($options['smtp_host']) && !empty($options['smtp_username']) && !empty($options['smtp_pass']))
			{
				$ten = $this->admin_model->getTenantDetails(html_escape($this->input->post('assignbed_tenant')));
				$content = getEmailTemplate('es_assigned');
				$maildata = array(
					'{{ten_name}}' => $ten['ten_name'],
					'{{dhpm_name}}' => $options['dhp_name'],
					'{{es_name}}' => html_escape($this->input->post('room_name')),
					'{{total_amount}}' => html_escape($this->input->post('total_amnt')),
					'{{invoice_status}}' => $assignEs['inv_status']
				);
				$content = str_replace(array_keys($maildata), $maildata, $content);
				$subject = $this->lan['es_assign_email_subject'];
				sendMail($options['email'],$options['dhp_name'],$ten['ten_email'],$subject,$content);
			}

			$this->session->set_flashdata('extraservices_list_msg', $msg);
			redirect('admin/extraservices', 'refresh');
		}
	}

	function extraservices($target = '', $extraservicesuid = '',  $tenuid = '', $reqid = '')
	{
            $this->chkLogin();

            if(!empty($target))
            {
                if($target == 'add')
                {
                    $this->newextraservice();
                }
                else if($target == 'edit' && !empty($extraservicesuid))
                {
                    $this->editextraservice($extraservicesuid);
                }
				else if($target == 'assign')
                {
                    $this->assignextraservices($extraservicesuid,$tenuid,$reqid);
                }
            }
            else 
            {
				$data['options'] = $this->gmsOptions();
				$data['eslist'] = $this->admin_model->getAllEs($this->branchid);
                $data['title'] = ucfirst($this->lan['extraservices']." - ".$data['options']['dhp_name']." | Calgary HMS");
                $data['cpage'] = 'extraservices';
                $extraservices_list_msg = $this->session->flashdata('extraservices_list_msg');
                $data['notify_msg'] = isset($extraservices_list_msg) ? $extraservices_list_msg : '';
                $data['notify_type'] = 'success';

                $this->load->view('backend/common/header',$data);
                $this->load->view('backend/extraservices',$data);
                $this->load->view('backend/common/footer',$data);
            }
	}

	function saveextraservice()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		
		$esid = html_escape($this->input->post('extrservice_uid'));
                
		$this->form_validation->set_rules('es_name', $this->lan['extraservice'].' '.$this->lan['name'], 'trim|required|xss_clean');
		$this->form_validation->set_rules('es_price', $this->lan['extraservice'].' '.$this->lan['price'], 'trim|required|numeric|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		
		$options = $this->gmsOptions();
                
		if($this->form_validation->run() == FALSE)
		{
			if($esid == 0)
				$this->newextraservice();
			else
				$this->editextraservice($esid);
		}
		else
		{
			$this->admin_model->addEs($esid);
			if($esid == 0)
				$msg = $this->lan['extraservice'].' '.$this->lan['successfully'].' '.$this->lan['inserted'];
			else
				$msg = $this->lan['extraservice'].' '.$this->lan['successfully'].' '.$this->lan['updated'];
			
			$this->session->set_flashdata('extraservices_list_msg', $msg);
			redirect('admin/extraservices', 'refresh');
		}
	}


	function assignextraservices($esid,$tenuid,$reqid)
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['tenlist'] = $this->admin_model->getAllTenants($this->branchid);
		$data['allrooms'] = $this->admin_model->getAllRooms($this->branchid);
		$data['esdata'] = $this->admin_model->getEsDetails($esid);
		$data['title'] = ucfirst($this->lan['assign'].' '.$this->lan['extraservice']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newextraservice';
		$data['esid'] = $esid;
		$data['tenuid'] = $tenuid;
		$data['reqid'] = $reqid;
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/assignes',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function newextraservice()
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['new'].' '.$this->lan['extraservice']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newextraservice';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newextraservice',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function editextraservice($esid)
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['allrooms'] = $this->admin_model->getAllRooms();
		$data['esdata'] = $this->admin_model->getEsDetails($esid);
		$data['title'] = ucfirst($this->lan['edit'].' '.$this->lan['extraservice']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newextraservice';
		$data['extraserviceuid'] = $esid;
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newextraservice',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function invoices()
	{
		$data['options'] = $this->gmsOptions();
		$data['allinvs'] = $this->admin_model->getAllInvoices($this->branchid);
		$data['title'] = ucfirst($this->lan['invoices']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'invoices';
		$invoice_list_msg = $this->session->flashdata('invoice_list_msg');
		$data['notify_msg'] = isset($invoice_list_msg) ? $invoice_list_msg : '';
		$data['notify_type'] = 'success';

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/invoices',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function invoice($inv_id)
	{
		$data['options'] = $this->gmsOptions();
		$data['inv'] = $this->admin_model->getInvoice($inv_id);
		$data['title'] = ucfirst($this->lan['invoice']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'invoices';
		$invoice_list_msg = $this->session->flashdata('invoice_list_msg');
		$data['notify_msg'] = isset($invoice_list_msg) ? $invoice_list_msg : '';
		$data['notify_type'] = 'success';

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/invoice',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function export_invoice($inv_id)
	{
		$data['options'] = $this->gmsOptions();
		$data['inv'] = $this->admin_model->getInvoice($inv_id);
		$data['title'] = ucfirst($this->lan['invoice']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'invoices';
		$invoice_list_msg = $this->session->flashdata('invoice_list_msg');
		$data['notify_msg'] = isset($invoice_list_msg) ? $invoice_list_msg : '';
		$data['notify_type'] = 'success';
		$this->load->library('pdf');

		
		$html_content = $this->load->view('backend/invoicePdf',$data,true);
		
		$html_content = preg_replace('/>\s+</', "><", $html_content);
		$this->pdf->loadHtml($html_content);
		
		$this->pdf->render();
		ob_end_clean();
   		$this->pdf->stream("invoice.pdf", array("Attachment"=>0));
	}

	function users()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['users']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'users';

		$crud = new grocery_CRUD();
		$crud->set_table('tbl_users');
		$crud->set_relation('user_branch','tbl_branches','branch_name');
		$crud->columns(['user_email','user_name','user_joindate','user_lastlogin','user_type','user_branch']);
		$crud->field_type('user_pass', 'hidden');
		if ($crud->getState() == 'edit' || $crud->getState() == 'add') {
			$crud->field_type('user_joindate', 'hidden');
			$crud->field_type('user_lastlogin', 'hidden');
		}
		$crud->callback_add_field('user_joindate', array($this,'set_join_date'));
		$crud->callback_add_field('user_lastlogin', array($this,'set_login_date'));
		$crud->callback_before_insert(array($this,'encrypt_password_callback'));
		$crud->set_rules('user_email',$this->lan['user'].' '.$this->lan['email'],'required|valid_email|xss_clean');
		$crud->set_rules('user_name',$this->lan['user'].' '.$this->lan['name'],'required|xss_clean');
		$crud->unique_fields(array('user_email'));
		$crud->change_field_type('user_type','enum', array('admin','branch admin'));
		$crud->display_as('user_email',$this->lan['user'].' '.$this->lan['email'])
			->display_as('user_name',$this->lan['user'].' '.$this->lan['name'])
			->display_as('user_joindate',$this->lan['joindate'])
			->display_as('user_lastlogin',$this->lan['lastlogin'])
			->display_as('user_type',$this->lan['user'].' '.$this->lan['type'])
			->display_as('user_branch',$this->lan['user'].' '.$this->lan['branch']);

		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/users',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function set_join_date($value = '', $primary_key = null){
		return '<input type="hidden" value="'.date("Y-m-d").'" name="user_joindate">';
	}

	function set_login_date($value = '', $primary_key = null){
		return '<input type="hidden" value="'.date("Y-m-d H:i:s").'" name="user_lastlogin">';
	}

	function encrypt_password_callback($post_array) {
		$post_array['user_pass'] = md5($post_array['user_email']);
		return $post_array;
	}

	function branches()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['branches']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'settings';

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_branches');
		$crud->set_rules('branch_name',$this->lan['branch'].' '.$this->lan['name'],'required|xss_clean');
		$crud->unset_texteditor('branch_address');
		$crud->unset_fields('branch_currency','branch_currency_symbol');
		$crud->unset_columns('branch_currency','branch_currency_symbol');
		$crud->display_as('branch_name',$this->lan['branch'].' '.$this->lan['name'])
			->display_as('branch_address',$this->lan['branch'].' '.$this->lan['address'])
			->display_as('branch_contact',$this->lan['branch'].' '.$this->lan['contact']);
		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/branches',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function expensecat()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['expense'].' '.$this->lan['categories']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'settings';

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_exp_cat');
		$crud->set_rules('exp_cat_name',$this->lan['expense'].' '.$this->lan['category'].' '.$this->lan['name'],'required|xss_clean');
		$crud->display_as('exp_cat_name',$this->lan['expense'].' '.$this->lan['category'].' '.$this->lan['name'])
			->display_as('exp_cat_desc',$this->lan['description']);
		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/expensecat',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function ubillcat()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst("utility bill categories - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'settings';

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_utility_bill_cat');
		$crud->set_rules('utility_bill_cat_name','Utility Bill Cat Name','required');
		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/ubillcat',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function complaintcat()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['complaint'].' '.$this->lan['categories']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'settings';

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_complaint_cat');
		$crud->set_rules('complaint_cat_name',$this->lan['complaint'].' '.$this->lan['category'].' '.$this->lan['name'],'required');
		$crud->display_as('complaint_cat_name',$this->lan['complaint'].' '.$this->lan['category'].' '.$this->lan['name'])
			->display_as('complaint_cat_desc',$this->lan['description']);
		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/complaintcat',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function idcat()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst("ID Document categories - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'settings';

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_doc_type');
		$crud->set_rules('document_type','Document Type Name','required');
		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/idcat',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function emailtpl()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['email'].' '.$this->lan['templates']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'settings';

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_email_templates');
		$crud->set_rules('email_tpl_name',$this->lan['email'].' '.$this->lan['template'].' '.$this->lan['name'],'required');
		$crud->display_as('email_tpl_name',$this->lan['email'].' '.$this->lan['template'].' '.$this->lan['name'])
			->display_as('email_tpl_content',$this->lan['content']);
		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/emailtpl',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function webpages()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['web'].' '.$this->lan['pages']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'website';

		$this->load->config('grocery_crud');
 		$this->config->set_item('grocery_crud_xss_clean', false);

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_web_pages');
		$crud->set_rules('web_page_name',$this->lan['web'].' '.$this->lan['page'].' '.$this->lan['name'],'required');
		$crud->set_rules('show_in_menu',$this->lan['show_in_menu'],'required');
		$crud->display_as('web_page_name',$this->lan['web'].' '.$this->lan['page'].' '.$this->lan['name'])
			->display_as('show_in_menu',$this->lan['show_in_menu'])
			->display_as('web_page_content',$this->lan['content']);
		$crud->callback_before_insert(array($this,'xss_clean_webp'));
		$crud->callback_before_update(array($this,'xss_clean_webp'));

		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/webpage',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function blog()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['blog']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'website';

		$this->load->config('grocery_crud');
 		$this->config->set_item('grocery_crud_xss_clean', false);

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_blog');
		$crud->set_rules('blog_title',$this->lan['blog_title'],'required');
		$crud->set_rules('blog_content',$this->lan['blog_content'],'required');
		$crud->display_as('blog_title',$this->lan['blog_title'])
			->display_as('blog_content',$this->lan['blog_content'])
			->display_as('blog_image',$this->lan['blog_image']);
		$crud->callback_before_insert(array($this,'blog_date_in'));
		$crud->set_field_upload('blog_image','assets/uploads/files');
		$crud->field_type('blog_date', 'hidden');

		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/blog',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function gallery()
	{
		$this->chkLogin();
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['gallery']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'website';

		$this->load->config('grocery_crud');
 		$this->config->set_item('grocery_crud_xss_clean', false);

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_gallery');
		$crud->set_rules('gal_img',$this->lan['image'],'required');
		$crud->set_rules('gal_slider_img',$this->lan['gal_img_slider'],'required');

		$crud->display_as('gal_img',$this->lan['image'])
			->display_as('gal_title',$this->lan['title'])
			->display_as('gal_slider_img',$this->lan['gal_img_slider']);
		$crud->set_field_upload('gal_img','assets/uploads/files');

		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/gallery',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function events()
	{
		$this->chkLogin(false);
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['events']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'events';
		$gdata['userdata'] = $this->session->userdata;

		$this->load->config('grocery_crud');
 		$this->config->set_item('grocery_crud_xss_clean', false);

		$crud = new grocery_CRUD();
        $crud->set_table('tbl_events');
		$crud->set_rules('title',$this->lan['event_title'],'required');
		$crud->set_rules('start_event',$this->lan['start_event'],'required');
		$crud->set_rules('end_event',$this->lan['end_event'],'required');

		$crud->display_as('title',$this->lan['event_title'])
			->display_as('start_event',$this->lan['start_event'])
			->display_as('end_event',$this->lan['end_event'])
			->display_as('description',$this->lan['event_description']);

		if($gdata['userdata']['user_type'] != 'admin' && $gdata['userdata']['user_type'] != 'branch admin')
		{
			$crud->unset_add(); $crud->unset_edit(); $crud->unset_delete(); $crud->unset_clone(); 
		}

		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/events',$output);
		$this->load->view('backend/common/footer',$gdata);
	}

	function blog_date_in($post_array) {
		$post_array['blog_date'] = date("Y-m-d H:i:s");
		return $post_array;
	}

	function xss_clean_webp($post_array) {
		$post_array['web_page_name'] = html_escape($post_array['web_page_name']);
		return $post_array;
	}

	function filepicker($forckeditor = false)
	{
		$this->chkLogin(false);
		$data['connector'] = site_url() . '/admin/connector';
		$data['forck'] = $forckeditor;
		$this->load->view('backend/filemanager',$data);
	}

	function filemanager()
	{
		$this->chkLogin(false);
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['filemanager']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'website';
		$data['connector'] = site_url() . '/admin/connector';
		$dash_msg = $this->session->flashdata('dash_msg');
		$data['notify_msg'] = isset($dash_msg) ? $dash_msg : '';
		$data['notify_type'] = 'success';
		
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/filemanagermain',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function about()
	{
		$this->chkLogin(false);
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['aboutus']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'aboutus';
		$dash_msg = $this->session->flashdata('dash_msg');
		$data['notify_msg'] = isset($dash_msg) ? $dash_msg : '';
		$data['notify_type'] = 'success';
		
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/aboutus',$data);
		$this->load->view('backend/common/footer',$data);
	}

	public function connector()
	{
		$this->load->helper('url');
		$opts = array(
			'roots' => array(
				array( 
					'driver'        => 'LocalFileSystem',
					'path'          => FCPATH . '/assets/uploads/files',
					'URL'           => base_url('assets/uploads/files'),
					'uploadDeny'    => array('all'),                  // All Mimetypes not allowed to upload
					'uploadAllow'   => array('image', 'text/plain', 'application/pdf'),// Mimetype `image` and `text/plain` allowed to upload
					'uploadOrder'   => array('deny', 'allow'),        // allowed Mimetype `image` and `text/plain` only
					'accessControl' => array($this, 'elfinderAccess'),// disable and hide dot starting files (OPTIONAL)
					// more elFinder options here
				) 
			),
		);
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();
	}

	public function elfinderAccess($attr, $path, $data, $volume, $isDir, $relpath)
	{
		$basename = basename($path);
		return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
					&& strlen($relpath) !== 1           // but with out volume root
			? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
			:  null;                                 // else elFinder decide it itself
	}

	function notices($view = 'admin')
	{
		$this->chkLogin(false);
		$this->load->library('grocery_CRUD');
		$gdata['options'] = $this->gmsOptions();
		$gdata['title'] = ucfirst($this->lan['notices']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
		$gdata['cpage'] = 'notices';
		$gdata['userdata'] = $this->session->userdata;

		$crud = new grocery_CRUD();
		$crud->set_table('tbl_notices');
		if(!empty($this->branchid)) { $crud->where('notice_branch',$this->branchid); $crud->or_where('notice_branch',''); }
		$crud->set_rules('notice_title',$this->lan['notice'].' '.$this->lan['title'],'required');
		$crud->set_rules('notice_active',$this->lan['notice'].' '.$this->lan['active'],'required');
		$crud->set_relation('notice_branch','tbl_branches','branch_name');
		$crud->display_as('notice_title',$this->lan['notice'].' '.$this->lan['title'])
			->display_as('notice_details',$this->lan['notice'].' '.$this->lan['details'])
			->display_as('notice_branch',$this->lan['notice'].' '.$this->lan['branch'])
			->display_as('notice_active',$this->lan['notice'].' '.$this->lan['status']);
		$gdata['state'] = $crud->getState();

		if($gdata['userdata']['user_type'] != 'admin' && $gdata['userdata']['user_type'] != 'branch admin')
		{
			$crud->unset_add(); $crud->unset_edit(); $crud->unset_delete(); $crud->unset_clone(); 
		}

		if($gdata['userdata']['user_type'] == 'branch admin')
		{
			$crud->callback_field('notice_branch',array($this,'noticeForBranch'));
		}

		$output = $crud->render();
		$gdata['gc'] = $output;
		
		$this->load->view('backend/common/header',$gdata);
		$this->load->view('backend/notices',$gdata);
		$this->load->view('backend/common/footer',$gdata);
	}

	function noticeForBranch($value = '', $primary_key = null)
	{
		return '<input type="hidden" value="'.$this->branchid.'" name="notice_branch">';
	}

	function payments($target = '', $paymentuid = '')
	{
            $this->chkLogin();

            if(!empty($target))
            {
                if($target == 'add')
                {
                    $this->newpayment();
                }
            }
            else 
            {
				$data['options'] = $this->gmsOptions();
                $data['title'] = ucfirst($this->lan['payments']." - ".$data['options']['dhp_name']." | Calgary HMS");
				$data['cpage'] = 'payments';
				$data['payments'] = $this->admin_model->getPayments($this->branchid);
				$data['tenlist'] = $this->admin_model->getAllTenants($this->branchid);
                $payment_list_msg = $this->session->flashdata('payment_list_msg');
                $data['notify_msg'] = isset($payment_list_msg) ? $payment_list_msg : '';
                $data['notify_type'] = 'success';

                $this->load->view('backend/common/header',$data);
                $this->load->view('backend/payments',$data);
                $this->load->view('backend/common/footer',$data);
            }
	}
	
	function newpayment()
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['allinvs'] = $this->admin_model->getAllInvoices($this->branchid,'PAID');
		$data['title'] = ucfirst($this->lan['new'].' '.$this->lan['payment']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newpayment';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newpayment',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function addpayment()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
                
		$this->form_validation->set_rules('invoice', $this->lan['invoice'], 'trim|required');
		$this->form_validation->set_rules('total', $this->lan['total'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('paid', $this->lan['paid'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('balance', $this->lan['balance'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('pay_amnt', $this->lan['paying'].' '.$this->lan['amount'], 'trim|required|numeric|less_than_equal_to['.html_escape($this->input->post('balance')).']');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		
		$options = $this->gmsOptions();
                
		if($this->form_validation->run() == FALSE)
		{
			$this->newpayment();
		}
		else
		{
			$this->admin_model->addPayment();
			$msg = $this->lan['payment'].' '.$this->lan['successfully'].' '.$this->lan['added'];

			if(!empty($options['smtp_host']) && !empty($options['smtp_username']) && !empty($options['smtp_pass']))
			{
				$inv = $this->admin_model->getInvoice(html_escape($this->input->post('invoice')));
				$ten = $inv['tenant_details'];
				$content = getEmailTemplate('add_payment');
				$maildata = array(
					'{{ten_name}}' => $ten['ten_name'],
					'{{dhpm_name}}' => $options['dhp_name'],
					'{{pay_amnt}}' => html_escape($this->input->post('pay_amnt')),
					'{{inv_number}}' => html_escape($this->input->post('invoice')),
					'{{pay_date}}' => date('d M Y H:i:s')
				);
				$content = str_replace(array_keys($maildata), $maildata, $content);
				$subject = $this->lan['payment_email_subject'];
				sendMail($options['email'],$options['dhp_name'],$ten['ten_email'],$subject,$content);
			}
			
			$this->session->set_flashdata('payments_list_msg', $msg);
			redirect('admin/payments', 'refresh');
		}
	}

	function makepayment()
	{
		$this->chkLogin(false);
		$data['options'] = $this->gmsOptions();
		$data['allinvs'] = $this->admin_model->getAllInvoices('','PAID',$this->session->userdata['user_id']);
		$data['title'] = ucfirst($this->lan['make'].' '.$this->lan['payment']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'payments';
		$payment_list_msg = $this->session->flashdata('payment_list_msg');
		$data['notify_msg'] = isset($payment_list_msg) ? $payment_list_msg : '';
		$data['notify_type'] = 'success';

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/makepayment',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function madepayment()
	{
		$this->load->library('form_validation');
		$this->load->library('paypal_lib');
					
			$this->form_validation->set_rules('invoice', $this->lan['invoice'], 'trim|required');
			$this->form_validation->set_rules('total', $this->lan['total'].' '.$this->lan['amount'], 'trim|required|numeric');
			$this->form_validation->set_rules('paid', $this->lan['paid'].' '.$this->lan['amount'], 'trim|required|numeric');
			$this->form_validation->set_rules('balance', $this->lan['balance'].' '.$this->lan['amount'], 'trim|required|numeric');
			$this->form_validation->set_rules('pay_amnt', $this->lan['paying'].' '.$this->lan['amount'], 'trim|required|numeric|less_than_equal_to['.html_escape($this->input->post('balance')).']');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
			if($this->form_validation->run() == FALSE)
			{
				$this->makepayment();
			}
			else
			{
				$userdata = $this->session->userdata;
				$data['options'] = $this->gmsOptions();
				$data['allinvs'] = $this->admin_model->getAllInvoices('','PAID',$this->session->userdata['user_id']);
				$data['title'] = ucfirst($this->lan['make'].' '.$this->lan['payment']." - ".$data['options']['dhp_name']." | Calgary HMS");
				$data['cpage'] = 'payments';
				$data['showpaybutton'] = true;
				$data['amnt'] = html_escape($this->input->post('pay_amnt'));
				$data['balamnt'] = html_escape($this->input->post('balance'));
				$data['inv_id'] = html_escape($this->input->post('invoice'));
				$options = $data['options'];

				$itemName = "Payment For Invoice #".$data['inv_id'];
				$orderID = ucwords(uniqid());
				$paymentDate = date("Y-m-d H:i:s");

				if($options['payment_gtw'] == 'stripe') {

					$strp_amnt = $data['amnt']*100;

					if(!empty(html_escape($_POST['stripeToken']))){
						$stripeToken = html_escape($_POST['stripeToken']);
						$custName = $userdata['user_name'];
						$custEmail = $userdata['user_email'];
						$cardNumber = html_escape($_POST['cardNumber']);
						$cardCVC = html_escape($_POST['cardCVC']);
						$cardExpMonth = html_escape($_POST['cardExpMonth']);
						$cardExpYear = html_escape($_POST['cardExpYear']);
						require_once(APPPATH.'libraries/stripe/init.php');
						$stripe = array(
						"secret_key" => $options['stripe_secret_key'],
						"publishable_key" => $options['stripe_publishable_key']
						);
						\Stripe\Stripe::setApiKey($stripe['secret_key']);

						$customer = \Stripe\Customer::create(array(
						'email' => $custEmail,
						'source' => $stripeToken
						));

						
						$itemNumber = uniqid();
						$itemPrice = $strp_amnt;
						$currency = $options['currency_code'];
						

						$payDetails = \Stripe\Charge::create(array(
							'customer' => $customer->id,
							'amount' => $itemPrice,
							'currency' => $currency,
							'description' => $itemName,
							'metadata' => array(
							'order_id' => $orderID
							)
						));

						$paymenyResponse = $payDetails->jsonSerialize();

						if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1){

						$amountPaid = $paymenyResponse['amount'];
						$balanceTransaction = $paymenyResponse['balance_transaction'];
						$paidCurrency = $paymenyResponse['currency'];
						$paymentStatus = $paymenyResponse['status'];
						

						
						$paydata = array(
							'inv_id' => $data['inv_id'],
							'payment_id' => $orderID,
							'payment_method' => 'Stripe',
							'payment_trans_id' => $balanceTransaction,
							'payment_amnt' => $data['amnt'],
							'payment_date'=>$paymentDate,
							'payment_status'=>'success'
						);

						if($paymentStatus == 'succeeded')
						{
							$this->admin_model->updatePayment($paydata,$data['amnt'],$data['balamnt'],$data['inv_id']);
							$msg = $this->lan['payment'].' '.$this->lan['successfull'];
							$this->session->set_flashdata('payment_list_msg', $msg);
							redirect('admin/makepayment', 'refresh');
						} 
						else
						{
							$paymentMessage = $this->lan['payment'].' '.$this->lan['failed'];
							$this->session->set_flashdata('payment_list_msg', $paymentMessage);
							redirect('admin/makepayment', 'refresh');
						}
						} 
						else
						{
						$paymentMessage = $this->lan['payment'].' '.$this->lan['failed'];
						$this->session->set_flashdata('payment_list_msg', $paymentMessage);
							redirect('admin/makepayment', 'refresh');
						}
						} 
						else
						{
						$paymentMessage = $this->lan['payment'].' '.$this->lan['failed'];
						$this->session->set_flashdata('payment_list_msg', $paymentMessage);
							redirect('admin/makepayment', 'refresh');
						}
				}
				elseif($options['payment_gtw'] == 'paystack' || $options['payment_gtw'] == 'razorpay')
				{
					$paydata = array(
						'inv_id' => $data['inv_id'],
						'payment_id' => $orderID,
						'payment_method' => ucfirst($options['payment_gtw']),
						'payment_trans_id' => html_escape($this->input->post('pay_transid')),
						'payment_amnt' => $data['amnt'],
						'payment_date'=>$paymentDate,
						'payment_status'=>'success'
					);

					if(!empty(html_escape($this->input->post('pay_transid'))))
					{
						$this->admin_model->updatePayment($paydata,$data['amnt'],$data['balamnt'],$data['inv_id']);
						$msg = $this->lan['payment'].' '.$this->lan['successfull'];
						$this->session->set_flashdata('payment_list_msg', $msg);
					}
					
					redirect('admin/makepayment', 'refresh');
				}
				
			}
			
	}

	function expenses($target = '', $expenseuid = '')
	{

			$this->chkLogin();
			$this->load->library('grocery_CRUD');
			$gdata['options'] = $this->gmsOptions();
			$gdata['title'] = ucfirst($this->lan['expenses']." - ".$gdata['options']['dhp_name']." | Calgary HMS");
			$gdata['cpage'] = 'expenses';

			$crud = new grocery_CRUD();
			$crud->set_table('tbl_expenses');
			$crud->set_relation('exp_category','tbl_exp_cat','exp_cat_name');
			$crud->display_as('exp_name',$this->lan['expense'].' '.$this->lan['name'])
			->display_as('exp_amnt',$this->lan['amount'])
			->display_as('exp_customer_details',$this->lan['customer'].' '.$this->lan['details'])
			->display_as('exp_payment_method',$this->lan['payment'].' '.$this->lan['method'])
			->display_as('exp_ref_no',$this->lan['reference'].' '.$this->lan['number'])
			->display_as('exp_date',$this->lan['expense'].' '.$this->lan['date'])
			->display_as('exp_receipt',$this->lan['expense'].' '.$this->lan['receipt'])
			->display_as('exp_note',$this->lan['notes'])
			->display_as('exp_category',$this->lan['category']);
			$crud->unset_texteditor('exp_customer_details','exp_note');
			$crud->set_field_upload('exp_receipt','assets/uploads/files');
			$crud->unset_edit();
			$crud->set_rules('exp_name',$this->lan['expense'].' '.$this->lan['name'],'required');
			$crud->set_rules('exp_amnt',$this->lan['amount'],'required|numeric');
			$crud->set_rules('exp_category',$this->lan['category'],'required');
			$output = $crud->render();
			$gdata['gc'] = $output;

			$this->load->view('backend/common/header',$gdata);
			$this->load->view('backend/expenses',$output);
			$this->load->view('backend/common/footer',$gdata);
	}
	function newexpense()
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['new'].' '.$this->lan['expense']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'newpayment';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/newexpense',$data);
		$this->load->view('backend/common/footer',$data);
	}
	
	function reports($target = '')
	{
            $this->chkLogin();

            if(!empty($target))
            {
                if($target == 'income')
                {
                    $this->incomereport();
                }
                else if($target == 'expense')
                {
                    $this->expensereport();
                }
				else if($target == 'prpt')
                {
                    $this->prptreport();
                }
            }
	}
	
	function incomereport()
	{
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['income'].' '.$this->lan['report']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'report';
		$incomereport_list_msg = $this->session->flashdata('incomereport_list_msg');
		$data['notify_msg'] = isset($incomereport_list_msg) ? $incomereport_list_msg : '';
		$data['notify_type'] = 'success';
		$data['report'] = 'income';

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/incomereport',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function expensereport()
	{
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['expense'].' '.$this->lan['report']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'report';
		$incomereport_list_msg = $this->session->flashdata('incomereport_list_msg');
		$data['notify_msg'] = isset($incomereport_list_msg) ? $incomereport_list_msg : '';
		$data['notify_type'] = 'success';
		$data['report'] = 'expense';

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/incomereport',$data);
		$this->load->view('backend/common/footer',$data);
	}

	function generateIncomeReport()
	{
		$from_date = html_escape($this->input->post('from_date'));
		$to_date = html_escape($this->input->post('to_date'));
		
		$data['options'] = $this->gmsOptions();
		$data['incomereport'] = $this->admin_model->generateIncomeReport($this->branchid);
		$data['report_name'] = $this->lan['income'].' '.$this->lan['report'];
		$data['report'] = 'income';
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$this->load->library('pdf');

		
		$html_content = $this->load->view('backend/reportPdf',$data,true);

		$html_content = preg_replace('/>\s+</', "><", $html_content);
		$this->pdf->loadHtml($html_content);
		
		$this->pdf->render();
		ob_end_clean();
   		$this->pdf->stream("report.pdf", array("Attachment"=>0));
	}

	function generateExpenseReport()
	{
		$from_date = html_escape($this->input->post('from_date'));
		$to_date = html_escape($this->input->post('to_date'));
		
		$data['options'] = $this->gmsOptions();
		$data['expensereport'] = $this->admin_model->generateExpenseReport();
		$data['report_name'] = $this->lan['expense'].' '.$this->lan['report'];
		$data['report'] = 'expense';
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$this->load->library('pdf');

		
		$html_content = $this->load->view('backend/reportPdf',$data,true);

		$html_content = preg_replace('/>\s+</', "><", $html_content);
		$this->pdf->loadHtml($html_content);
		
		$this->pdf->render();
		ob_end_clean();
   		$this->pdf->stream("report.pdf", array("Attachment"=>0));
	}

	function prptreport()
	{
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst("prpt report - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'report';
		$prptreport_list_msg = $this->session->flashdata('prpt_list_msg');
		$data['notify_msg'] = isset($prptreport_list_msg) ? $prptreport_list_msg : '';
		$data['notify_type'] = 'success';

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/prptreport',$data);
		$this->load->view('backend/common/footer',$data);
	}
	function configurations()
	{
		$this->chkLogin();
		$data['options'] = $this->gmsOptions();
		$data['title'] = ucfirst($this->lan['configurations']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'configurations';
		$config_list_msg = $this->session->flashdata('config_list_msg');
		$data['notify_msg'] = isset($config_list_msg) ? $config_list_msg : '';
		$data['notify_type'] = 'success';
		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/configurations',$data);
		$this->load->view('backend/common/footer',$data);
	}

	public function _callback_getTenantNameFrom($value, $row)
	{
		return $this->admin_model->getTenantName($value);
	}


	function complaints()
	{
		$this->chkLogin(false);
		$this->load->library('grocery_CRUD');
		$data['options'] = $this->gmsOptions();
		$data['userdata'] = $this->session->userdata;
		$data['title'] = ucfirst($this->lan['complaints']." - ".$data['options']['dhp_name']." | Calgary HMS");
		$data['cpage'] = 'complaints';
		$data['burl'] = $this->burl;

		$crud = new grocery_CRUD();
		$crud->set_table('tbl_complaints');
		$crud->set_relation('complaint_cat','tbl_complaint_cat','complaint_cat_name');
		$crud->set_rules('complaint_title',$this->lan['complaint'].' '.$this->lan['name'],'required');
		$cols = array('complaint_title','complaint_text','complaint_cat');
		$crud->display_as('complaint_title',$this->lan['complaint'].' '.$this->lan['title'])
			->display_as('complaint_text',$this->lan['complaint'].' '.$this->lan['content'])
			->display_as('complaint_cat',$this->lan['complaint'].' '.$this->lan['category'])
			->display_as('complaint_tenant_uid',$this->lan['tenant']);

		if($data['userdata']['user_type'] == 'admin'){
			$cols[] = 'complaint_tenant_uid';
			$crud->callback_column('complaint_tenant_uid',array($this,'_callback_getTenantNameFrom'));
			$crud->unset_add(); $crud->unset_edit(); $crud->unset_delete(); $crud->unset_clone();
		}
		else
		{
			$crud->field_type('complaint_tenant_uid', 'hidden', $data['userdata']['user_id']);
			$crud->where('complaint_tenant_uid =', $data['userdata']['user_id']);
		}
		$crud->columns($cols);
		$output = $crud->render();
		$data['gc'] = $output;

		$this->load->view('backend/common/header',$data);
		$this->load->view('backend/complaints',$output);
		$this->load->view('backend/common/footer',$data);
	}

	function updateconfig()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		$options = $this->gmsOptions();

		$this->form_validation->set_rules('dhp_name', 'DHP Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('app_footer', 'Footer', 'trim|required|xss_clean');
		$this->form_validation->set_rules('contact_no', 'Contact Number', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
		$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required|xss_clean');
		$this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'trim|required|xss_clean');
		$this->form_validation->set_rules('tax_per', 'Tax %', 'trim|numeric');
		$this->form_validation->set_rules('tax2_per', 'Tax 2 %', 'trim|numeric');
		$this->form_validation->set_rules('tid_start', 'Tenant Start ID', 'trim|required|numeric');
		$this->form_validation->set_rules('rid_start', 'Room Start ID', 'trim|required|numeric');
		$this->form_validation->set_rules('bid_start', 'Bed Start ID', 'trim|required|numeric');

		if (null != ($_FILES['ten_photo_select']['tmp_name']))
		{
		  $this->form_validation->set_rules('ten_photo_select', 'Photo', 'callback_checkPostedPhotoSize');
		  $this->form_validation->set_rules('ten_photo_select', 'Photo', 'callback_checkPostedPhotoType');
		}

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		

		if($this->form_validation->run() == FALSE)
		{
			$this->configurations();
		}
		else
		{
			$this->admin_model->updateConfig();
			$msg = $this->lan['configurations'].' '.$this->lan['successfully'].' '.$this->lan['updated'];
			$this->session->set_flashdata('config_list_msg', $msg);
			redirect('admin/configurations', 'refresh');
		}
	}

	function getBeds($roomid='')
	{
		if(empty($roomid))
		{
			$roomid = html_escape($this->input->post('roomid'));
		}
		$allbeds = $this->admin_model->getBedsForRoom($roomid,1);
		echo json_encode(array('status' => 'success', 'allbeds' => $allbeds));
	}

	function getAllPaymentsForInvoice()
	{
		$invid = html_escape($this->input->post('invid'));
		$paydetails = $this->admin_model->getPayments('','',$invid);
		$paidamnt = 0;
		foreach($paydetails as $pay)
		{
			$paidamnt = $paidamnt + $pay['payment_amnt'];
		}
		$invdetails = $this->admin_model->getInvoice($invid);
		$balamnt = $invdetails['invoice']['inv_total'] - $paidamnt;
		$amnts = array(
			'total' => $invdetails['invoice']['inv_total'],
			'paid' => $paidamnt,
			'balance' => $balamnt
		);
		echo json_encode(array('status' => 'success', 'paydetails' => $paydetails, 'amnts' => $amnts));
	}

	function getInvoiceDetails()
	{
		$invid = html_escape($this->input->post('invid'));
		$invdetails = $this->admin_model->getInvoice($invid);
		echo json_encode(array('status' => 'success', 'invdetails' => $invdetails));
	}

	function getAllInvoicesForTenant()
	{
		$tenuid = html_escape($this->input->post('tenuid'));
		$allinvs = $this->admin_model->getAllInvoices('','',$tenuid);
		echo json_encode(array('status' => 'success', 'allinvs' => $allinvs));
	}

	function processinv()
	{
		$this->chkLogin();
		$this->load->library('form_validation');
		$options = $this->gmsOptions();

		$this->form_validation->set_rules('assignbed_tenant', 'Tenant', 'trim|required');
		$this->form_validation->set_rules('invoice', $this->lan['invoice'], 'trim|required');
		$this->form_validation->set_rules('base_amnt', $this->lan['base'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('total_amnt', $this->lan['total'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('paid_amnt', $this->lan['paid'].' '.$this->lan['amount'], 'trim|required|numeric');
		$this->form_validation->set_rules('bal_amnt', $this->lan['balance'].' '.$this->lan['amount'], 'trim|required|numeric');

		$this->form_validation->set_rules('tax_per', $options['tax_name'], 'trim|numeric');
		$this->form_validation->set_rules('tax2_per', $options['tax2_name'], 'trim|numeric');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible alertsm">', '</div>');
		

		if($this->form_validation->run() == FALSE)
		{
			$this->newinvoice();
		}
		else
		{
			$tax1 = calcTax(html_escape($this->input->post('tax_per')),html_escape($this->input->post('base_amnt')));
			$tax2 = calcTax(html_escape($this->input->post('tax2_per')),html_escape($this->input->post('base_amnt')));

			$this->admin_model->createInvoice($tax1,$tax2);
			$msg = $this->lan['invoice'].' '.$this->lan['successfully'].' '.$this->lan['generated'];
			$this->session->set_flashdata('invoice_list_msg', $msg);
			redirect('admin/newinvoice', 'refresh');
		}
	}
}