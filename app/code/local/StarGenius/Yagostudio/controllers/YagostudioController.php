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
 * Yagostudio front contrller
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_YagostudioController extends Mage_Core_Controller_Front_Action
{

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
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('stargenius_yagostudio/yagostudio')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('stargenius_yagostudio')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'yagostudios',
                    array(
                        'label' => Mage::helper('stargenius_yagostudio')->__('Yagostudios'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('stargenius_yagostudio/yagostudio')->getYagostudiosUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('stargenius_yagostudio/yagostudio/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('stargenius_yagostudio/yagostudio/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('stargenius_yagostudio/yagostudio/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init Yagostudio
     *
     * @access protected
     * @return StarGenius_Yagostudio_Model_Yagostudio
     * @author Ultimate Module Creator
     */
    protected function _initYagostudio()
    {
        $yagostudioId   = $this->getRequest()->getParam('id', 0);
        $yagostudio     = Mage::getModel('stargenius_yagostudio/yagostudio')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($yagostudioId);
        if (!$yagostudio->getId()) {
            return false;
        } elseif (!$yagostudio->getStatus()) {
            return false;
        }
        return $yagostudio;
    }

    /**
     * view yagostudio action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $yagostudio = $this->_initYagostudio();
        if (!$yagostudio) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_yagostudio', $yagostudio);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('yagostudio-yagostudio yagostudio-yagostudio' . $yagostudio->getId());
        }
        if (Mage::helper('stargenius_yagostudio/yagostudio')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('stargenius_yagostudio')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'yagostudios',
                    array(
                        'label' => Mage::helper('stargenius_yagostudio')->__('Yagostudios'),
                        'link'  => Mage::helper('stargenius_yagostudio/yagostudio')->getYagostudiosUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'yagostudio',
                    array(
                        'label' => $yagostudio->getDesignerName(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $yagostudio->getYagostudioUrl());
        }
        if ($headBlock) {
            if ($yagostudio->getMetaTitle()) {
                $headBlock->setTitle($yagostudio->getMetaTitle());
            } else {
                $headBlock->setTitle($yagostudio->getDesignerName());
            }
            $headBlock->setKeywords($yagostudio->getMetaKeywords());
            $headBlock->setDescription($yagostudio->getMetaDescription());
        }
        $this->renderLayout();
    }

    /**
     * Submit new comment action
     * @access public
     * @author Ultimate Module Creator
     */
    public function commentpostAction()
    {
        $data   = $this->getRequest()->getPost();
        $yagostudio = $this->_initYagostudio();
        $session    = Mage::getSingleton('core/session');
        if ($yagostudio) {
            if ($yagostudio->getAllowComments()) {
                if ((Mage::getSingleton('customer/session')->isLoggedIn() ||
                    Mage::getStoreConfigFlag('stargenius_yagostudio/yagostudio/allow_guest_comment'))) {
                    $comment  = Mage::getModel('stargenius_yagostudio/yagostudio_comment')->setData($data);
                    $validate = $comment->validate();
                    if ($validate === true) {
                        try {
                            $comment->setYagostudioId($yagostudio->getId())
                                ->setStatus(StarGenius_Yagostudio_Model_Yagostudio_Comment::STATUS_PENDING)
                                ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                                ->setStores(array(Mage::app()->getStore()->getId()))
                                ->save();
                            $session->addSuccess($this->__('Your comment has been accepted for moderation.'));
                        } catch (Exception $e) {
                            $session->setYagostudioCommentData($data);
                            $session->addError($this->__('Unable to post the comment.'));
                        }
                    } else {
                        $session->setYagostudioCommentData($data);
                        if (is_array($validate)) {
                            foreach ($validate as $errorMessage) {
                                $session->addError($errorMessage);
                            }
                        } else {
                            $session->addError($this->__('Unable to post the comment.'));
                        }
                    }
                } else {
                    $session->addError($this->__('Guest comments are not allowed'));
                }
            } else {
                $session->addError($this->__('This yagostudio does not allow comments'));
            }
        }
        $this->_redirectReferer();
    }
}
