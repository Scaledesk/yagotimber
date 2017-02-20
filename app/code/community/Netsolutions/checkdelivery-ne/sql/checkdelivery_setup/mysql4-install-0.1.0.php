<?php
$installer = $this;
$installer->startSetup();
$installer->run("DROP TABLE IF EXISTS {$this->getTable('checkdelivery')};
CREATE TABLE {$this->getTable('checkdelivery')} (
			`checkdelivery_id` int(11) unsigned NOT NULL auto_increment,
			`sku` varchar(255) NOT NULL,
			`zipcode` varchar(255) NOT NULL default '',
			 PRIMARY KEY (`checkdelivery_id`)
				) Engine = InnoDB DEFAULT CHARSET=utf8;
			");
$installer->endSetup();
?>
