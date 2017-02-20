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
 * Question admin controller
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author      Ultimate Module Creator
 */
class StarGenius_AskAnExpert_Adminhtml_Askanexpert_QuestionsController extends StarGenius_AskAnExpert_Controller_Adminhtml_AskAnExpert
{
    /**
     * init the question
     *
     * @access protected
     * @return StarGenius_AskAnExpert_Model_Questions
     */
    protected function _initQuestions()
    {
        $questionsId  = (int) $this->getRequest()->getParam('id');
        $questions    = Mage::getModel('stargenius_askanexpert/questions');
        if ($questionsId) {
            $questions->load($questionsId);
        }
        Mage::register('current_questions', $questions);
        return $questions;
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
        $this->_title(Mage::helper('stargenius_askanexpert')->__('Ask An Expert'))
             ->_title(Mage::helper('stargenius_askanexpert')->__('Questions'));
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
     * edit question - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $questionsId    = $this->getRequest()->getParam('id');
        $questions      = $this->_initQuestions();
        if ($questionsId && !$questions->getId()) {
            $this->_getSession()->addError(
                Mage::helper('stargenius_askanexpert')->__('This question no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getQuestionsData(true);
        if (!empty($data)) {
            $questions->setData($data);
        }
        Mage::register('questions_data', $questions);
        $this->loadLayout();
        $this->_title(Mage::helper('stargenius_askanexpert')->__('Ask An Expert'))
             ->_title(Mage::helper('stargenius_askanexpert')->__('Questions'));
        if ($questions->getId()) {
            $this->_title($questions->getName());
        } else {
            $this->_title(Mage::helper('stargenius_askanexpert')->__('Add question'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new question action
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
     * save question - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('questions')) {
            try {
                $questions = $this->_initQuestions();
                $questions->addData($data);
                $questions->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_askanexpert')->__('Question was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $questions->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setQuestionsData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_askanexpert')->__('There was a problem saving the question.')
                );
                Mage::getSingleton('adminhtml/session')->setQuestionsData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('stargenius_askanexpert')->__('Unable to find question to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete question - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $questions = Mage::getModel('stargenius_askanexpert/questions');
                $questions->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_askanexpert')->__('Question was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_askanexpert')->__('There was an error deleting question.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('stargenius_askanexpert')->__('Could not find question to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete question - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $questionsIds = $this->getRequest()->getParam('questions');
        if (!is_array($questionsIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stargenius_askanexpert')->__('Please select questions to delete.')
            );
        } else {
            try {
                foreach ($questionsIds as $questionsId) {
                    $questions = Mage::getModel('stargenius_askanexpert/questions');
                    $questions->setId($questionsId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stargenius_askanexpert')->__('Total of %d questions were successfully deleted.', count($questionsIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_askanexpert')->__('There was an error deleting questions.')
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
        $questionsIds = $this->getRequest()->getParam('questions');
        if (!is_array($questionsIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stargenius_askanexpert')->__('Please select questions.')
            );
        } else {
            try {
                foreach ($questionsIds as $questionsId) {
                $questions = Mage::getSingleton('stargenius_askanexpert/questions')->load($questionsId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d questions were successfully updated.', count($questionsIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stargenius_askanexpert')->__('There was an error updating questions.')
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
        $fileName   = 'questions.csv';
        $content    = $this->getLayout()->createBlock('stargenius_askanexpert/adminhtml_questions_grid')
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
        $fileName   = 'questions.xls';
        $content    = $this->getLayout()->createBlock('stargenius_askanexpert/adminhtml_questions_grid')
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
        $fileName   = 'questions.xml';
        $content    = $this->getLayout()->createBlock('stargenius_askanexpert/adminhtml_questions_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('stargenius_askanexpert/questions');
    }
}
