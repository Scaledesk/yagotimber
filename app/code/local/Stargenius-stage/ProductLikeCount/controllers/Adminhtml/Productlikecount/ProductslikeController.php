<?php
/**
 * Stargenius_ProductLikeCount extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Stargenius
 * @package        Stargenius_ProductLikeCount
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * ProductsLike admin controller
 *
 * @category    Stargenius
 * @package     Stargenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class Stargenius_ProductLikeCount_Adminhtml_Productlikecount_ProductslikeController extends Stargenius_ProductLikeCount_Controller_Adminhtml_ProductLikeCount
{
    /**
     * init the productslike
     *
     * @access protected
     * @return Stargenius_ProductLikeCount_Model_Productslike
     */
    protected function _initProductslike()
    {
        $productslikeId  = (int) $this->getRequest()->getParam('id');
        $productslike    = Mage::getModel('stargenius_productlikecount/productslike');
        if ($productslikeId) {
            $productslike->load($productslikeId);
        }
        Mage::register('current_productslike', $productslike);
        return $productslike;
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
        $this->_title(Mage::helper('stargenius_productlikecount')->__('Product Like Count'))
             ->_title(Mage::helper('stargenius_productlikecount')->__('ProductsLikes'));
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
     * edit productslike - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $productslikeId    = $this->getRequest()->getParam('id');
        $productslike      = $this->_initProductslike();
        if ($productslikeId && !$productslike->getId()) {
            $this->_getSession()->addError(
                Mage::helper('stargenius_productlikecount')->__('This productslike no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getProductslikeData(true);
        if (!empty($data)) {
            $productslike->setData($data);
        }
        Mage::register('productslike_data', $productslike);
        $this->loadLayout();
        $this->_title(Mage::helper('stargenius_productlikecount')->__('Product Like Count'))
             ->_title(Mage::helper('stargenius_productlikecount')->__('ProductsLikes'));
        if ($productslike->getId()) {
            $this->_title($productslike->getProductSku());
        } else {
            $this->_title(Mage::helper('stargenius_productlikecount')->__('Add productslike'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new productslike action
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
     * save productslike - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('productslike')) {
            try {
                $productslike = $this->_initProductslike();
                $productslike->addData($data);
				Mage::log(var_dump($data));
                $productslike->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_productlikecount')->__('ProductsLike was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $productslike->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setProductslikeData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_productlikecount')->__('There was a problem saving the productslike.')
                );
                Mage::getSingleton('adminhtml/session')->setProductslikeData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('stargenius_productlikecount')->__('Unable to find productslike to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete productslike - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $productslike = Mage::getModel('stargenius_productlikecount/productslike');
                $productslike->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_productlikecount')->__('ProductsLike was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_productlikecount')->__('There was an error deleting productslike.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('stargenius_productlikecount')->__('Could not find productslike to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete productslike - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $productslikeIds = $this->getRequest()->getParam('productslike');
        if (!is_array($productslikeIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stargenius_productlikecount')->__('Please select productslikes to delete.')
            );
        } else {
            try {
                foreach ($productslikeIds as $productslikeId) {
                    $productslike = Mage::getModel('stargenius_productlikecount/productslike');
                    $productslike->setId($productslikeId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_productlikecount')->__('Total of %d productslikes were successfully deleted.', count($productslikeIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_productlikecount')->__('There was an error deleting productslikes.')
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
        $productslikeIds = $this->getRequest()->getParam('productslike');
        if (!is_array($productslikeIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stargenius_productlikecount')->__('Please select productslikes.')
            );
        } else {
            try {
                foreach ($productslikeIds as $productslikeId) {
                $productslike = Mage::getSingleton('stargenius_productlikecount/productslike')->load($productslikeId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d productslikes were successfully updated.', count($productslikeIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_productlikecount')->__('There was an error updating productslikes.')
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
        $fileName   = 'productslike.csv';
        $content    = $this->getLayout()->createBlock('stargenius_productlikecount/adminhtml_productslike_grid')
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
        $fileName   = 'productslike.xls';
        $content    = $this->getLayout()->createBlock('stargenius_productlikecount/adminhtml_productslike_grid')
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
        $fileName   = 'productslike.xml';
        $content    = $this->getLayout()->createBlock('stargenius_productlikecount/adminhtml_productslike_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('stargenius_productlikecount/productslike');
    }
}
