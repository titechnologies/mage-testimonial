<?php
/**
 * Titech Testimonial Module
 *
 * @category    Titech
 * @package     Titech_Testimonials
 * @copyright   Copyright (c) 2015 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */
 
class Titech_Testimonials_Model_Testimonial extends Mage_Core_Model_Abstract
{
    public function _construct(){
        parent::_construct();
        $this->_init('testimonials/testimonial');
    }
}
