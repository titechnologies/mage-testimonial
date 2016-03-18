<?php
/**
 * Titech Testimonial Module
 *
 * @category    Titech
 * @package     Titech_Testimonials
 * @copyright   Copyright (c) 2015 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */
 
class Titech_Testimonials_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('testimonials/set_time');
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->getLayout()->getBlock('head')->setTitle('Manage Testimonials');
		$this->renderLayout();
        
    }
    
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function editAction()
    {
		$this->_initAction();
		
        $testimonialId 	= $this->getRequest()->getParam('id');
        $testimonial 	= Mage::getModel('testimonials/testimonial')->load($testimonialId);

        if ($testimonial->getId() || $testimonialId == 0) {
            Mage::register('testimonial_data', $testimonial);
			$this->loadLayout();
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonial_edit'));
             $this->renderLayout();
        } else {
             Mage::getSingleton('adminhtml/session')->addError('Testimonial does not exist');
             $this->_redirect('*/*/');
        }
    }
    
	public function newAction() 
	{
        $this->_forward('edit');
    }
    
    public function saveAction() 
    {
        if ($data = $this->getRequest()->getPost()) {
			try {
				$model = Mage::getModel('testimonials/testimonial');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				$model->setModifiedDate(Mage::getModel('core/date')->date('Y-m-d H:i:s'));
				$model->save();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
        } else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Unable to find item to save'));
			$this->_redirect('*/*/');
        }
    }
	
    public function deleteAction()
	{
		if($this->getRequest()->getParam('id') > 0) {
			try {
				$testimonialModel = Mage::getModel('testimonials/testimonial');
				$testimonialModel->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess('successfully deleted');
				$this->_redirect('*/*/');
			 }
			catch (Exception $e) {
				   Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				   $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	public function massDeleteAction() 
	{
        $testimonialIds = $this->getRequest()->getParam('testimonialIds');
        if(!is_array($testimonialIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($testimonialIds as $testimonialId) {
                    $testimonialModel = Mage::getModel('testimonials/testimonial')->load($testimonialId);
                    $testimonialModel->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($testimonialIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }
}


