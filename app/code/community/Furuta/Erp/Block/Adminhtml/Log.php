<?php
 
class Furuta_Erp_Block_Adminhtml_Log extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_blockGroup = "furutaerp";
        $this->_controller = "adminhtml_log";
        $this->_headerText = "Furuta Erp Logs";
 
        parent::__construct();
        $this->_removeButton('add');
    }
}