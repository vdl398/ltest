<?php

namespace App\Models\Helpers;


class Result
{
	
	protected $status = true;
	protected $errors = [];
	
	public function setSuccess() {
		$this->status = true;
	}
	
	public function addError($data) {
		$this->status = false;
		$this->errors[] = $data;
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	public function isSuccess() {
		return $this->status;
	}
	
	
}