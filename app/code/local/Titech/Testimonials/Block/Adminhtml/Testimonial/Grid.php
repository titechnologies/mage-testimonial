<?php
/**
 * Titech Testimonial Module
 *
 * @category    Titech
 * @package     Titech_Testimonials
 * @copyright   Copyright (c) 2015 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */
 
class Titech_Testimonials_Block_Adminhtml_Testimonial_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('testimonialGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('id');
        $this->setSaveParametersInSession(true);
    }
    
	public function customerNameFilter($collection, $column){
		$filterValue = $column->getFilter()->getValue();
		if(!is_null($filterValue)){
			$filterValue 	= trim($filterValue);
			$filterValue 	= preg_replace('/[\s]+/', ' ', $filterValue);
	 
			$whereArr 		= array();
			$whereArr[] 	= $collection->getConnection()->quoteInto('cusFirstnameTb.value LIKE "%'.$filterValue.'%"');
			$whereArr[] 	= $collection->getConnection()->quoteInto('cusLastnameTb.value LIKE "%'.$filterValue.'%"');
			$whereArr[] 	= $collection->getConnection()->quoteInto('CONCAT(cusFirstnameTb.value, " ", cusLastnameTb.value) LIKE "%'.$filterValue.'%"');
			$where 			= implode(' OR ', $whereArr);
			$collection->getSelect()->where($where);
		}
	}
	
    protected function _prepareCollection()
    {
		
        $collection = Mage::getModel('testimonials/testimonial')->getCollection();
						
		$customerFirstNameAttr = Mage::getSingleton('customer/customer')->getResource()->getAttribute('firstname');
		$customerLastNameAttr = Mage::getSingleton('customer/customer')->getResource()->getAttribute('lastname');
		$collection->getSelect()
							->join(
								array('cusFirstnameTb' => $customerFirstNameAttr->getBackend()->getTable()),
								'main_table.customer_id = cusFirstnameTb.entity_id AND cusFirstnameTb.attribute_id = '.$customerFirstNameAttr->getId(). ' AND cusFirstnameTb.entity_type_id = '.Mage::getSingleton('customer/customer')->getResource()->getTypeId(),
								array('cusFirstnameTb.value')
							);   
			 
		$collection->getSelect()
							->join(
								array('cusLastnameTb' => $customerLastNameAttr->getBackend()->getTable()),
								'main_table.customer_id = cusLastnameTb.entity_id AND cusLastnameTb.attribute_id = '.$customerLastNameAttr->getId(). ' AND cusLastnameTb.entity_type_id = '.Mage::getSingleton('customer/customer')->getResource()->getTypeId(),
								array('customer_name' => "CONCAT(cusFirstnameTb.value, ' ', cusLastnameTb.value)")
								);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('testimonials')->__('ID'),
            'index'     => 'id',
            'type'      => 'number',
            'filter_index' => 'main_table.id',
        ));
        
        $this->addColumn('subject', array(
			'header'    => Mage::helper('testimonials')->__('Subject'),
			'align'     =>'left',
			'index'     => 'subject', 
        ));

        $this->addColumn('customer_name', array(
            'header'    => Mage::helper('testimonials')->__('Customer'),
            'index'     => 'customer_name',
            'filter_condition_callback' => array($this, 'customerNameFilter'),
        ));
   
		$this->addColumn('description', array(
			'header'    => Mage::helper('testimonials')->__('Description'),
			'align'     =>'left',
			'index'     => 'description',
              
        ));
        
        $this->addColumn('created_date', array(
            'header'    => Mage::helper('testimonials')->__('Created Date'),
            'index'     => 'created_date',
            'filter_index' => 'main_table.created_date',
            'type'      => 'datetime',
        ));
        
        $this->addColumn('modified_date', array(
            'header'    => Mage::helper('testimonials')->__('Modified Date'),
            'index'     => 'modified_date',
            'type'      => 'datetime',
        ));
        
		$this->addColumn('action', array(
			'header'    =>  Mage::helper('testimonials')->__('Action'),
			'type'      => 'action',
			'getter'    => 'getId',
			'actions'   => array(
				array(
					'caption'   => Mage::helper('testimonials')->__('Edit'),
					'url'       => array('base'=> '*/*/edit'),
					'field'     => 'id'
				)
			),
			'filter'    => false,
			'sortable'  => false,
			'index'     => 'id',
			'is_system' => true,
		));

        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction(){
		
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('testimonialIds');
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('testimonials')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'), 
             'confirm'  => Mage::helper('testimonials')->__('Are you sure?')
        ));

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    
    public function getRowUrl($row)
    {
         return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
?>
