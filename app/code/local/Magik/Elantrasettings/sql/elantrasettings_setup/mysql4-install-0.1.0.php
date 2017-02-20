<?php


$installer = $this;
$installer->startSetup();

$installer->endSetup();

try {
//create pages and blocks programmatically
//home page 1
$cmsPage = array(
    'title' => 'Elantra Home Page1',
    'identifier' => 'elantra_home_one',
    'content' => "<div class=\"home-tabs wow bounceInUp animated\">
<div class=\"producttabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Best Seller</span></li>
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">New Arrivals</span></li>
<li class=\"item-nav\" data-href=\"pdt_featured\" data-orderby=\"featured\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-5\">{{block type=\"catalog/product_list\" num_products=\"4\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller.phtml\" }} {{block type=\"catalog/product_new\" products_count=\"4\" column_count=\"4\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }} {{block type=\"catalog/product_list\" num_products=\"4\" name=\"featuredproduct\" as=\"featuredproduct\" template=\"catalog/product/featured.phtml\" }}</div>
</div>
</div>
</div>
</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_one'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 2
$cmsPage = array(
    'title' => 'Elantra Home Page2',
    'identifier' => 'elantra_home_two',
    'content' => "<div class=\"container\">
<div class=\"row\">
<div class=\"products-grid\">
<div class=\"col-md-12\">
<div class=\"std\">
<div class=\"home-tabs wow bounceInUp animated\">
<div class=\"producttabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Best Seller</span></li>
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">New Arrivals</span></li>
<li class=\"item-nav\" data-href=\"pdt_featured\" data-orderby=\"featured\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-5\">{{block type=\"catalog/product_list\" num_products=\"4\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller.phtml\" }} {{block type=\"catalog/product_new\" products_count=\"4\" column_count=\"4\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }} {{block type=\"catalog/product_list\" num_products=\"4\" name=\"featuredproduct\" as=\"featuredproduct\" template=\"catalog/product/featured.phtml\" }}</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_two'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 3
$cmsPage = array(
    'title' => 'Elantra Home Page3',
    'identifier' => 'elantra_home_three',
    'content' => "<div class=\"home-tabs wow bounceInUp animated animated\">
<div class=\"producttabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Best Seller</span></li>
<li class=\"item-nav\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">New Arrivals</span></li>
<li class=\"item-nav\" data-href=\"pdt_featured\" data-orderby=\"featured\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-5\">{{block type=\"catalog/product_list\" num_products=\"8\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller3.phtml\" }} {{block type=\"catalog/product_new\" column_count=\"4\" products_count=\"8\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new3.phtml\" }} {{block type=\"catalog/product_list\" num_products=\"8\" name=\"featuredproduct\" as=\"featuredproduct\" template=\"catalog/product/featured3.phtml\" }}</div>
</div>
</div>
</div>
</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_three'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 4
$cmsPage = array(
    'title' => 'Elantra Home Page4',
    'identifier' => 'elantra_home_four',
    'content' => "<div class=\"main-pro container\">
<div class=\"home-tabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">best seller</span></li>
<li class=\"item-nav\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured Products</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-5\">{{block type=\"catalog/product_list\" num_products=\"5\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller4.phtml\"}} {{block type=\"catalog/product_list\" num_products=\"5\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/featured4.phtml\"}}</div>
</div>
</div>
</div>
</div>
<div>{{block type=\"cms/block\" block_id=\"elantra_home4_banner_bottom_block\"}}</div>
<div>{{block type=\"catalog/product_new\"column_count=\"6\" products_count=\"12\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new4.phtml\" }}</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_four'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 5
$cmsPage = array(
    'title' => 'Elantra Home Page5',
    'identifier' => 'elantra_home_five',
    'content' => "<div class=\"tabs-section\">
<div class=\"container\">
<div class=\"row\">
<div class=\"products-grid\">
<div class=\"col-md-12\">
<div class=\"std\">
<div class=\"home-tabs wow bounceInUp animated\">
<div class=\"producttabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Best Seller</span></li>
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">New Arrivals</span></li>
<li class=\"item-nav\" data-href=\"pdt_featured\" data-orderby=\"featured\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-5\">{{block type=\"catalog/product_list\" num_products=\"4\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller.phtml\" }} {{block type=\"catalog/product_new\" products_count=\"4\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }} {{block type=\"catalog/product_list\" num_products=\"4\" name=\"featuredproduct\" as=\"featuredproduct\" template=\"catalog/product/featured.phtml\" }}</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_five'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();


//404 page
$cmsPage = array(
    'title' => 'Elantra 404 No Route',
    'identifier' => 'elantra_no_route',
    'content' => '<div class="content-wrapper">
<div class="container">
<div class="std">
<div class="page-not-found">
<h1>404</h1>
<h3>Oops! The Page you requested was not found!</h3>
<div><a class="btn-home" href="{{store url=""}}" type="button"><span>Back To Home</span></a></div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'one_column'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();


//footer links
$staticBlock = array(
    'title' => 'Elantra Footer links',
    'identifier' => 'elantra_footer_links',
    'content' => '<div class="col-sm-5 col-xs-12 coppyright">&copy; 2015 Magikcommerce. All Rights Reserved.</div>
<div class="col-sm-7 col-xs-12 company-links">
<ul class="links">
<li><a title="Magento Themes" href="http://www.magikcommerce.com/magento-themes-templates">Magento Themes</a></li>
<li><a title="Premium Themes" href="#">Premium Themes</a></li>
<li><a title="Responsive Themes" href="http://www.magikcommerce.com/magento-themes-templates/responsive-themes">Responsive Themes</a></li>
<li class="last"><a title="Magento Extensions" href="http://www.magikcommerce.com/magento-extensions">Magento Extensions</a></li>
</ul>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();
}
catch (Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while installing elantra theme pages and cms blocks.'));
}