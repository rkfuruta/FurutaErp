<?php
 
class Furuta_Erp_Block_Adminhtml_Log_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('furutaerp_log_grid');
        $this->setDefaultSort('log_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection() {
        $collection = Mage::getModel("furutaerp/log")->getCollection();
 
        $collection->getSelect()->joinLeft(
            array('order_table' => $collection->getTable("sales/order")),
            'main_table.order_id = order_table.entity_id',
            array('increment_id')
        );

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
 
    protected function _prepareColumns() {
 
        $this->addColumn('log_id', array(
            'header' => 'ID',
            'index'  => 'log_id',
            'width'  => '50px',
        ));

        $this->addColumn('order_id', array(
            'header'  => 'Order',
            'index'   => 'increment_id',
            'renderer'=> 'furutaerp/adminhtml_renderer_order',
            'width'   => '50px',
        ));

        $this->addColumn('updated_at', array(
            'header'  => 'Updated at',
            'index'   => 'updated_at',
            'type'    => 'datetime',
            'width'   => '50px',
        ));

        $this->addColumn('created_at', array(
            'header'  => 'Created at',
            'index'   => 'created_at',
            'type'    => 'datetime',
            'width'  => '50px',
        ));

        $this->addColumn('status', array(
            'header'  => 'Status',
            'index'   => 'status',
            'type'    => 'options',
            'options' => Mage::getModel('furutaerp/log')->getStatusOptions(),
            'renderer'=> 'furutaerp/adminhtml_renderer_status',
            'align'   => 'center',
            'width'   => '50px',
        ));
 
        $this->addExportType('*/*/exportInchooCsv', 'CSV');
        $this->addExportType('*/*/exportInchooExcel', 'Excel XML');
 
        return parent::_prepareColumns();
    }
 
    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    protected function _prepareMassaction()
{
    $this->setMassactionIdField('log_id');
    $this->getMassactionBlock()->setFormFieldName('log_id');

    $this->getMassactionBlock()->addItem('delete', array(
         'label'    => 'Resend',
         'url'      => $this->getUrl('*/*/massResend'),
         'confirm'  => 'Are you sure?'
    ));

    return $this;
}
}