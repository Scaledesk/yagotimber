<?php
/*
 * Make sure the upgrade is not performed on installations without the tables
 * (i.e. unpatched shops).
 */
$adminVersion = Mage::getConfig()->getModuleConfig('Mage_Admin')->version;
if (version_compare($adminVersion, '1.6.1.2', '>=')) {

    $blockNames = array(
        'cms/block',
        'catalog/product_list',
        'blogmate/index'
    );
    foreach ($blockNames as $blockName) {
        $whitelistBlock = Mage::getModel('admin/block')->load($blockName, 'block_name');
        $whitelistBlock->setData('block_name', $blockName);
        $whitelistBlock->setData('is_allowed', 1);
        $whitelistBlock->save();
    }
}
