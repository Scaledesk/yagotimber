<?php
/**
 * StarGenius_Yagostudio extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_Yagostudio
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Admin search model
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Model_Adminhtml_Search_Yagostudio extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return StarGenius_Yagostudio_Model_Adminhtml_Search_Yagostudio
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('stargenius_yagostudio/yagostudio_collection')
            ->addFieldToFilter('designer_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $yagostudio) {
            $arr[] = array(
                'id'          => 'yagostudio/1/'.$yagostudio->getId(),
                'type'        => Mage::helper('stargenius_yagostudio')->__('Yagostudio'),
                'name'        => $yagostudio->getDesignerName(),
                'description' => $yagostudio->getDesignerName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/yagostudio_yagostudio/edit',
                    array('id'=>$yagostudio->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
