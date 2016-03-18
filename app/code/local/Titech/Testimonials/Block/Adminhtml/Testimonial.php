<?php
/**
 * Titech Testimonial Module
 *
 * @category    Titech
 * @package     Titech_Testimonials
 * @copyright   Copyright (c) 2015 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */
 
class Titech_Testimonials_Block_Adminhtml_Testimonial extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
         $this->_controller = 'adminhtml_testimonial';
         $this->_blockGroup = 'testimonials';
         $this->_headerText = Mage::helper('testimonials')->__('Manage Testimonials');

         parent::__construct();
         
         $this->_removeButton('add');
     }
}
?>
