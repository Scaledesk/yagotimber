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
 * Yagostudio admin grid block
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('yagostudioGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('stargenius_yagostudio/yagostudio')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('stargenius_yagostudio')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'designer_name',
            array(
                'header'    => Mage::helper('stargenius_yagostudio')->__('Designer Name'),
                'align'     => 'left',
                'index'     => 'designer_name',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('stargenius_yagostudio')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('stargenius_yagostudio')->__('Enabled'),
                    '0' => Mage::helper('stargenius_yagostudio')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'customer_email',
            array(
                'header' => Mage::helper('stargenius_yagostudio')->__('Customer Email'),
                'index'  => 'customer_email',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'designer_email',
            array(
                'header' => Mage::helper('stargenius_yagostudio')->__('Designer Email'),
                'index'  => 'designer_email',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'designer_mobile',
            array(
                'header' => Mage::helper('stargenius_yagostudio')->__('Designer Mobile'),
                'index'  => 'designer_mobile',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'url_key',
            array(
                'header' => Mage::helper('stargenius_yagostudio')->__('URL key'),
                'index'  => 'url_key',
            )
        );
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn(
                'store_id',
                array(
                    'header'     => Mage::helper('stargenius_yagostudio')->__('Store Views'),
                    'index'      => 'store_id',
                    'type'       => 'store',
                    'store_all'  => true,
                    'store_view' => true,
                    'sortable'   => false,
                    'filter_condition_callback'=> array($this, '_filterStoreCondition'),
                )
            );
        }
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('stargenius_yagostudio')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header'    => Mage::helper('stargenius_yagostudio')->__('Updated at'),
                'index'     => 'updated_at',
                'width'     => '120px',
                'type'      => 'datetime',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('stargenius_yagostudio')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('stargenius_yagostudio')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('stargenius_yagostudio')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('stargenius_yagostudio')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('stargenius_yagostudio')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('yagostudio');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('stargenius_yagostudio')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('stargenius_yagostudio')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('stargenius_yagostudio')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('stargenius_yagostudio')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('stargenius_yagostudio')->__('Enabled'),
                            '0' => Mage::helper('stargenius_yagostudio')->__('Disabled'),
                        )
                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param StarGenius_Yagostudio_Model_Yagostudio
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * filter store column
     *
     * @access protected
     * @param StarGenius_Yagostudio_Model_Resource_Yagostudio_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Grid
     * @author Ultimate Module Creator
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
