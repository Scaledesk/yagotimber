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
 * Yagostudio admin controller
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Adminhtml_Yagostudio_YagostudioController extends StarGenius_Yagostudio_Controller_Adminhtml_Yagostudio
{
    /**
     * init the yagostudio
     *
     * @access protected
     * @return StarGenius_Yagostudio_Model_Yagostudio
     */
    protected function _initYagostudio()
    {
        $yagostudioId  = (int) $this->getRequest()->getParam('id');
        $yagostudio    = Mage::getModel('stargenius_yagostudio/yagostudio');
        if ($yagostudioId) {
            $yagostudio->load($yagostudioId);
        }
        Mage::register('current_yagostudio', $yagostudio);
        return $yagostudio;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('stargenius_yagostudio')->__('Yagostudio'))
             ->_title(Mage::helper('stargenius_yagostudio')->__('Yagostudios'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit yagostudio - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $yagostudioId    = $this->getRequest()->getParam('id');
        $yagostudio      = $this->_initYagostudio();
        if ($yagostudioId && !$yagostudio->getId()) {
            $this->_getSession()->addError(
                Mage::helper('stargenius_yagostudio')->__('This yagostudio no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getYagostudioData(true);
        if (!empty($data)) {
            $yagostudio->setData($data);
        }
        Mage::register('yagostudio_data', $yagostudio);
        $this->loadLayout();
        $this->_title(Mage::helper('stargenius_yagostudio')->__('Yagostudio'))
             ->_title(Mage::helper('stargenius_yagostudio')->__('Yagostudios'));
        if ($yagostudio->getId()) {
            $this->_title($yagostudio->getDesignerName());
        } else {
            $this->_title(Mage::helper('stargenius_yagostudio')->__('Add yagostudio'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new yagostudio action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save yagostudio - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('yagostudio')) {
            try {
                $yagostudio = $this->_initYagostudio();
                $yagostudio->addData($data);
                $designerPhotosName = $this->_uploadAndGetName(
                    'designer_photos',
                    Mage::helper('stargenius_yagostudio/yagostudio_image')->getImageBaseDir(),
                    $data
                );
                $yagostudio->setData('designer_photos', $designerPhotosName);
                $yagostudio->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_yagostudio')->__('Yagostudio was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $yagostudio->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['designer_photos']['value'])) {
                    $data['designer_photos'] = $data['designer_photos']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setYagostudioData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['designer_photos']['value'])) {
                    $data['designer_photos'] = $data['designer_photos']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_yagostudio')->__('There was a problem saving the yagostudio.')
                );
                Mage::getSingleton('adminhtml/session')->setYagostudioData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('stargenius_yagostudio')->__('Unable to find yagostudio to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete yagostudio - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $yagostudio = Mage::getModel('stargenius_yagostudio/yagostudio');
                $yagostudio->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_yagostudio')->__('Yagostudio was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_yagostudio')->__('There was an error deleting yagostudio.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('stargenius_yagostudio')->__('Could not find yagostudio to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete yagostudio - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $yagostudioIds = $this->getRequest()->getParam('yagostudio');
        if (!is_array($yagostudioIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stargenius_yagostudio')->__('Please select yagostudios to delete.')
            );
        } else {
            try {
                foreach ($yagostudioIds as $yagostudioId) {
                    $yagostudio = Mage::getModel('stargenius_yagostudio/yagostudio');
                    $yagostudio->setId($yagostudioId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_yagostudio')->__('Total of %d yagostudios were successfully deleted.', count($yagostudioIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_yagostudio')->__('There was an error deleting yagostudios.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $yagostudioIds = $this->getRequest()->getParam('yagostudio');
        if (!is_array($yagostudioIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stargenius_yagostudio')->__('Please select yagostudios.')
            );
        } else {
            try {
                foreach ($yagostudioIds as $yagostudioId) {
                $yagostudio = Mage::getSingleton('stargenius_yagostudio/yagostudio')->load($yagostudioId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d yagostudios were successfully updated.', count($yagostudioIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_yagostudio')->__('There was an error updating yagostudios.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'yagostudio.csv';
        $content    = $this->getLayout()->createBlock('stargenius_yagostudio/adminhtml_yagostudio_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'yagostudio.xls';
        $content    = $this->getLayout()->createBlock('stargenius_yagostudio/adminhtml_yagostudio_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'yagostudio.xml';
        $content    = $this->getLayout()->createBlock('stargenius_yagostudio/adminhtml_yagostudio_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('stargenius_yagostudio/yagostudio');
    }
}
