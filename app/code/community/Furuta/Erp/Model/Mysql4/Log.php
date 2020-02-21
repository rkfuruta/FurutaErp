<?php
class Furuta_Erp_Model_Mysql4_Log extends Mage_Core_Model_Mysql4_Abstract {
    public function _construct() {
        $this->_init('furutaerp/log','log_id');
    }
}