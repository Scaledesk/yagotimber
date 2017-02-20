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
 * YagoComment admin controller
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudiocomments
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudiocomments_Adminhtml_Yagostudiocomments_YagocommentController extends StarGenius_Yagostudiocomments_Controller_Adminhtml_Yagostudiocomments
{
    /**
     * init the yagocomment
     *
     * @access protected
     * @return StarGenius_Yagostudiocomments_Model_Yagocomment
     */
    protected function _initYagocomment()
    {
        $yagocommentId  = (int) $this->getRequest()->getParam('id');
        $yagocomment    = Mage::getModel('stargenius_yagostudiocomments/yagocomment');
        if ($yagocommentId) {
            $yagocomment->load($yagocommentId);
        }
        Mage::register('current_yagocomment', $yagocomment);
        return $yagocomment;
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
        $this->_title(Mage::helper('stargenius_yagostudiocomments')->__('Yagostudio Comments'))
             ->_title(Mage::helper('stargenius_yagostudiocomments')->__('YagoComments'));
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
     * edit yagocomment - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $yagocommentId    = $this->getRequest()->getParam('id');
        $yagocomment      = $this->_initYagocomment();
        if ($yagocommentId && !$yagocomment->getId()) {
            $this->_getSession()->addError(
                Mage::helper('stargenius_yagostudiocomments')->__('This yagocomment no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getYagocommentData(true);
        if (!empty($data)) {
            $yagocomment->setData($data);
        }
        Mage::register('yagocomment_data', $yagocomment);
        $this->loadLayout();
        $this->_title(Mage::helper('stargenius_yagostudiocomments')->__('Yagostudio Comments'))
             ->_title(Mage::helper('stargenius_yagostudiocomments')->__('YagoComments'));
        if ($yagocomment->getId()) {
            $this->_title($yagocomment->getCustomerEmail());
        } else {
            $this->_title(Mage::helper('stargenius_yagostudiocomments')->__('Add yagocomment'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new yagocomment action
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
     * save yagocomment - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('yagocomment')) {
            try {
                $yagocomment = $this->_initYagocomment();
                $yagocomment->addData($data);
                $yagocomment->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_yagostudiocomments')->__('YagoComment was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $yagocomment->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setYagocommentData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_yagostudiocomments')->__('There was a problem saving the yagocomment.')
                );
                Mage::getSingleton('adminhtml/session')->setYagocommentData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('stargenius_yagostudiocomments')->__('Unable to find yagocomment to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete yagocomment - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $yagocomment = Mage::getModel('stargenius_yagostudiocomments/yagocomment');
                $yagocomment->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_yagostudiocomments')->__('YagoComment was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_yagostudiocomments')->__('There was an error deleting yagocomment.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('stargenius_yagostudiocomments')->__('Could not find yagocomment to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete yagocomment - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $yagocommentIds = $this->getRequest()->getParam('yagocomment');
        if (!is_array($yagocommentIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stargenius_yagostudiocomments')->__('Please select yagocomments to delete.')
            );
        } else {
            try {
                foreach ($yagocommentIds as $yagocommentId) {
                    $yagocomment = Mage::getModel('stargenius_yagostudiocomments/yagocomment');
                    $yagocomment->setId($yagocommentId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_yagostudiocomments')->__('Total of %d yagocomments were successfully deleted.', count($yagocommentIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_yagostudiocomments')->__('There was an error deleting yagocomments.')
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
        $yagocommentIds = $this->getRequest()->getParam('yagocomment');
        if (!is_array($yagocommentIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stargenius_yagostudiocomments')->__('Please select yagocomments.')
            );
        } else {
            try {
                foreach ($yagocommentIds as $yagocommentId) {
                $yagocomment = Mage::getSingleton('stargenius_yagostudiocomments/yagocomment')->load($yagocommentId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d yagocomments were successfully updated.', count($yagocommentIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_yagostudiocomments')->__('There was an error updating yagocomments.')
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
        $fileName   = 'yagocomment.csv';
        $content    = $this->getLayout()->createBlock('stargenius_yagostudiocomments/adminhtml_yagocomment_grid')
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
        $fileName   = 'yagocomment.xls';
        $content    = $this->getLayout()->createBlock('stargenius_yagostudiocomments/adminhtml_yagocomment_grid')
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
        $fileName   = 'yagocomment.xml';
        $content    = $this->getLayout()->createBlock('stargenius_yagostudiocomments/adminhtml_yagocomment_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('stargenius_yagostudiocomments/yagocomment');
    }
}
