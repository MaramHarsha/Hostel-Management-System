<?php

function calcTax($baseamnt,$taxper)
{
    $taxamnt = ($taxper / 100) * $baseamnt;
    return $taxamnt;
}

function amnt($amnt=0)
{
    $amnt = number_format($amnt,2);
    return $amnt;    
}

function sendMail($fromemail,$fromname,$toemail,$subject,$content)
{
    $CI =& get_instance();
    $CI->load->library('email');
    $CI->load->database();
    $optionsres = $CI->db->get('tbl_dhpms_options')->result_array();
    $dhpop = array();
    foreach ($optionsres as $row)
    {
            $dhpop[$row['opt_key']] = $row['opt_value'];
    }

    $config = array();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = $dhpop['smtp_host'];
    $config['smtp_user'] = $dhpop['smtp_username'];
    $config['smtp_pass'] = $dhpop['smtp_pass'];
    $config['smtp_port'] = $dhpop['smtp_port'];
    $config['mailtype'] = 'html';
    //$config['smtp_crypto'] = 'ssl';
    $CI->email->initialize($config);
    //$CI->email->set_mailtype("html");
    $CI->email->from($fromemail, $fromname);
    $CI->email->to($toemail);
    $CI->email->subject($subject);
    $CI->email->message($content);

    if($CI->email->send()) { return true; } else { return false; }
}

function getEmailTemplate($tplkey)
{
    $CI =& get_instance();
    $CI->load->database();
    $CI->db->where('email_tpl_name',$tplkey);
    return $CI->db->get('tbl_email_templates')->row()->email_tpl_content;
}

function slug($text)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
}

function cursym()
{
    $CI = &get_instance();
    $CI->load->library('session');
    $CI->load->database();
    $optionsres = $CI->db->get('tbl_dhpms_options')->result_array();
    $dhpop = array();
    foreach ($optionsres as $row)
    {
            $dhpop[$row['opt_key']] = $row['opt_value'];
    }
    $userd = $CI->session->userdata;
    $branch = (isset($userd['branch'])) ? $CI->db->where("id",$userd['branch'])->get("tbl_branches")->row_array() : '';

    if(!empty($branch))
    {
        return (!empty($branch['branch_currency_symbol'])) ? $branch['branch_currency_symbol'] : $dhpop['currency_symbol'];
    }
    else
    {
        return $dhpop['currency_symbol'];
    }
}