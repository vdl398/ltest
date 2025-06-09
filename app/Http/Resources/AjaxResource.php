<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AjaxResource extends JsonResource
{

	protected array $data = [];
	protected $status = 'success';
	protected $errors = [];

    public function __construct()
    {
    }

    public function toArray($request)
    {
		return array_merge($this->data, [
			'status' => $this->status,
			'errors' => $this->errors,
		]);
    }
	
    public function setData(array $data = [])
    {
		$this->data = array_merge($this->data, $data);
    }
	
    public function setSuccess()
    {
		$this->status = 'success';
    }
	
    public function sendSuccess(array $data = [])
    {
		$this->setData($data);
		$this->setSuccess();
		return $this;
    }
	
    public function setError(array $errors = [])
    {
		$this->errors = array_merge($this->errors, $errors);
		$this->status = 'error';
    }
	
    public function sendError(array $errors = [])
    {
		$this->setError($errors);
		return $this;
    }
	
}
