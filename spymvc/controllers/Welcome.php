<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

function set_barcode($code,$height,$drawText)
{
	$this->load->library('zend');
	$this->zend->load('Zend/Barcode');
	$drawText = ($drawText != 1) ? FALSE : TRUE;
	$barcodeOptions = array('text' => $code, 'barHeight' => $height, 'drawText' => $drawText);
	$rendererOptions = array('imageType' => 'png', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle');
	Zend_Barcode::render('code128', 'image', $barcodeOptions, $rendererOptions);
}

function set_qrcode($data,$level,$size)
{
	$this->load->library('ciqrcode');
	$params['data'] = $data;
	$params['level'] = $level;
	$params['size'] = $size;
	$this->ciqrcode->generate($params);
}
	
	public function index()
	{
		$this->load->view('welcome_message');
		$temp = rand(10000, 99999);
        //$this->set_barcode($temp,50,1);
	}
}
