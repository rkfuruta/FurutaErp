<?php
class Furuta_Erp_Block_Adminhtml_Renderer_Order extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	public function render(Varien_Object $row) {
		$increment_id =  $row->getData($this->getColumn()->getIndex());
		$order = Mage::getModel("sales/order")->load($increment_id, "increment_id");
		$link = Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/view", array('order_id' => $order->getId()));
		return "<a href=\"$link\" target=\"_blank\">".$increment_id."</a>";
	}
}