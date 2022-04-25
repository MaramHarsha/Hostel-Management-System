<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payumoney 
{
	protected $p_key = "JBZaLc"; //Your Merchant Key Here
	protected $p_salt = "GQs7yium"; //Your Salt Here
	protected $p_type = "DEV"; //DEV for testing/developemtn purpose | LIVE for make it live
	
	public function __construct()
	{
		
	}
	
	function makePayment($posted)
	{
		if($this->p_type == "DEV") $PAYU_BASE_URL="https://test.payu.in"; else $PAYU_BASE_URL="https://secure.payu.in";
		if(empty($posted['txnid'])) {
		// Generate random transaction id
			$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		} else {
			$txnid = $posted['txnid'];
		}
		
		$hash = '';
		// Hash Sequence
		if(empty($posted['hash']) && sizeof($posted) > 0) {
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		$hashVarsSeq = explode('|', $hashSequence);
		$hash_string = '';	
		foreach($hashVarsSeq as $hash_var) {
		  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
		  $hash_string .= '|';
		}
		$hash_string .= $this->p_salt;
		$hash = strtolower(hash('sha512', $hash_string));
		$action = $PAYU_BASE_URL . '/_payment';
		}
		elseif(!empty($posted['hash'])) {
		  $hash = $posted['hash'];
		  $action = $PAYU_BASE_URL . '/_payment';
		}
	}
}