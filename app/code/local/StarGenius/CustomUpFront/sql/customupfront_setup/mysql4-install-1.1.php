<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute("order", "upfront_payment_field", array("type"=>"varchar"));
$installer->addAttribute("quote", "upfront_payment_field", array("type"=>"varchar"));
$installer->endSetup();