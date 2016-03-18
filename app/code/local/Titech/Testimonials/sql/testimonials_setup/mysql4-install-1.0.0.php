<?php
$this->startSetup();
$this->run(
			"CREATE TABLE IF NOT EXISTS `{$this->getTable('testimonials/testimonial')}` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `customer_id` int(11) NOT NULL,
			  `subject` varchar(500) NOT NULL,
			  `description` text NOT NULL,
			  `created_date` datetime NOT NULL,
			  `modified_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
		);
$this->endSetup();
