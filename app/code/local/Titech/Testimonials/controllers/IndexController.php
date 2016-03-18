<?php
/**
 * Titech Testimonial Module
 *
 * @category    Titech
 * @package     Titech_Testimonials
 * @copyright   Copyright (c) 2015 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */
 
class Titech_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setTitle('Testimonials');
		$this->renderLayout();
	}
    
    public function createAction()
	{
		if(!Mage::getSingleton('customer/session')->isLoggedIn()){
			Mage::getSingleton('core/session')->addError('Login to Create Testimonial');
			$this->_redirect('customer/account/login');
			return;
		}
		
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setTitle('Create Testimonial');
		$this->renderLayout();
	}
	
	public function saveAction()
	{
		if(!Mage::getSingleton('customer/session')->isLoggedIn()){
			Mage::getSingleton('core/session')->addError('Login to Create Testimonial');
			$this->_redirect('customer/account/login');
			return;
		}

		$customer 			= Mage::getSingleton('customer/session')->getCustomer();
		$testimonialData 	= $this->getRequest()->getParams();
		try {
			$tsetimonial 	= Mage::getModel('testimonials/testimonial')
									->setCustomerId($customer->getId())
									->setSubject($testimonialData['subject'])
									->setDescription($testimonialData['description'])
									->setCreatedDate(Mage::getModel('core/date')->date('Y-m-d H:i:s'))
									->setModifiedDate(Mage::getModel('core/date')->date('Y-m-d H:i:s'))
									->save();
			Mage::getSingleton('core/session')->addSuccess('Successfully created Testimonial');
		} catch(Exception $e) {
			Mage::getSingleton('core/session')->addError('Failed to save Testimonial');
		}
									
		$this->_redirect('*/*/');
		return;
	}
}
