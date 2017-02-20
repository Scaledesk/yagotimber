<?php
/**
 * StarGenius_AskAnExpert extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_AskAnExpert
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Question front contrller
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author      Ultimate Module Creator
 */
class StarGenius_AskAnExpert_QuestionsController extends Mage_Core_Controller_Front_Action
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
        if (Mage::helper('stargenius_askanexpert/questions')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('stargenius_askanexpert')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'questionss',
                    array(
                        'label' => Mage::helper('stargenius_askanexpert')->__('Questions'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('stargenius_askanexpert/questions')->getQuestionssUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('stargenius_askanexpert/questions/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('stargenius_askanexpert/questions/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('stargenius_askanexpert/questions/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init Question
     *
     * @access protected
     * @return StarGenius_AskAnExpert_Model_Questions
     * @author Ultimate Module Creator
     */
    protected function _initQuestions()
    {
        $questionsId   = $this->getRequest()->getParam('id', 0);
        $questions     = Mage::getModel('stargenius_askanexpert/questions')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($questionsId);
        if (!$questions->getId()) {
            return false;
        } elseif (!$questions->getStatus()) {
            return false;
        }
        return $questions;
    }

    /**
     * view question action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
     protected function ashuAction()
    {
     
	  $question_sg  = $this->getRequest()->getPost('question_sg');
       $name_sg = $this->getRequest()->getPost('name_sg');
        $email_sg = $this->getRequest()->getPost('email_sg');
		 $postcollection = Mage::getModel('stargenius_askanexpert/questions')->load(NULL);
		$postcollection->setName($name_sg);
		$postcollection->setEmail($email_sg);
		$postcollection->setquestionasked($question_sg );
		$postcollection->setStatus(1);
				$postcollection->save();
		
	Mage::getSingleton('core/session')->addSuccess($this->__('Your question has been successfully sent'));
        		 $this->_redirect('marketplace/seller/login');
    }
	
	
	  public function viewAction()
    {
        $questions = $this->_initQuestions();
        if (!$questions) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_questions', $questions);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('askanexpert-questions askanexpert-questions' . $questions->getId());
        }
        if (Mage::helper('stargenius_askanexpert/questions')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('stargenius_askanexpert')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'questionss',
                    array(
                        'label' => Mage::helper('stargenius_askanexpert')->__('Questions'),
                        'link'  => Mage::helper('stargenius_askanexpert/questions')->getQuestionssUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'questions',
                    array(
                        'label' => $questions->getName(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $questions->getQuestionsUrl());
        }
        if ($headBlock) {
            if ($questions->getMetaTitle()) {
                $headBlock->setTitle($questions->getMetaTitle());
            } else {
                $headBlock->setTitle($questions->getName());
            }
            $headBlock->setKeywords($questions->getMetaKeywords());
            $headBlock->setDescription($questions->getMetaDescription());
        }
        $this->renderLayout();
    }

    /**
     * questions rss list action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function rssAction()
    {
        if (Mage::helper('stargenius_askanexpert/questions')->isRssEnabled()) {
            $this->getResponse()->setHeader('Content-type', 'text/xml; charset=UTF-8');
            $this->loadLayout(false);
            $this->renderLayout();
        } else {
            $this->getResponse()->setHeader('HTTP/1.1', '404 Not Found');
            $this->getResponse()->setHeader('Status', '404 File not found');
            $this->_forward('nofeed', 'index', 'rss');
        }
    }
}
