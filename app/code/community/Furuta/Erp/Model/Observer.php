<?php

class Furuta_Erp_Model_Observer {
	public function send_order(Varien_Event_Observer $observer) {
		if(Mage::getStoreConfigFlag("furutaerp/settings/active")) {
			$order = $observer->getEvent()->getOrder();
			Mage::getModel("furutaerp/connection")->send($order);
		}
	}
}