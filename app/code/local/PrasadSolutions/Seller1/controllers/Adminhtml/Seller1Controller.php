<?php

class PrasadSolutions_Seller1_Adminhtml_Seller1Controller extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("seller1/seller1")->_addBreadcrumb(Mage::helper("adminhtml")->__("Seller1  Manager"),Mage::helper("adminhtml")->__("Seller1 Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Seller1"));
			    $this->_title($this->__("Manager Seller1"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Seller1"));
				$this->_title($this->__("Seller1"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("seller1/seller1")->load($id);
				if ($model->getId()) {
					Mage::register("seller1_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("seller1/seller1");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Seller1 Manager"), Mage::helper("adminhtml")->__("Seller1 Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Seller1 Description"), Mage::helper("adminhtml")->__("Seller1 Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("seller1/adminhtml_seller1_edit"))->_addLeft($this->getLayout()->createBlock("seller1/adminhtml_seller1_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("seller1")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Seller1"));
		$this->_title($this->__("Seller1"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("seller1/seller1")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("seller1_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("seller1/seller1");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Seller1 Manager"), Mage::helper("adminhtml")->__("Seller1 Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Seller1 Description"), Mage::helper("adminhtml")->__("Seller1 Description"));


		$this->_addContent($this->getLayout()->createBlock("seller1/adminhtml_seller1_edit"))->_addLeft($this->getLayout()->createBlock("seller1/adminhtml_seller1_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {
					
					if( $this->getRequest()->getPost('aprove') == 1){
					$userid =$this->getRequest()->getPost('userid');

					$password =$this->getrequest()->getpost('password');
					$user = Mage::getModel("admin/user")
							->setUsername($this->getRequest()->getPost('userid'))
							->setFirstname($this->getRequest()->getPost('Name_of_Contact_Person_for'))
							->setLastname($this->getRequest()->getPost('Name_of_Contact_Person_for'))
							->setEmail($this->getRequest()->getPost('email'))
							->setCompany($this->getRequest()->getPost('name_of_company'))
							->setLandline($this->getRequest()->getPost('landline'))
							->setShopadd($this->getRequest()->getPost('Address_of_Registered_office'))				  
							->setCstnumber($this->getRequest()->getPost('cst_NUm'))
							->setVatnumber($this->getRequest()->getPost('service'))
							->setPassword($this->getRequest()->getPost('password'))
							->save();
						  $role = Mage::getModel("admin/role");
                              $role->setParent_id(4);
                              $role->setTree_level(2);
							  $role->setRole_type('U');
							  $role->setUser_id($user->getId());
							  $role->save();
							  
						  // Transactional Email Template's ID
         $templateId = 3;

        // Set sender information
        $senderName = 'Kraftbuy';
        $senderEmail = 'admin@kraftbuy.com';
        $sender = array('name' => $senderName,
                    'email' => $senderEmail);

        // Set recepient information
        $recepientEmail = ($this->getRequest()->getPost('email'));
        $recepientName = ($this->getRequest()->getPost('Name_of_Contact_Person_for'));     

        // Get Store ID
        $store = Mage::app()->getStore()->getId();

        // Set variables that can be used in email template
        $vars = array('customerName' =>$recepientName,
                  'customerEmail' => $recepientEmail,'userid'=> $userid , 'password'=>$password);

        $translate  = Mage::getSingleton('core/translate');

        // Send Transactional Email
        Mage::getModel('core/email_template')
            ->sendTransactional($templateId, $sender, $recepientEmail, $recepientName, $vars, $storeId);

        $translate->setTranslateInline(true);
				
						  }

					$model = Mage::getModel("seller1/seller1")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Seller1 was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setSeller1Data(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setSeller1Data($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("seller1/seller1");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("seller1/seller1");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'seller1.csv';
			$grid       = $this->getLayout()->createBlock('seller1/adminhtml_seller1_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'seller1.xml';
			$grid       = $this->getLayout()->createBlock('seller1/adminhtml_seller1_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}

        
		

