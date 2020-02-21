<?php
class Furuta_Erp_Block_Adminhtml_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	public function render(Varien_Object $row) {
		$value =  $row->getData($this->getColumn()->getIndex());
		$options = Mage::getModel('furutaerp/log')->getStatusOptions();
		if($value) {
			return '<span style="color: green;font-weight: bold;">'.$options[$value].'</span>';
		} else {
			return '<span style="color: red;font-weight: bold;">'.$options[$value].'</span>';
		}
	}
}