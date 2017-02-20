<?php
/**
 * StarGenius_ProductLikeCount extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_ProductLikeCount
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * ProductsLike front contrller
 *
 * @category    StarGenius
 * @package     StarGenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class StarGenius_ProductLikeCount_ProductslikeController extends Mage_Core_Controller_Front_Action
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
        if (Mage::helper('stargenius_productlikecount/productslike')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('stargenius_productlikecount')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'productslikes',
                    array(
                        'label' => Mage::helper('stargenius_productlikecount')->__('ProductsLikes'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('stargenius_productlikecount/productslike')->getProductslikesUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('stargenius_productlikecount/productslike/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('stargenius_productlikecount/productslike/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('stargenius_productlikecount/productslike/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init ProductsLike
     *
     * @access protected
     * @return StarGenius_ProductLikeCount_Model_Productslike
     * @author Ultimate Module Creator
     */
    protected function _initProductslike()
    {
        $productslikeId   = $this->getRequest()->getParam('id', 0);
        $productslike     = Mage::getModel('stargenius_productlikecount/productslike')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productslikeId);
        if (!$productslike->getId()) {
            return false;
        } elseif (!$productslike->getStatus()) {
            return false;
        }
        return $productslike;
    }

    protected function ashuAction()
    {
     
	  $p_id  = $this->getRequest()->getPost('id');
       $p_sku = $this->getRequest()->getPost('sku');
        $u_ip = $this->getRequest()->getPost('ip');
		 $postcollection = Mage::getModel('stargenius_productlikecount/productslike')->load(NULL);
		$postcollection->setProductId($p_id);
		$postcollection->setProductSku($p_sku);
		$postcollection->setProductLiked(1);
		$postcollection->setUIpaddress($u_ip );
		$postcollection->setStatus(1);
				$postcollection->save();
				
				$collection = Mage::getResourceModel('stargenius_productlikecount/productslike_collection')
                ->addFieldToFilter('product_sku', $p_sku)
				->load();
		 $total_count = 0;
		 
		   foreach ($collection->getItems() as $productslike) {
           
               $total_count =   $total_count + $productslike->getProductLiked();
              
        }
		 echo $total_count;
		
	
    }
	
	
					 protected function getproductsAction()
					{
					 
					 $data = '';
					            $category_id  = $this->getRequest()->getPost('category');
								  $pcount  = $this->getRequest()->getPost('pcount');
								    $icount  = $this->getRequest()->getPost('icount');
					 $i= $icount;
					           $category = Mage::getModel('catalog/category')->load($category_id);
							    $collection = Mage::getModel('catalog/product')->getCollection();
								$collection->addAttributeToSelect('*')->addAttributeToSort('price','ASC')->addCategoryFilter($category);
								$collection->setPageSize(8)->setCurPage($pcount);
								$products = $collection->getItems();
										 foreach($products as $product_data) {
    
		$productMediaConfig = Mage::getModel('catalog/product_media_config');

 $baseImageUrl = $productMediaConfig->getMediaUrl($product_data->getImage());
			 
					  $collection = Mage::getResourceModel('stargenius_productlikecount/productslike_collection')
                ->addFieldToFilter('product_sku', $product_data->getSku())
				->load();
		 $total_count = 0;
		 
		
		  foreach ($collection->getItems() as $productslike) {
           
               $total_count =   $total_count + $productslike->getProductLiked();
              
        }						 
						
						
						
 $collection_current = Mage::getResourceModel('stargenius_productlikecount/productslike_collection')
                ->addFieldToFilter('product_sku', $product_data->getSku())
				 ->addFieldToFilter('u_ipaddress',$_SERVER['REMOTE_ADDR'])
				->load(); 
				 if($collection_current->getItems()) { 
				$data_like = '<div id="heart_like'.$product_data->getId().'" class="heard002"><img alt="" src="http://www.yagotimber.com/media/wysiwyg/heart.png"></div>';
				  }
               else {
			 $data_like = '<div id="heart_like'.$product_data->getId().'" class="heard002"><button id="countplus'.$product_data->getId().'" ><img alt="" src="http://www.yagotimber.com/media/wysiwyg/heart.png"></button></div>';
			  }            
            
            					 
		$data .= '<li><div class="container">
       <div class="land01">
<div class="row">
<div class="col-md-8 col-sm-8 col-xs-12">
<div class="land01_img"><a href="#fadeandscalelerge'.$i.'" class="  fadeandscalelerge'.$i.'_open" title="Click to Enlarge"><img alt="" src="'.$baseImageUrl.'" /></a></div>
</div>
<div class="col-md-4 col-sm-4 col-xs-12">
<div class="land01_detail">
<div class="heard001">
<p>
<img alt="" src="http://www.yagotimber.com/media/wysiwyg/hart_1.png"> 
'.$data_like .'
<span id="uptotal'.$product_data->getId().'" >'.$total_count.'</span></p>

</div>
      
<ul>
<li><h2>'.$product_data->getName().'</h2></li>
<li><h6>'.$product_data->getDescription().'</h6></li>
<li><h7><B>BUY THIS LOOK  :</B> '.$product_data->getShortDescription().'</h7></li>
</ul>
<a id="open_55592391" data-popup-ordinal="1" href="#fadeandscaledesigner'.$i.'" class=" fadeandscaledesigner'.$i.'_open"><div class="des09">Consult Designer</div></a>
<div class="share">Share This Look
<div class="social">      
       <ul class="link">

					<li class="fb">
	<a href="http://www.facebook.com/share.php?u='.$product_data->getProductUrl().'" rel="nofollow" target="_blank" style="text-decoration:none;">
				
			</a>
			</li>

				<li class="tw">
			<a href="http://twitter.com/home?status='.$product_data->getProductUrl().'" rel="nofollow" target="_blank" style="text-decoration:none;">
				
			</a>
			</li>

				<li class="pintrest">
<a href="http://pinterest.com/pin/create/link/?url='.$product_data->getProductUrl().'&media='. $baseImageUrl.'&description='.$product_data->getDescription().'" rel="nofollow" target="_blank" style="text-decoration:none;"></a>
			</li>

		<li class="googleplus">
			<a href="https://plus.google.com/share?url='.$product_data->getProductUrl().'" rel="nofollow" target="_blank" style="text-decoration:none;">
				
			</a>
			</li>

	</ul>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="fadeandscaledesigner'.$i.'" class="well" style="display:none;"><a class=" fadeandscaledesigner'.$i.'_close close02">X</a>
<div class="col-md-5 col-sm-12 col-xs-12"><div class="pop-img1">
                            <div class="register007">
                                <ul>
                                    <li><img alt="Kit Price" src="http://www.yagotimber.com/skin/frontend/base/default/kit-price.png" /> <span>Starting from  <B>Rs 1,00,000</B></span></li>
                                    <li><img alt="Cupen 4" src="http://www.yagotimber.com/skin/frontend/base/default/cupen4.png" /> <span>10 years <B>WARRANTY</B></span></li>
                                    <li><img alt="Kit Delivery" src="http://www.yagotimber.com/skin/frontend/base/default/kit-delivery.png" /> <span><b>30 days </b> delivery</span></li>
                                    <li><img alt="Cupen 3" src="http://www.yagotimber.com/skin/frontend/base/default/cupen3.png" /> <span>Free <b>INSTALLATION</b></span></li>
                                </ul>
                            </div>
                            <img src="http://www.yagotimber.com/skin/frontend/rwd/yagotimber/images/register-popup.png" alt="Register" class="register-img">
                    </div>
       </div>
       <div class="col-md-7 col-sm-12 col-xs-12">
	<div class="bookdesigner">
        <div class="col-md-12 col-sm-12 col-xs-12">'.Mage::app()->getLayout()->createBlock("formbuilder/frontend_form")->setData("form_id","7")->setTemplate("formbuilder/form.phtml")->toHtml().'</div>
    </div>
    </div>
</div>


<div id="fadeandscalelerge'.$i.'" class="well" style="display:none;"><a class=" fadeandscalelerge'.$i.'_close close02">X</a>
	<div class="lerge_box">   <img alt="" src="'.$baseImageUrl.'" />    </div>
</div>
<style>
#fadeandscalelerge'.$i.' {
    -webkit-transform: scale(0.8);
       -moz-transform: scale(0.8);
        -ms-transform: scale(0.8);
            transform: scale(0.8);
			  max-width: 900px;
			  
}
.popup_visible #fadeandscalelerge'.$i.' {
    -webkit-transform: scale(1);
       -moz-transform: scale(1);
        -ms-transform: scale(1);
            transform: scale(1);
			 max-width: 900px;
}
<style><!--
#fadeandscaledesigner'.$i.' {
    -webkit-transform: scale(0.8);
       -moz-transform: scale(0.8);
        -ms-transform: scale(0.8);
            transform: scale(0.8);
			   max-width: 900px;
}
.popup_visible #fadeandscaledesigner'.$i.' {
    -webkit-transform: scale(1);
       -moz-transform: scale(1);
        -ms-transform: scale(1);
            transform: scale(1);
			 max-width: 900px;
}     

@media (max-width: 800px) {
	#fadeandscaledesigner'.$i.' {width: 400px;}
	.pop-img1{display:none;}
	
}

@media (max-width: 500px) {
	#fadeandscaledesigner'.$i.' {width: 300px;}
}

</style> 
<script type="text/javascript">
jQuery(document).ready(function () {

    jQuery("#fadeandscalelerge'.$i.'").popup({
        pagecontainer: ".container",
        transition: "all 0.3s"
    });

});</script>
<script type="text/javascript">
jQuery(document).ready(function () {

    jQuery("#fadeandscaledesigner'.$i.'").popup({
        pagecontainer: ".container",
        transition: "all 0.3s"
    });

});</script>


  <script type="text/javascript">
			
jQuery("#countplus'.$product_data->getId().'").click(function(){
	
var id = "'.$product_data->getId().'";
var sku = "'.$product_data->getSku().'";
var ip = "'.$_SERVER['REMOTE_ADDR'].'";
var dataString = "id="+ id + "&sku="+ sku + "&ip="+ ip;
// AJAX Code To Submit Form.
jQuery.ajax({
type: "POST",
url: "'.Mage::getBaseUrl().'productlikecount/productslike/ashu/",
data: dataString,
cache: false,
success: function(result){
jQuery("#uptotal'.$product_data->getId().'").html(result);
jQuery("#heart_like'.$product_data->getId().'").html();

}
});

});
</script>     
    
      </li>';	$i++;
	  
	  }
	  
	
	  
	  		 		 echo $data;
						
					
					}
		
	
	 /**
     * view productslike action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $productslike = $this->_initProductslike();
        if (!$productslike) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_productslike', $productslike);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('productlikecount-productslike productlikecount-productslike' . $productslike->getId());
        }
        if (Mage::helper('stargenius_productlikecount/productslike')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('stargenius_productlikecount')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'productslikes',
                    array(
                        'label' => Mage::helper('stargenius_productlikecount')->__('ProductsLikes'),
                        'link'  => Mage::helper('stargenius_productlikecount/productslike')->getProductslikesUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'productslike',
                    array(
                        'label' => $productslike->getProductSku(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $productslike->getProductslikeUrl());
        }
        if ($headBlock) {
            if ($productslike->getMetaTitle()) {
                $headBlock->setTitle($productslike->getMetaTitle());
            } else {
                $headBlock->setTitle($productslike->getProductSku());
            }
            $headBlock->setKeywords($productslike->getMetaKeywords());
            $headBlock->setDescription($productslike->getMetaDescription());
        }
        $this->renderLayout();
    }
}
