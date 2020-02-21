<?php

class Furuta_Erp_Model_Connection {
	protected $log_file = "FurutaErp.log";

	public function send(Mage_Sales_Model_Order $order) {
		$info = $this->getData($order);
		if(Mage::getStoreConfigFlag("furutaerp/settings/debug")) {
			Mage::log("Order: ".$order->getIncrementId(), null, $this->log_file, true);
			Mage::log($info, null, $this->log_file, true);
		}
		$request = Mage::getModel("furutaerp/request");
		$result = $request->setUrl(Mage::getStoreConfig("furutaerp/settings/endpoint"))
					->setHeader(array(
						"Authorization: Bearer ".Mage::getStoreConfig("furutaerp/settings/api_key")
					))
					->setParams($info)
					->post();
		if(Mage::getStoreConfigFlag("furutaerp/settings/debug")) {
			if($request->getHttpCode() == 200) {
				Mage::log("Status: Enviado", null, $this->log_file, true);
			} else {
				Mage::log("Status: Erro", null, $this->log_file, true);
			}
		}
	}

	protected function getData($order) {
		return array_merge(array(
			"customer"			=> $this->getCustomerData($order),
			"shipping_address"	=> $this->getShippingData($order),
			"items"				=> $this->getItemsData($order),

		), $this->getOrderData($order));
	}

	protected function getOrderData($order) {
		$data = array(
			"shipping_method"		=> $order->getShippingMethod(),
		    "payment_method"		=> $order->getPayment()->getMethod(),
		    "subtotal"				=> $order->getSubtotal(),
		    "shipping_amount"		=> $order->getShippingAmount(),
		    "discount"				=> $order->getDiscountAmount(),
		    "total"					=> $order->getGrandTotal(),
		);
		$additional_information = unserialize($order->getPayment()->getAdditionalInformation());
		if(isset($additional_information["installments"])) {
			$data = array_merge($data, array(
				"payment_installments"	=> $additional_information["installments"],
			));
		}
		return $data;
	}

	protected function getCustomerData($order) {
		$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
		$data = array(
			"name"			=> $customer->getFirstname()." ".$customer->getMiddlename()." ".$customer->getLastname(),
	        "telephone"		=> $order->getShippingAddress()->getTelephone(),
		);
		if($customer->getType() == 'PJ') { // O campo type não existe no customer - precisaria de implementacao para adicionar
			$data = array_merge($data, array(
		        "cnpj"			=> $customer->getCnpj(), // O campo cnpj não existe no customer (poderia ser usado o taxvat) - precisaria de implementacao para adicionar 
		        "razao_social"	=> $customer->getRazaoSocial(), // O campo razao social não existe no customer - precisaria de implementacao para adicionar
		        "nome_fantasia"	=> $customer->getNomeFantasia(), // O campo nome fantasia não existe no customer - precisaria de implementacao para adicionar
		        "ie"			=> $customer->getIe(), // O campo ie não existe no customer - precisaria de implementacao para adicionar
		    ));
		} else {
			$dob = "";
			if($customer->getDob()) {
				$dob = new DateTime($customer->getDob());
				if($dob) {
					$dob = $dob->format("d/m/Y");
				} else {
					$dob = $customer->getDob();
				}
			}
			$data = array_merge($data, array(
		        "cpf_cnpj"	=> $customer->getTaxvat(),
		        "dob"		=> $dob,
			));
		}
		return $data;
	}

	protected function getShippingData($order) {
		$shipping = $order->getShippingAddress();
		$street = $shipping->getStreet();
		return array(
			"street"			=> $street[0],
	        "number"			=> $street[1],
	        "additional"		=> $street[2],
	        "neighborhood"		=> $street[3],
	        "city"				=> $shipping->getCity(),
	        "city_ibge_code"	=> $shipping->getCityIbgeCode(), // Precisa implementar a funcao para identificar as cidades BR e seus codigos e adicionar nos dados de shipping
	        "uf"				=> $shipping->getRegion(),
	        "country"			=> $shipping->getCountryId(),
		);
	}

	protected function getItemsData($order) {
		$items = array();
		foreach ($order->getAllItems() as $item) {
			$items[] = array(
				"sku"	=> $item->getSku(),
	            "name"	=> $item->getName(),
	            "price"	=> $item->getPrice(),
	            "qty"	=> $item->getQtyOrdered(),
			);
		}
		return $items;
	}
}