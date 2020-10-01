<?php
include "model/model.php";
class controller{
	public $model;
	function __construct(){
		$this->model = new model();
	}
	function otp($nomor){
		$this->model->otptsel($nomor); 
	}
	
	function login($nomor,$kode){
		$msisdn = $nomor;
		$otp = $kode;
		$token = $this->model->generate($msisdn,$otp);
		$this->model->login($token);
		$promottoken = $this->model->patchtsel($msisdn,$token);	
		return $promottoken;
	}

	function buy($id,$promottoken){
		$this->model->belipaket($id,$promottoken);
	}
}

?>