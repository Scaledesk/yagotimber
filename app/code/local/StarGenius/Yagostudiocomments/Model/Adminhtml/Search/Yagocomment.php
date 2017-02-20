<?php
/**
 * StarGenius_Yagostudiocomments extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_Yagostudiocomments
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Admin search model
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudiocomments
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudiocomments_Model_Adminhtml_Search_Yagocomment extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return StarGenius_Yagostudiocomments_Model_Adminhtml_Search_Yagocomment
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('stargenius_yagostudiocomments/yagocomment_collection')
            ->addFieldToFilter('customer_email', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $yagocomment) {
            $arr[] = array(
                'id'          => 'yagocomment/1/'.$yagocomment->getId(),
                'type'        => Mage::helper('stargenius_yagostudiocomments')->__('YagoComment'),
                'name'        => $yagocomment->getCustomerEmail(),
                'description' => $yagocomment->getCustomerEmail(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/yagostudiocomments_yagocomment/edit',
                    array('id'=>$yagocomment->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
