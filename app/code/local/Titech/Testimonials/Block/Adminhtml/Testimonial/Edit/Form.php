<?php
/**
 * Titech Testimonial Module
 *
 * @category    Titech
 * @package     Titech_Testimonials
 * @copyright   Copyright (c) 2015 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */
 
class Titech_Testimonials_Block_Adminhtml_Testimonial_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
    {

        $form = new Varien_Data_Form(array(
                                            'id' => 'edit_form',
                                            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                            'method' => 'post',
                                        )
                                    );
        $form->setUseContainer(true);
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('edit_form', array('legend'=>Mage::helper('testimonials')->__('Testimonial Details')));
      
        $fieldset->addField('subject', 'text',
                       array(
                          'label' => Mage::helper('testimonials')->__('Subject'),
                          'class' => 'required-entry',
                          'required' => true,
                          'name' => 'subject',
                    ));
        $fieldset->addField('description', 'textarea',
                       array(
                          'label' => Mage::helper('testimonials')->__('Description'),
                          'class' => 'required-entry',
                          'required' => true,
                          'name' => 'description',
                    ));         
  
		if ( Mage::registry('testimonial_data') ) {
				$form->setValues(Mage::registry('testimonial_data')->getData());
		}        

        return parent::_prepareForm();
    }
}
