<?php
/**
 * Titech Testimonial Module
 *
 * @category    Titech
 * @package     Titech_Testimonials
 * @copyright   Copyright (c) 2015 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Titech_Testimonials_Block_Adminhtml_Testimonial_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId 		= 'id';
        $this->_blockGroup 		= 'testimonials';
        $this->_controller 		= 'adminhtml_testimonial';
        $this->_mode 			= 'edit';
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";

    }
    
    public function _prepareLayout() 
	{
		$this->getLayout()->getBlock('head')->setTitle('Edit Testimonial');
		return parent::_prepareLayout();
	}

    public function getHeaderText()
    {
        if (Mage::registry('testimonial_data')->getId()) {
            return $this->escapeHtml('Edit Testimonial');
        }
    }
}
