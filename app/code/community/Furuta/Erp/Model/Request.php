<?php

class Furuta_Erp_Model_Request {

	protected $params;
	protected $url;
	protected $timeout;
	protected $header;
	protected $http_code;

	public function __construct() {
		$timeout = Mage::getStoreConfig("furutaerp/settings/timeout");
	}

	public function setParams($params) {
		$this->params = $params;
		return $this;
	}

	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}

	public function setHeader($header) {
		$this->header = $header;
		return $this;
	}

	public function getHttpCode() {
		return $this->http_code;
	}

	public function post() { 
		$params = (is_array($this->params))? json_encode($this->params) : $this->params;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout); 
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		if($this->header) curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

		$result = curl_exec($ch);
		$this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);
		return $result;
	}

}