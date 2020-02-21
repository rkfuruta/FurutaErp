<?php
class Furuta_Erp_Model_Log extends Mage_Core_Model_Abstract {
    protected function _construct() {
        $this->_init("furutaerp/log");
    }

    public function getStatusOptions() {
    	return array(
    		0	=> "Erro",
    		1	=> "Enviado",
    	);
    }

    public function save() {
    	$now = new DateTime();
    	$this->setUpdatedAt($now->format("Y-m-d H:i:s"));
    	return parent::save();
    }
}