<?php
class Furuta_Erp_Model_Mysql4_Log_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    public function _construct() {
        $this->_init('furutaerp/log');
    }
}