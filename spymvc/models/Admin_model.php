<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
	function test($data)
	{
		echo "<pre>";print_r($data);exit;
	}

	function login($email,$password)
	{
		$adminquery = $this->loaginAdmin($email,$password);
		if($adminquery->num_rows()>0)
		{
			$rows = $adminquery->row_array();
			$newdata = array(
			'user_id'  => $rows['id'],
			'user_name'  => $rows['user_name'],
			'user_email'    => $rows['user_email'],
			'user_type'    => $rows['user_type'],
			'profphoto'    => 'default_avatar.png',
			'logged_in'  => TRUE,
			);
			$this->session->set_userdata($newdata);
			return true;
		}
		else
		{
			$memberquery = $this->loginMember($email,$password);
			if($memberquery->num_rows()>0)
			{
				$rows = $memberquery->row_array();
				$newdata = array(
				'user_id'  => $rows['ten_uid'],
				'user_name'  => $rows['ten_name'],
				'user_email'    => $rows['ten_email'],
				'user_type'    => 'member',
				'profphoto'    => $rows['ten_pic'],
				'logged_in'  => TRUE,
				);
				$this->session->set_userdata($newdata);
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function register($newtenuid)
	{
		$date = date('Y-m-d H:i:s');	
		
		$data=array(
			'ten_name'=>html_escape($this->input->post('user_name')),
			'ten_email'=>html_escape($this->input->post('user_email')),
			'ten_add_date'=>$date,
			'ten_pic'=>'default_avatar.png',
			'ten_isactive'=>0,
			'ten_branch'=>html_escape($this->input->post('ten_branch'))
		);
        $data['ten_pass'] = md5(html_escape($this->input->post('user_password')));
		$data['ten_uid'] = $newtenuid;
		$insert = $this->db->insert('tbl_tenants',$data);
		return $insert?true:false;
	}

	function getUserBranch($email)
	{
		$this->db->where("user_email",$email);
		return $this->db->get("tbl_users")->row()->user_branch;
	}

	function getBranch($branchid)
	{
		$this->db->where("id",$branchid);
		$row=$this->db->get("tbl_branches")->row_array();
		return $row;
	}

	function getAllBranches()
	{
		return $this->db->get('tbl_branches')->result_array();
	}

	function getAllLangs()
	{
		return $this->db->get('tbl_languages')->result_array();
	}

	function getLanguageAbbr($lang)
	{
		return $this->db->where("lang_name",ucfirst($lang))->get('tbl_languages')->row()->lang_abbr;
	}

	function getWebPages()
	{
		return $this->db->get('tbl_web_pages')->result_array();
	}

	function loadGallery()
	{
		return $this->db->get('tbl_gallery')->result_array();
	}

	function getBlogPosts()
	{
		return $this->db->get('tbl_blog')->result_array();
	}

	function getWebPage($slug)
	{
		$webpages = $this->db->get('tbl_web_pages')->result_array();
		foreach($webpages as $webpage)
		{
			if(slug($webpage['web_page_name']) == $slug)
			{
				$pagedata = $webpage;
			}
		}
		return $pagedata;
	}
	
	function getTenantName($value)
	{
		return $this->db->where("ten_uid",$value)->get('tbl_tenants')->row()->ten_name;
	}

	function loaginAdmin($email,$password)
	{
		$this->db->where("user_email",$email);
		$this->db->where("user_pass",$password);
		$query=$this->db->get("tbl_users");
		return $query;
	}
	
	function loginMember($email,$password)
	{
		$this->db->where("ten_email",$email);
		$this->db->where("ten_pass",$password);
		$this->db->where("ten_isactive",1);
		$query=$this->db->get("tbl_tenants");
		return $query;
	}

	function checkCurrentPassowrdOfTenant($password,$udata)
	{
		$this->db->where("ten_email",$udata['user_email']);
		$this->db->where("ten_pass",md5($password));
		$this->db->where("ten_isactive",1);
		$return=$this->db->get("tbl_tenants")->row_array();
		if(is_array($return) && count($return) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function checkCurrentPassowrdOfAdmin($password,$udata)
	{
		$this->db->where("user_email",$udata['user_email']);
		$this->db->where("user_pass",md5($password));
		$return=$this->db->get("tbl_users")->row_array();
		if(is_array($return) && count($return) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function changepassword($udata)
	{
		if($udata['user_type'] != 'admin')
		{
			$data = array(
				'ten_pass' => md5(html_escape($_POST['n_pass']))
			);
			$this->db->where("ten_email",$udata['user_email']);
			$update = $this->db->update('tbl_tenants',$data);
		}
		else
		{
			$data = array(
				'user_pass' => md5(html_escape($_POST['n_pass']))
			);
			$this->db->where("user_email",$udata['user_email']);
			$update = $this->db->update('tbl_users',$data);
		}
		
		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function loadOptions()
	{
		$query=$this->db->get("tbl_dhpms_options");
		$rows = $query->result_array();
		return $rows;
	}
	
	function modulecounts($branch='')
	{
		if(!empty($branch)) { $this->db->where('ten_branch',$branch); }
		$return['tenants'] = $this->db->count_all_results('tbl_tenants');

		if(!empty($branch)) { $this->db->where('room_branch',$branch); }
		$return['rooms'] = $this->db->count_all_results('tbl_rooms');

		if(!empty($branch)) { 
			$this->db->select('*');
			$this->db->from('tbl_beds');
			$this->db->join('tbl_rooms', "tbl_rooms.room_uid = tbl_beds.bed_room");
			$this->db->where('tbl_rooms.room_branch',$branch); 
			$return['beds'] = $this->db->count_all_results();
		} else {
			$return['beds'] = $this->db->count_all_results('tbl_beds');
		}
		

		if(!empty($branch)) { 
			$this->db->select('*');
			$this->db->from('tbl_invoice');
			$this->db->join('tbl_tenants', "tbl_tenants.ten_uid = tbl_invoice.inv_ten_uid");
			$this->db->where('tbl_tenants.ten_branch',$branch); 
			$return['allinv'] = $this->db->count_all_results();
		} else {
			$return['allinv'] = $this->db->count_all_results('tbl_invoice');
		}
		

		if(!empty($branch)) { 
			$this->db->select('*');
			$this->db->from('tbl_invoice');
			$this->db->join('tbl_tenants', "tbl_tenants.ten_uid = tbl_invoice.inv_ten_uid");
			$this->db->where('tbl_tenants.ten_branch',$branch);
			$this->db->where('tbl_invoice.inv_status','PAID');
			$return['paidinv'] = $this->db->count_all_results();
		}
		else {
			$this->db->where('tbl_invoice.inv_status','PAID');
			$return['paidinv'] = $this->db->count_all_results('tbl_invoice');
		}
		

		if(!empty($branch)) { 
			$this->db->select('*');
			$this->db->from('tbl_invoice');
			$this->db->join('tbl_tenants', "tbl_tenants.ten_uid = tbl_invoice.inv_ten_uid");
			$this->db->where('tbl_tenants.ten_branch',$branch);
			$this->db->where('tbl_invoice.inv_status !=','PAID');
			$return['upaidinv'] = $this->db->count_all_results();
		}
		else {
			$this->db->where('tbl_invoice.inv_status !=','PAID');
			$return['upaidinv'] = $this->db->count_all_results('tbl_invoice');
		}
		

		$this->db->select_sum('inv_total');
		if(!empty($branch)) { 
			$this->db->from('tbl_invoice');
			$this->db->join('tbl_tenants', "tbl_tenants.ten_uid = tbl_invoice.inv_ten_uid");
			$this->db->where('tbl_tenants.ten_branch',$branch);
			$this->db->where('tbl_invoice.inv_status','PAID');
			$return['paidamnt'] = $this->db->get()->row()->inv_total;
		}
		else {
			$this->db->where('tbl_invoice.inv_status','PAID');
			$return['paidamnt'] = $this->db->get('tbl_invoice')->row()->inv_total;
		}
		

		if(!empty($branch)) { 
			$this->db->select('*');
			$this->db->from('tbl_invoice');
			$this->db->join('tbl_tenants', "tbl_tenants.ten_uid = tbl_invoice.inv_ten_uid");
			$this->db->where('tbl_tenants.ten_branch',$branch);
			$this->db->where('tbl_invoice.inv_status !=','PAID');
			$allunpaid = $this->db->get()->result_array();
		} else {
			$this->db->where('tbl_invoice.inv_status !=','PAID');
			$allunpaid = $this->db->get('tbl_invoice')->result_array();
		}
		$allpaid = 0;
		foreach($allunpaid as $upinv)
		{
			$allpaid += $this->db->select_sum('payment_amnt')->where('inv_id',$upinv['inv_id'])->get('tbl_invoice_payments')->row()->payment_amnt;
		}
		$invtotal = array_sum(array_column($allunpaid,'inv_total'));
		$return['upaidamnt'] = $invtotal - $allpaid;

		$this->db->select_sum('payment_amnt');
		if(!empty($branch)) { 
			$this->db->from('tbl_invoice_payments');
			$this->db->join('tbl_invoice', "tbl_invoice.inv_id = tbl_invoice_payments.inv_id");
			$this->db->join('tbl_tenants', "tbl_tenants.ten_uid = tbl_invoice.inv_ten_uid");
			$this->db->where('tbl_tenants.ten_branch',$branch);
			$this->db->where('payment_status','success');
			$this->db->where('MONTH(payment_date)',date('m'));
			$return['thismonthincome'] = $this->db->get()->row()->payment_amnt;
		} else {
			$this->db->where('payment_status','success');
			$this->db->where('MONTH(payment_date)',date('m'));
			$return['thismonthincome'] = $this->db->get('tbl_invoice_payments')->row()->payment_amnt;
		}


		$this->db->select_sum('exp_amnt');
		$this->db->where('MONTH(exp_date)',date('m'));
		$return['thismonthexpense'] = $this->db->get('tbl_expenses')->row()->exp_amnt;


		return $return;
	}
	
	function getAllTenants($branch = '')
	{
		if(!empty($branch)) { $this->db->where('ten_branch',$branch); $this->db->or_where('ten_branch',''); }
		$query=$this->db->get("tbl_tenants");
		$rows = $query->result_array();
		
		foreach($rows as $rowid=>$tenant)
		{
			$this->db->where('room_uid', $tenant['ten_room']);
			$roomdetails=$this->db->get("tbl_rooms")->row_array();
			if(is_array($roomdetails) && count($roomdetails) > 0)
			{
				$rows[$rowid]['room'] = $roomdetails['room_name'];
			}
			else
			{
				$rows[$rowid]['room'] = 'N/A';
			}
			
			$this->db->where('bed_uid', $tenant['ten_bed']);
			$beddetails=$this->db->get("tbl_beds")->row_array();
			if(is_array($beddetails) && count($beddetails) > 0)
			{
				$rows[$rowid]['bed'] = $beddetails['bed_name'];
			}
			else
			{
				$rows[$rowid]['bed'] = 'N/A';
			}

			$branchdetails = $this->db->where('id',$tenant['ten_branch'])->get('tbl_branches')->row_array();
			if(is_array($branchdetails) && count($branchdetails) > 0) { $rows[$rowid]['branch'] = $branchdetails['branch_name']; } else { $rows[$rowid]['branch'] = 'N/A'; }
		}
		return $rows;
	}
	
	function getAllRooms($branch = '')
	{
		if(!empty($branch)) { $this->db->where('room_branch',$branch); }
		$query=$this->db->get("tbl_rooms");
		$rows = $query->result_array();
		foreach($rows as $rowid=>$room)
		{
			$this->db->where('bed_room', $room['room_uid']);
			$rows[$rowid]['allbeds']=$this->db->count_all_results('tbl_beds');
			
			$this->db->where('bed_room', $room['room_uid']);
			$this->db->where('bed_status', 0);
			$rows[$rowid]['avlbeds']=$this->db->count_all_results('tbl_beds');

			$branchdetails = $this->db->where('id',$room['room_branch'])->get('tbl_branches')->row_array();
			if(is_array($branchdetails) && count($branchdetails) > 0) { $rows[$rowid]['branch'] = $branchdetails['branch_name']; } else { $rows[$rowid]['branch'] = 'N/A'; }
		}
		return $rows;
	}

	function getAllBeds($branch = '')
	{
		$this->db->select('tbl_beds.*, tbl_rooms.room_name, tbl_rooms.room_details, tbl_rooms.room_price');
		$this->db->from('tbl_beds');
		$this->db->join('tbl_rooms', 'tbl_beds.bed_room = tbl_rooms.room_uid');
		if(!empty($branch)) { $this->db->where('tbl_rooms.room_branch',$branch); }
		$query = $this->db->get();
		$rows = $query->result_array();
		return $rows;
	}

	function getAllEs($branch = '')
	{
		if(!empty($branch)) { $this->db->where('es_branch',$branch); $this->db->or_where('es_branch',''); }
		$query=$this->db->get("tbl_extra_services");
		$rows = $query->result_array();
		foreach($rows as $esid=>$es)
		{
			$branchdetails = $this->db->where('id',$es['es_branch'])->get('tbl_branches')->row_array();
			if(is_array($branchdetails) && count($branchdetails) > 0) { $rows[$esid]['branch'] = $branchdetails['branch_name']; } else { $rows[$esid]['branch'] = 'N/A'; }
		}
		return $rows;
	}

	function getAllRequests($ten_uid = '')
	{
		if(!empty($ten_uid))
		{
			$this->db->where('request_ten_uid',$ten_uid);
		}
		$requests = $this->db->get('tbl_requests')->result_array();
		foreach($requests as $rid => $request)
		{
			if($request['request_type'] == 'BED')
			{
				$this->db->where('room_uid',$request['request_room_uid']);
				$room = $this->db->get('tbl_rooms')->row_array();
				$requests[$rid]['room'] = $room;

				$this->db->where('bed_uid',$request['request_bed_uid']);
				$bed = $this->db->get('tbl_beds')->row_array();
				$requests[$rid]['bed'] = $bed;
			}
			else if($request['request_type'] == 'EXTRA SERVICE')
			{
				$this->db->where('id',$request['request_es_uid']);
				$es = $this->db->get('tbl_extra_services')->row_array();
				$requests[$rid]['es'] = $es;
			}
		}

		return $requests;
	}

	function getAllInvoices($branch = '',$inv_status='',$tenant='')
	{
		$this->db->select('tbl_invoice.*, tbl_tenants.ten_name');
		$this->db->from('tbl_invoice');
		if(!empty($inv_status))
		{
			$this->db->where('inv_status !=',$inv_status);
		}
		if(!empty($tenant))
		{
			$this->db->where('inv_ten_uid',$tenant);
		}
		$this->db->join('tbl_tenants', 'tbl_invoice.inv_ten_uid = tbl_tenants.ten_uid');
		if(!empty($branch)) { $this->db->where('tbl_tenants.ten_branch',$branch); }
		$query=$this->db->get();
		$rows = $query->result_array();
		return $rows;
	}

	function getInvoice($inv_id)
	{
		$return['invoice']=$this->db->where('inv_id', $inv_id)->get("tbl_invoice")->row_array();
		$return['invoice_items']=$this->db->where('inv_id', $inv_id)->get("tbl_invoice_items")->result_array();
		$return['invoice_payments']=$this->db->where('inv_id', $inv_id)->get("tbl_invoice_payments")->result_array();
		$return['tenant_details']=$this->db->where('ten_uid', $return['invoice']['inv_ten_uid'])->get("tbl_tenants")->row_array();
		return $return;
	}
        
	function getLastTenant($col_offset)
	{
		$this->db->order_by($col_offset,'desc');
		$this->db->limit(1);
		$query=$this->db->get("tbl_tenants");
		$rows = $query->row_array();
		return $rows;
	}
	
	function getLastRoom($col_offset)
	{
		$this->db->order_by($col_offset,'desc');
		$this->db->limit(1);
		$query=$this->db->get("tbl_rooms");
		$rows = $query->row_array();
		return $rows;
	}

	function getLastBed($col_offset)
	{
		$this->db->order_by($col_offset,'desc');
		$this->db->limit(1);
		$query=$this->db->get("tbl_beds");
		$rows = $query->row_array();
		return $rows;
	}

	function delTenant($tenuid)
	{
		$this -> db -> where('ten_uid', $tenuid);
		$this -> db -> delete('tbl_tenants');
		$return = array('status'=>'success','msg'=>'');
		return $return;
	}

	function delRoom($roomid)
	{
		$this -> db -> where('room_uid', $roomid);
		$this -> db -> delete('tbl_rooms');
		$return = array('status'=>'success','msg'=>'');
		return $return;
	}

	function delBed($bedid)
	{
		$this -> db -> where('bed_uid', $bedid);
		$this -> db -> delete('tbl_beds');
		$return = array('status'=>'success','msg'=>'');
		return $return;
	}

	function delEs($esid)
	{
		$this -> db -> where('id', $esid);
		$this -> db -> delete('tbl_extra_services');
		$return = array('status'=>'success','msg'=>'');
		return $return;
	}

	function updateTenantData($tenuid)
	{
		if (null != ($_FILES['ten_photo_select']['tmp_name']))
		{
			$config['upload_path']          = './assets/usr_pics/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 5048;
			$config['encrypt_name'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 200;
			$config['height']   = 200;
			
			$this->load->library('upload', $config);
			
			$this->upload->do_upload('ten_photo_select');
			
			$uploaded=$this->upload->data();
			$tenant_photo_name = $uploaded['file_name'];
		}
		else if(!empty($_POST['ten_photo_webcam']))
		{
			$tenant_photo_name = html_escape($this->input->post('ten_photo_webcam'));
		}
		else
		{
			if($tenuid == 0)
			{
				$tenant_photo_name = 'default_avatar.png';
			}
			else
			{
				$tenant_photo_name = html_escape($this->input->post('ten_pic'));
			}
		}
		$date = date('Y-m-d H:i:s');

		$data=array(
			'ten_gender'=>html_escape($this->input->post('ten_gender')),
			'ten_dob'=>html_escape($this->input->post('ten_dob')),
			'ten_address'=>html_escape($this->input->post('ten_address')),
			'ten_contact'=>html_escape($this->input->post('ten_contact')),
			'ten_pic'=>$tenant_photo_name,
			'ten_tax_company_name'=>html_escape($this->input->post('ten_tax_company_name')),
			'ten_tax_company_email'=>html_escape($this->input->post('ten_tax_company_email')),
			'ten_tax_number'=>html_escape($this->input->post('ten_tax_number')),
			'ten_emc_name'=>html_escape($this->input->post('ten_emc_name')),
			'ten_emc_contact'=>html_escape($this->input->post('ten_emc_contact'))
		);

		$this->db->where('ten_uid',$tenuid);
		$this->db->update('tbl_tenants',$data);
	}
	
	function addTenant($tenuid,$newtenuid)
	{
		if (null != ($_FILES['ten_photo_select']['tmp_name']))
		{
			$config['upload_path']          = './assets/usr_pics/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 5048;
			$config['encrypt_name'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 200;
			$config['height']   = 200;
			
			$this->load->library('upload', $config);
			
			$this->upload->do_upload('ten_photo_select');
			
			$uploaded=$this->upload->data();
			$tenant_photo_name = $uploaded['file_name'];
		}
		else if(!empty($_POST['ten_photo_webcam']))
		{
			$tenant_photo_name = html_escape($this->input->post('ten_photo_webcam'));
		}
		else
		{
			if($tenuid == 0)
			{
				$tenant_photo_name = 'default_avatar.png';
			}
			else
			{
				$tenant_photo_name = html_escape($this->input->post('ten_pic'));
			}
		}
		$date = date('Y-m-d H:i:s');	
		
		$data=array(
			'ten_name'=>html_escape($this->input->post('ten_name')),
			'ten_email'=>html_escape($this->input->post('ten_email')),
			'ten_gender'=>html_escape($this->input->post('ten_gender')),
			'ten_dob'=>html_escape($this->input->post('ten_dob')),
			'ten_address'=>html_escape($this->input->post('ten_address')),
			'ten_contact'=>html_escape($this->input->post('ten_contact')),
			'ten_pic'=>$tenant_photo_name,
			'ten_tax_company_name'=>html_escape($this->input->post('ten_tax_company_name')),
			'ten_tax_company_email'=>html_escape($this->input->post('ten_tax_company_email')),
			'ten_tax_number'=>html_escape($this->input->post('ten_tax_number')),
			'ten_emc_name'=>html_escape($this->input->post('ten_emc_name')),
			'ten_emc_contact'=>html_escape($this->input->post('ten_emc_contact')),
			'ten_comments'=>html_escape($this->input->post('ten_comments')),
			'ten_add_date'=>$date,
			'ten_isactive'=>html_escape($this->input->post('ten_isactive')),
			'ten_branch'=>html_escape($this->input->post('ten_branch'))
		);
                
		if($tenuid == 0)
		{
			$data['ten_pass'] = md5(html_escape($this->input->post('ten_email')));
			$data['ten_uid'] = $newtenuid;
			$this->db->insert('tbl_tenants',$data);
		}
		else
		{
			$this->db->where('ten_uid',$tenuid);
			$this->db->update('tbl_tenants',$data);
		}
	}

	public function insertTransaction($data = array()){
        $insert = $this->db->insert('payments',$data);
        return $insert?true:false;
    }

	function getTenantDetails($tenuid)
	{
		$this->db->where("ten_uid",$tenuid);
		$query=$this->db->get("tbl_tenants");
		$rows = $query->row_array();

			$this->db->where('room_uid', $rows['ten_room']);
			$roomdetails=$this->db->get("tbl_rooms")->row_array();
			if(is_array($roomdetails) && count($roomdetails) > 0)
			{
				$rows['room'] = $roomdetails['room_name'];
			}
			else
			{
				$rows['room'] = 'N/A';
			}
			
			$this->db->where('bed_uid', $rows['ten_bed']);
			$beddetails=$this->db->get("tbl_beds")->row_array();
			if(is_array($beddetails) && count($beddetails) > 0)
			{
				$rows['bed'] = $beddetails['bed_name'];
			}
			else
			{
				$rows['bed'] = 'N/A';
			}

			$branchdetails = $this->db->where('id',$rows['ten_branch'])->get('tbl_branches')->row_array();
			if(is_array($branchdetails) && count($branchdetails) > 0) { $rows['branch'] = $branchdetails['branch_name']; } else { $rows['branch'] = 'N/A'; }
		return $rows;
	}

	function getTenantStats($tenuid)
	{
		$this->db->where('inv_ten_uid',$tenuid);
		$return['allinv'] = $this->db->count_all_results('tbl_invoice');

		$this->db->where('inv_ten_uid',$tenuid);
		$this->db->where('inv_status','PAID');
		$return['paidinv'] = $this->db->count_all_results('tbl_invoice');

		$this->db->where('inv_ten_uid',$tenuid);
		$this->db->where('inv_status !=','PAID');
		$return['upaidinv'] = $this->db->count_all_results('tbl_invoice');

		$this->db->where('ten_uid',$tenuid);
		$return['alles'] = $this->db->count_all_results('tbl_es_assign');

		$this->db->select_sum('inv_total');
		$this->db->where('inv_ten_uid',$tenuid);
		$this->db->where('inv_status','PAID');
		$return['paidamnt'] = $this->db->get('tbl_invoice')->row()->inv_total;

		$this->db->where('inv_ten_uid',$tenuid);
		$this->db->where('inv_status !=','PAID');
		$allunpaid = $this->db->get('tbl_invoice')->result_array();
		$allpaid = 0;
		foreach($allunpaid as $upinv)
		{
			$allpaid += $this->db->select_sum('payment_amnt')->where('inv_id',$upinv['inv_id'])->get('tbl_invoice_payments')->row()->payment_amnt;
		}
		$invtotal = array_sum(array_column($allunpaid,'inv_total'));
		$return['upaidamnt'] = $invtotal - $allpaid;

		return $return;
	}
	
	function addRoom($roomuid,$newroomuid)
	{
		$date = date('Y-m-d H:i:s');	
		
		$data=array(
			'room_name'=>html_escape($this->input->post('room_name')),
			'room_price'=>html_escape($this->input->post('room_price')),
			'room_details'=>html_escape($this->input->post('room_details')),
			'room_branch'=>html_escape($this->input->post('room_branch'))
		);
                
		if($roomuid == 0)
		{
			$data['room_uid'] = $newroomuid;
			$data['room_added'] = $date;
			$this->db->insert('tbl_rooms',$data);
		}
		else
		{
			$this->db->where('room_uid',$roomuid);
			$this->db->update('tbl_rooms',$data);
		}
	}
	
	function getRoomDetails($roomuid)
	{
		$this->db->where("room_uid",$roomuid);
		$query=$this->db->get("tbl_rooms");
		$rows = $query->row_array();
		return $rows;
	}

	function getBedDetails($beduid)
	{
		$this->db->where("bed_uid",$beduid);
		$query=$this->db->get("tbl_beds");
		$rows = $query->row_array();

		$this->db->where("room_uid",$rows['bed_room']);
		$query2=$this->db->get("tbl_rooms");
		$rrows = $query2->row_array();

		$rows['room_name'] = $rrows['room_name'];
		$rows['room_price'] = $rrows['room_price'];

		return $rows;
	}

	function getBedsForRoom($roomuid, $available = 0)
	{
		$this->db->where("bed_room",$roomuid);
		if($available == 1)
		{
			$this->db->where("bed_status",0);
		}
		$query=$this->db->get("tbl_beds");
		$rows = $query->result_array();
		return $rows;
	}

	function getEsDetails($esid)
	{
		$this->db->where("id",$esid);
		$query=$this->db->get("tbl_extra_services");
		$rows = $query->row_array();
		return $rows;
	}

	function rejectReq($reqid)
	{
		$date = date('Y-m-d H:i:s');

		$data = array(
			'request_status' => 'REJECTED',
			'request_update_date' => $date
		);

		$this->db->where('id',$reqid);
		$this->db->update('tbl_requests',$data);
	}

	function approveReq($reqid)
	{
		$date = date('Y-m-d H:i:s');

		$data = array(
			'request_status' => 'APPROVED',
			'request_update_date' => $date
		);

		$this->db->where('id',$reqid);
		$this->db->update('tbl_requests',$data);
	}


	function addBed($beduid,$newbeduid)
	{
		$date = date('Y-m-d H:i:s');	
		
		$data=array(
			'bed_name'=>html_escape($this->input->post('bed_name')),
			'bed_room'=>html_escape($this->input->post('bed_room')),
			'bed_details'=>html_escape($this->input->post('bed_details'))
		);
                
		if($beduid == 0)
		{
			$data['bed_uid'] = $newbeduid;
			$data['bed_added'] = $date;
			$data['bed_status'] = 0;
			$this->db->insert('tbl_beds',$data);
		}
		else
		{
			$this->db->where('bed_uid',$beduid);
			$this->db->update('tbl_beds',$data);
		}
	}

	function addEs($esid)
	{
		$date = date('Y-m-d H:i:s');	
		
		$data=array(
			'es_name'=>html_escape($this->input->post('es_name')),
			'es_price'=>html_escape($this->input->post('es_price')),
			'es_details'=>html_escape($this->input->post('es_details')),
			'es_branch'=>html_escape($this->input->post('es_branch'))
		);
                
		if($esid == 0)
		{
			$data['es_added_date'] = $date;
			$this->db->insert('tbl_extra_services',$data);
		}
		else
		{
			$this->db->where('id',$esid);
			$this->db->update('tbl_extra_services',$data);
		}
	}

	function retractBed($bed_uid)
	{
		$date = date('Y-m-d H:i:s');
		$dt = date('Y-m-d');

		$data_for_bs = array(
			'is_retrived' => 1,
			'retrived_on' => $date
		);

		$data_for_beds = array(
			'bed_status' => 0
		);

		$data_for_tenants = array(
			'ten_room' => '',
			'ten_bed' => ''
		);

		$this->db->trans_start();

			$this->db->where('bed_uid',$bed_uid);
			$this->db->update('tbl_beds',$data_for_beds);

			$this->db->where('ten_bed',$bed_uid);
			$this->db->update('tbl_tenants',$data_for_tenants);

			$this->db->where('bed_uid',$bed_uid);
			$this->db->where('is_retrived',1);
			$this->db->update('tbl_bed_assign',$data_for_bs);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			$return = array('status'=>'error','msg'=>'');
			return $return;
		}
		else
		{
			$return = array('status'=>'success','msg'=>'');
			return $return;
		}
	}

	function assignBed($beduid,$tax1,$tax2)
	{
		$date = date('Y-m-d H:i:s');
		$dt = date('Y-m-d');
		$room_name = html_escape($this->input->post('room_name'));
		$bed_name = html_escape($this->input->post('bed_name'));
		$bed_uid = html_escape($this->input->post('bed_uid'));
		$ten_uid = html_escape($this->input->post('assignbed_tenant'));

		$data_for_bs = array(
			'ten_uid' => html_escape($this->input->post('assignbed_tenant')),
			'room_uid' => html_escape($this->input->post('room_uid')),
			'bed_uid' => html_escape($this->input->post('bed_uid')),
			'total_amnt' => html_escape($this->input->post('total_amnt')),
			'lease_from' => html_escape($this->input->post('lease_from')),
			'lease_to' => html_escape($this->input->post('lease_to')),
			'assigned_on' => $date
		);

		$data_for_beds = array(
			'bed_status' => 1
		);

		$data_for_tenants = array(
			'ten_room' => html_escape($this->input->post('room_uid')),
			'ten_bed' => html_escape($this->input->post('bed_uid'))
		);

		$invoice_id = ($this->getLastInvoice('id') > 0) ? $this->inv_number($this->getLastInvoice('id')+1,5) : $this->inv_number(1,5);
		$baseamnt = html_escape($this->input->post('base_amnt'));

		$tax_per = html_escape($this->input->post('tax_per'));
		$tax2_per = html_escape($this->input->post('tax2_per'));

		$totalamnt = html_escape($this->input->post('total_amnt'));
		$paidamnt = html_escape($this->input->post('paid_amnt'));
		$balamnt = html_escape($this->input->post('bal_amnt'));
		
		if($paidamnt <= 0)
		{
			$inv_status = 'UNPAID';
		}
		else if($balamnt <= 0)
		{
			$inv_status = 'PAID';
		}
		else if($balamnt > 0)
		{
			$inv_status = 'PARTIALLY PAID';
		}
		else
		{
			$inv_status = 'PAID';	
		}

		$data_for_invoice = array(
			'inv_id' => $invoice_id,
			'inv_for' => 'Room / Bed Booking',
			'inv_status' => $inv_status,
			'inv_amnt' => $baseamnt,
			'inv_tax_per' => $tax_per,
			'inv_tax2_per' => $tax2_per,
			'inv_tax' => $tax1,
			'inv_tax2' => $tax2,
			'inv_total' => $totalamnt,
			'inv_ten_uid' => html_escape($this->input->post('assignbed_tenant')),
			'inv_created' => $dt
		);

		$data_for_invoice_item = array(
			'inv_id' => $invoice_id,
			'item_id' => abs( crc32( uniqid() ) ),
			'item_name' => 'Room / Bed Booking',
			'item_desc' => 'Room Name: '.$room_name.' | Bed Name: '.$bed_name,
			'item_price' => $baseamnt,
			'item_type' => 'Room / Bed',
			'item_added' => $dt
		);

		$data_for_invoice_payment = array(
			'inv_id' => $invoice_id,
			'payment_id' => abs( crc32( uniqid() ) ),
			'payment_method' => 'cash',
			'payment_trans_id' => md5(uniqid()),
			'payment_amnt' => $paidamnt,
			'payment_date' => $date,
			'payment_status' => 'success',
			'payment_details' => 'paid while booking'
		);

		$this->db->trans_start();

			$this->db->where('bed_uid',$bed_uid);
			$this->db->update('tbl_beds',$data_for_beds);

			$this->db->where('ten_uid',$ten_uid);
			$this->db->update('tbl_tenants',$data_for_tenants);

			$this->db->insert('tbl_bed_assign',$data_for_bs);

			$this->db->insert('tbl_invoice',$data_for_invoice);

			$this->db->insert('tbl_invoice_items',$data_for_invoice_item);

			if($paidamnt > 0)
			{
				$this->db->insert('tbl_invoice_payments',$data_for_invoice_payment);
			}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return array('status' => false);
		}
		else
		{
			return array('status' => true, 'inv_status' => $inv_status);
		}
	}


	function assignEs($esid,$tax1,$tax2)
	{
		$date = date('Y-m-d H:i:s');
		$dt = date('Y-m-d');
		$es_name = html_escape($this->input->post('es_name'));
		$es_details = html_escape($this->input->post('es_details'));
		$esid = html_escape($this->input->post('esid'));
		$ten_uid = html_escape($this->input->post('assignbed_tenant'));

		$data_for_es = array(
			'ten_uid' => html_escape($this->input->post('assignbed_tenant')),
			'es_id' => html_escape($this->input->post('esid')),
			'total_amnt' => html_escape($this->input->post('total_amnt')),
			'dt_from' => html_escape($this->input->post('lease_from')),
			'dt_to' => html_escape($this->input->post('lease_to')),
			'assigned_on' => $date
		);

		$invoice_id = ($this->getLastInvoice('id') > 0) ? $this->inv_number($this->getLastInvoice('id')+1,5) : $this->inv_number(1,5);
		$baseamnt = html_escape($this->input->post('base_amnt'));

		$tax_per = html_escape($this->input->post('tax_per'));
		$tax2_per = html_escape($this->input->post('tax2_per'));

		$totalamnt = html_escape($this->input->post('total_amnt'));
		$paidamnt = html_escape($this->input->post('paid_amnt'));
		$balamnt = html_escape($this->input->post('bal_amnt'));
		
		if($paidamnt <= 0)
		{
			$inv_status = 'UNPAID';
		}
		else if($balamnt <= 0)
		{
			$inv_status = 'PAID';
		}
		else if($balamnt > 0)
		{
			$inv_status = 'PARTIALLY PAID';
		}
		else
		{
			$inv_status = 'PAID';	
		}

		$data_for_invoice = array(
			'inv_id' => $invoice_id,
			'inv_for' => 'Extra Service Purchase',
			'inv_status' => $inv_status,
			'inv_amnt' => $baseamnt,
			'inv_tax_per' => $tax_per,
			'inv_tax2_per' => $tax2_per,
			'inv_tax' => $tax1,
			'inv_tax2' => $tax2,
			'inv_total' => $totalamnt,
			'inv_ten_uid' => html_escape($this->input->post('assignbed_tenant')),
			'inv_created' => $dt
		);

		$data_for_invoice_item = array(
			'inv_id' => $invoice_id,
			'item_id' => abs( crc32( uniqid() ) ),
			'item_name' => html_escape($this->input->post('es_name')),
			'item_desc' => html_escape($this->input->post('es_details')),
			'item_price' => $baseamnt,
			'item_type' => 'Extra Service',
			'item_added' => $dt
		);

		$data_for_invoice_payment = array(
			'inv_id' => $invoice_id,
			'payment_id' => abs( crc32( uniqid() ) ),
			'payment_method' => 'cash',
			'payment_trans_id' => md5(uniqid()),
			'payment_amnt' => $paidamnt,
			'payment_date' => $date,
			'payment_status' => 'success',
			'payment_details' => 'paid while booking'
		);

		$this->db->trans_start();

			$this->db->insert('tbl_es_assign',$data_for_es);

			$this->db->insert('tbl_invoice',$data_for_invoice);

			$this->db->insert('tbl_invoice_items',$data_for_invoice_item);

			if($paidamnt > 0)
			{
				$this->db->insert('tbl_invoice_payments',$data_for_invoice_payment);
			}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return array('status' => false);
		}
		else
		{
			return array('status' => true, 'inv_status' => $inv_status);
		}
	}

	function requestbed($ten_uid)
	{
		$date = date('Y-m-d H:i:s');

		$data = array(
			'request_type' => 'BED',
			'request_ten_uid' => $ten_uid,
			'request_bed_uid' => html_escape($this->input->post('bed_uid')),
			'request_room_uid' => html_escape($this->input->post('room_uid')),
			'request_create_date' => $date,
			'request_status' => 'PENDING'
		);
		$this->db->insert('tbl_requests',$data);
	}

	function requestes($ten_uid)
	{
		$date = date('Y-m-d H:i:s');

		$data = array(
			'request_type' => 'EXTRA SERVICE',
			'request_ten_uid' => $ten_uid,
			'request_es_uid' => html_escape($this->input->post('es_uid')),
			'request_create_date' => $date,
			'request_status' => 'PENDING'
		);
		$this->db->insert('tbl_requests',$data);
	}

	function createInvoice($tax1,$tax2)
	{
		$date = date('Y-m-d H:i:s');
		$dt = date('Y-m-d');
		$invid = html_escape($this->input->post('invoice'));
		$ten_uid = html_escape($this->input->post('assignbed_tenant'));
		$invoice = $this->getInvoice($invid);
		$inv_id = ($this->getLastInvoice('id') > 0) ? $this->inv_number($this->getLastInvoice('id')+1,5) : $this->inv_number(1,5);
		$baseamnt = html_escape($this->input->post('base_amnt'));

		$tax_per = html_escape($this->input->post('tax_per'));
		$tax2_per = html_escape($this->input->post('tax2_per'));

		$totalamnt = html_escape($this->input->post('total_amnt'));
		$paidamnt = html_escape($this->input->post('paid_amnt'));
		$balamnt = html_escape($this->input->post('bal_amnt'));

		if($paidamnt <= 0)
		{
			$inv_status = 'UNPAID';
		}
		else if($balamnt <= 0)
		{
			$inv_status = 'PAID';
		}
		else if($balamnt > 0)
		{
			$inv_status = 'PARTIALLY PAID';
		}
		else
		{
			$inv_status = 'PAID';	
		}

		unset($invoice['invoice']['id']);
		$invoice['invoice']['inv_id'] = $inv_id;
		$invoice['invoice']['inv_status'] = $inv_status;
		$invoice['invoice']['inv_amnt'] = $baseamnt;
		$invoice['invoice']['inv_tax_per'] = $tax_per;
		$invoice['invoice']['inv_tax2_per'] = $tax2_per;
		$invoice['invoice']['inv_tax'] = $tax1;
		$invoice['invoice']['inv_tax2'] = $tax2;
		$invoice['invoice']['inv_total'] = $totalamnt;
		$invoice['invoice']['inv_created'] = $dt;
		

		foreach($invoice['invoice_items'] as $id => $invitm)
		{
			unset($invoice['invoice_items'][$id]['id']);
			$invoice['invoice_items'][$id]['inv_id'] = $inv_id;
			$invoice['invoice_items'][$id]['item_price'] = $baseamnt;
			$invoice['invoice_items'][$id]['item_added'] = $dt;
		}

		$data_for_invoice_payment = array(
			'inv_id' => $inv_id,
			'payment_id' => abs( crc32( uniqid() ) ),
			'payment_method' => 'cash',
			'payment_trans_id' => md5(uniqid()),
			'payment_amnt' => $paidamnt,
			'payment_date' => $date,
			'payment_status' => 'success',
			'payment_details' => 'paid while booking'
		);

		$this->db->trans_start();

			$this->db->insert('tbl_invoice',$invoice['invoice']);

			$this->db->insert('tbl_invoice_items',$invoice['invoice_items'][0]);

			if($paidamnt > 0)
			{
				$this->db->insert('tbl_invoice_payments',$data_for_invoice_payment);
			}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}
		else
		{
			return true;
		}

	}

	function inv_number($value, $threshold = 2) {
		return sprintf('%0' . $threshold . 's', $value);
	}

	function getLastInvoice($col_offset)
	{
		$this->db->order_by($col_offset,'desc');
		$this->db->limit(1);
		$query=$this->db->get("tbl_invoice");
		$rows = $query->row()->$col_offset;
		return $rows;
	}

	function getPayments($branch='',$tenant='',$invoice='',$for='',$status='')
	{
		$this->db->select('tbl_invoice_payments.*,tbl_tenants.ten_name,tbl_invoice.inv_total');
		$this->db->from('tbl_invoice_payments');
		$this->db->join('tbl_invoice', 'tbl_invoice_payments.inv_id = tbl_invoice.inv_id');
		$this->db->join('tbl_tenants', 'tbl_invoice.inv_ten_uid = tbl_tenants.ten_uid');
		if(!empty($tenant))
		{
			$this->db->where('tbl_tenants.ten_uid',$tenant);
		}
		if(!empty($invoice))
		{
			$this->db->where('tbl_invoice.inv_id',$invoice);
		}
		if(!empty($for))
		{
			$this->db->where('tbl_invoice.inv_for',$for);
		}
		if(!empty($status))
		{
			$this->db->where('tbl_invoice.inv_status',$status);
		}
		if(!empty($branch)) { $this->db->where('tbl_tenants.ten_branch',$branch); }
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	function updatePayment($paydata,$paidamnt,$balamnt,$invoice)
	{
		$this->db->trans_start();
                
		$this->db->insert('tbl_invoice_payments',$paydata);

		if($paidamnt == $balamnt)
		{
			$data_for_invoice=array(
				'inv_status' => 'PAID'
			);
		}
		else
		{
			$data_for_invoice=array(
				'inv_status' => 'PARTIALLY PAID'
			);
		}

		$this->db->where('inv_id',$invoice);
		$this->db->update('tbl_invoice',$data_for_invoice);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			$return = array('status'=>'error','msg'=>'');
			return $return;
		}
		else
		{
			$return = array('status'=>'success','msg'=>'');
			return $return;
		}

	}

	function addPayment()
	{
		$date = date('Y-m-d H:i:s');	
		$invoice = html_escape($this->input->post('invoice'));

		$data_for_payments=array(
			'inv_id'=>html_escape($this->input->post('invoice')),
			'payment_id'=> abs( crc32( uniqid() ) ),
			'payment_method'=>html_escape($this->input->post('pay_method')),
			'payment_trans_id'=> (!empty(html_escape($this->input->post('trans_id')))) ? html_escape($this->input->post('trans_id')) : md5(uniqid()),
			'payment_amnt'=>html_escape($this->input->post('pay_amnt')),
			'payment_date'=>$date,
			'payment_status'=>'success',
			'payment_details'=>html_escape($this->input->post('pay_note'))
		);

		$this->db->trans_start();
                
		$this->db->insert('tbl_invoice_payments',$data_for_payments);

		if(html_escape($this->input->post('pay_amnt')) == html_escape($this->input->post('balance')))
		{
			$data_for_invoice=array(
				'inv_status' => 'PAID'
			);
		}
		else
		{
			$data_for_invoice=array(
				'inv_status' => 'PARTIALLY PAID'
			);
		}

		$this->db->where('inv_id',$invoice);
		$this->db->update('tbl_invoice',$data_for_invoice);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			$return = array('status'=>'error','msg'=>'');
			return $return;
		}
		else
		{
			$return = array('status'=>'success','msg'=>'');
			return $return;
		}

	}

	function retrievees($esid)
	{
		$date = date('Y-m-d H:i:s');

		$this->db->where('id',$esid);
		$tenuid = $this->db->get('tbl_es_assign')->row()->ten_uid;

		$data = array(
			'retrived_on' => $date
		);
		$this->db->where('id',$esid);
		$this->db->update('tbl_es_assign',$data);

		return $tenuid;
	}

	function updateConfig()
	{
		if (null != ($_FILES['ten_photo_select']['tmp_name']))
		{
			$config['upload_path']          = './assets/usr_pics/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 5048;
			$config['encrypt_name'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 200;
			$config['height']   = 200;
			
			$this->load->library('upload', $config);
			
			$this->upload->do_upload('ten_photo_select');
			
			$uploaded=$this->upload->data();
			$tenant_photo_name = $uploaded['file_name'];
		}
		else
		{
			$tenant_photo_name = html_escape($this->input->post('app_logo'));
		}

		foreach ($_POST as $key => $value) 
		{
			if($key != 'ten_photo_select')
			{
				$data = array(
					'opt_value' => html_escape($value)
				);
				if($key == 'app_logo')
				{
					$data['opt_value'] = $tenant_photo_name;
				}
				$this->db->where('opt_key',html_escape($key));
				$this->db->update('tbl_dhpms_options',$data);
			}
		}
	}

	function generateIncomeReport($branch = '')
	{
		$from_date = html_escape($this->input->post('from_date'));
		$to_date = html_escape($this->input->post('to_date'));

		$this->db->select('tbl_invoice_payments.*,tbl_tenants.ten_name,tbl_invoice.inv_id');
		$this->db->from('tbl_invoice_payments');
		$this->db->join('tbl_invoice', 'tbl_invoice_payments.inv_id = tbl_invoice.inv_id');
		$this->db->join('tbl_tenants', 'tbl_invoice.inv_ten_uid = tbl_tenants.ten_uid');
		if(!empty($branch)) { $this->db->where('tbl_tenants.ten_branch',$branch); }
		if(!empty($from_date))
		{
			$this->db->where('payment_date >=', $from_date);
		}
		if(!empty($to_date))
		{
			$this->db->where('payment_date <=', $to_date);
		}
		
		$return = $this->db->get()->result_array();
		return $return;
	}
	
	function generateExpenseReport()
	{
		$from_date = html_escape($this->input->post('from_date'));
		$to_date = html_escape($this->input->post('to_date'));

		$this->db->select('tbl_expenses.*,tbl_exp_cat.exp_cat_name');
		$this->db->from('tbl_expenses');
		$this->db->join('tbl_exp_cat', 'tbl_expenses.exp_category = tbl_exp_cat.id');

		if(!empty($from_date))
		{
			$this->db->where('exp_date >=', $from_date);
		}
		if(!empty($to_date))
		{
			$this->db->where('exp_date <=', $to_date);
		}
		
		$return = $this->db->get()->result_array();
		return $return;
	}
	
	public function chkemail($email_id)
	{
		$this->db->where('email', $email_id);

		$query = $this->db->get('users');
		$count_row = $query->num_rows();

		if ($count_row > 0) {
		return FALSE;
		} else {
		return TRUE;
		}
	}
}
?>