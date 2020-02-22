<?php
 
class Furuta_Erp_Adminhtml_LogController extends Mage_Adminhtml_Controller_Action {
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('sales/furutaerp');
    }

    public function indexAction() {
        $this->_title($this->__('Logs'))->_title("Furuta Erp Logs");
        $this->loadLayout();
        $this->_setActiveMenu('sales/sales');
        $this->_addContent($this->getLayout()->createBlock('furutaerp/adminhtml_log'));
        $this->renderLayout();
    }
 
    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('furutaerp/adminhtml_log_grid')->toHtml()
        );
    }
 
    public function exportInchooCsvAction() {
        $fileName = 'furutaerplog.csv';
        $grid = $this->getLayout()->createBlock('furutaerp/adminhtml_log_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
 
    public function exportInchooExcelAction() {
        $fileName = 'furutaerplog.xml';
        $grid = $this->getLayout()->createBlock('furutaerp/adminhtml_log_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    public function massResendAction() {
        $params = $this->getRequest()->getParams();
        foreach ($params["log_id"] as $key => $log_id) {
            $log = Mage::getModel("furutaerp/log")->load($log_id);
            Mage::getModel("furutaerp/connection")->resend($log);
        }
        $this->_redirect("*/*/index");
    }
}