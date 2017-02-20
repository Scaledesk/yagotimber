<?php


$installer = $this;
$installer->startSetup();
$installer->endSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('catalog_product', 'magikfeatured', array(
        'group'             => 'General',
        'type'              => 'int',
        'backend'           => '',
        'frontend'          => '',
        'label'             => 'Featured Product On Home',
        'input'             => 'boolean',
        'class'             => '',
        'source'            => '',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'           => true,
        'required'          => false,
        'user_defined'      => true,
        'default'           => '0',
        'searchable'        => false,
        'filterable'        => false,
        'comparable'        => false,
        'visible_on_front'  => false,
        'unique'            => false,
        'apply_to'          => 'simple,configurable,virtual,bundle,downloadable',
        'is_configurable'   => false
    ));

try {
//create pages and blocks programmatically

//Custom Tab1
$staticBlock = array(
    'title' => 'Custom Tab1',
    'identifier' => 'elantra_custom_tab1',
    'content' => "<p><strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Custom Tab2
$staticBlock = array(
    'title' => 'Custom Tab2',
    'identifier' => 'elantra_custom_tab2',
    'content' => "<p><strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Empty Category
$staticBlock = array(
    'title' => 'Empty Category',
    'identifier' => 'elantra_empty_category',
    'content' => "<p>There are no products matching the selection.<br /> This is a static CMS block displayed if category is empty. You can put your own content here.</p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Logo Brand block
 $staticBlock = array(
     'title' => 'Elantra Logo Brand block',
     'identifier' => 'elantra_logo_brand_block',
     'content' => '<div class="brand-logo wow bounceInUp animated">
<div class="container">
<div class="new_title center">
<h2>TOP BRANDS</h2>
</div>
<div class="slider-items-products">
<div id="brand-logo-slider" class="product-flexslider hidden-buttons">
<div class="slider-items slider-width-col6">
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo1.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo2.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo3.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo4.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo5.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo6.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo2.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo3.png"}}" /></a></div>
</div>
</div>
</div>
</div>
</div>',
     'is_active' => 1,
     'stores' => array(0)
 );
 Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Store Logo
$staticBlock = array(
    'title' => 'Elantra Store Logo',
    'identifier' => 'elantra_logo',
    'content' => '<div><img src="{{skin url="images/logo.png"}}" alt="Elantra Store" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


// elantra navigation block
$staticBlock = array(
    'title' => 'Custom',
    'identifier' => 'elantra_navigation_block',
    'content' => '<div class="grid12-3">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<div class="heart-icon">&nbsp;</div>
<p>Our designed to deliver almost everything you want to do online.</p>
<div><img alt="" src="{{skin url="images/custom-img1.jpg"}}" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<div class="icon-star">&nbsp;</div>
<p>Responsive design is a Web design to provide an optimal navigation.</p>
<div><img alt="" src="{{skin url="images/custom-img2.jpg"}}" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<div class="custom-icon">&nbsp;</div>
<p>Our font delivery service is built upon a reliable, global network of servers.</p>
<div><img alt="" src="{{skin url="images/custom-img3.jpg"}}" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<div class="icon-custom-grid">&nbsp;</div>
<p>Smart Product Grid is uses maximum available width of the screen.</p>
<div><img alt="" src="{{skin url="images/custom-img4.jpg"}}" /></div>
</div>
<p>&nbsp;</p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Home Banner Block
$staticBlock = array(
    'title' => 'Elantra Home Offer Banner Block',
    'identifier' => 'elantra_home_offer_banner_block',
    'content' => '<div class="top-banner-section">
<div class="starSeparator"><span class="icon-star">&nbsp;</span></div>
<h2>Todays Special Offer</h2>
<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
<div class="container">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img alt="offer banner3" src="{{skin url="images/block1.jpg"}}" /></a></div>
</div>
<div class="ccol-lg-6 col-md-6 col-sm-6 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img alt="offer banner3" src="{{skin url="images/block3.jpg"}}" /></a></div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Home Header Block
$staticBlock = array(
    'title' => 'Elantra Header Block',
    'identifier' => 'elantra_header_block',
    'content' => '<div class="our-features-box">
<div class="container">
<ul>
<li>
<div class="feature-box"><span class="icon-globe-alt">&nbsp;</span>
<div class="content">
<h3>FREE SHIPPING WORLDWIDE</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
<li class="seprator-line">&nbsp;</li>
<li>
<div class="feature-box"><span class="icon-support">&nbsp;</span>
<div class="content">
<h3>24/7 CUSTOMER SUPPORT</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
<li class="seprator-line">&nbsp;</li>
<li class="last">
<div class="feature-box"><span class="icon-share-alt">&nbsp;</span>
<div class="content">
<h3>RETURNS AND EXCHANGES</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


//Elantra Home Slider Banner Block
$staticBlock = array(
    'title' => 'Elantra Home Slider Banner Block',
    'identifier' => 'elantra_home_slider_banner_block',
    'content' => '<div id="magik-slideshow" class="magik-slideshow">
<div class="container">
<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
<div id="rev_slider_4" class="rev_slider fullwidthabanner">
<ul>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img alt="" src="{{skin url="images/slide-img2.jpg"}}" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Modern Design</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Season Sale</span></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Shop Now</a></div>
</div>
</li>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img alt="" src="{{skin url="images/slide-img1.jpg"}}" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft slide2  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Fashion 2015</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Summer</div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Buy Now</a></div>
</div>
</li>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img alt="" src="{{skin url="images/slide-img3.jpg"}}" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft slide2  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Mega Sale</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Go Lightly</div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Buy Now</a></div>
</div>
</li>
</ul>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Footer Information Links Block
$staticBlock = array(
    'title' => 'Elantra Footer Information Links Block',
    'identifier' => 'elantra_footer_information_links_block',
    'content' => '<div class="footer-column pull-left">
<h4>Shopping Guide</h4>
<ul class="links">
<li class="first"><a title="How to buy" href="{{store_url=blog}}">Blog</a></li>
<li><a title="FAQs" href="#">FAQs</a></li>
<li><a title="Payment" href="#">Payment</a></li>
<li><a title="Shipment" href="#">Shipment</a></li>
<li><a title="Where is my order?" href="#">Where is my order?</a></li>
<li class="last"><a title="Return policy" href="#">Return policy</a></li>
</ul>
</div>
<div class="footer-column pull-left">
<h4>Style Advisor</h4>
<ul class="links">
<li class="first"><a title="Your Account" href="{{store_url=customer/account/}}">Your Account</a></li>
<li><a title="Information" href="#">Information</a></li>
<li><a title="Addresses" href="#">Addresses</a></li>
<li><a title="Addresses" href="#">Discount</a></li>
<li><a title="Orders History" href="#">Orders History</a></li>
<li class="last"><a title=" Additional Information" href="#"> Additional Information</a></li>
</ul>
</div>
<div class="footer-column pull-left">
<h4>Information</h4>
<ul class="links">
<li class="first"><a title="Site Map" href="{{store_url=catalog/seo_sitemap/category/}}">Site Map</a></li>
<li><a title="Search Terms" href="{{store_url=catalogsearch/term/popular/}}">Search Terms</a></li>
<li><a title="Advanced Search" href="{{store_url=catalogsearch/advanced/}}">Advanced Search</a></li>
<li><a title="History" href="{{store_url=about-us}} ">About Us</a></li>
<li><a title="History" href="{{store_url=contacts}} ">Contact Us</a></li>
<li><a title="Suppliers" href="#">Suppliers</a></li>
</ul>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Home Latest Blog Block
$staticBlock = array(
    'title' => 'Elantra Home Latest Blog Block',
    'identifier' => 'elantra_home_latest_blog_block',
    'content' => '<div class="latest-blog wow bounceInUp animated">{{block type="blogmate/index" name="blog_home" template="blogmate/right/home_right.phtml"}}</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Blog Banner Text Block
$staticBlock = array(
    'title' => 'Elantra Blog Banner Text Block',
    'identifier' => 'elantra_blog_banner_text_block',
    'content' => '<div class="text-widget widget widget__sidebar">
<h3 class="widget-title">Text Widget</h3>
<div class="widget-content">Mauris at blandit erat. Nam vel tortor non quam scelerisque cursus. Praesent nunc vitae magna pellentesque auctor. Quisque id lectus.<br /> <br /> Massa, eget eleifend tellus. Proin nec ante leo ssim nunc sit amet velit malesuada pharetra. Nulla neque sapien, sollicitudin non ornare quis, malesuada.</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Blog Banner Ad Block
$staticBlock = array(
    'title' => 'Elantra Blog Banner Ad Block',
    'identifier' => 'elantra_blog_banner_ad_block',
    'content' => '<div class="ad-spots widget widget__sidebar"><a title="offer banner" href="#"><img alt="offer banner" src="{{skin url="images/bloc3.jpg"}}" /></a><br /> <a title="offer banner" href="#"><img alt="offer banner" src="{{skin url="images/block2.jpg"}}" /></a></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Elantra Home 1 Tab Dropdown Block
$staticBlock = array(
    'title' => 'Elantra Home Tab Dropdown Block',
    'identifier' => 'elantra_home_tab_dropdown_block',
    'content' => '<ul class="level1" style="display: none;">
<li class="level1 parent"><a href="http://mas1.magikcommerce.com/index.php/elantra"><span>Home Version 1</span></a></li>
<li class="level1 parent"><a href="http://mas1.magikcommerce.com/index.php/elantrademo2"><span>Home Version 2</span></a></li>
<li class="level1 parent"><a href="http://mas1.magikcommerce.com/index.php/elantrademo3"><span>Home Version 3</span></a></li>
<li class="level1 parent"><a href="http://mas1.magikcommerce.com/index.php/elantrademo4"><span>Home Version 4</span></a></li>
<li class="level1 parent"><a href="http://mas1.magikcommerce.com/index.php/elantrademo5"><span>Home Version 5</span></a></li>
</ul>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


//Elantra Footer Contact Us
$staticBlock = array(
    'title' => 'Elantra Footer Contact Us',
    'identifier' => 'elantra_footer_contact_us',
    'content' => '<div style="text-align: center;"><img alt="footer logo" src="{{skin url="images/footer-logo.png"}}" /></div>
<address><i class="fa fa-map-marker">&nbsp;</i> 123 Main Street, Anytown, CA 12345 USA <i class="fa fa-phone">&nbsp;</i><span> +(408) 394-7557</span> <i class="fa fa-envelope">&nbsp;</i><span> support@magikcommerce.com</span></address>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Contact Us Block',
    'identifier' => 'elantra_contact_us_block',
    'content' => '<div class="block block-company">
<div class="block-title">Company</div>
<div class="block-content"><ol id="recently-viewed-items">
<li class="item odd"><a href="{{store_url=about-us}}">About Us</a></li>
<li class="item even"><a href="{{store_url=catalog/seo_sitemap/category/}}">Sitemap</a></li>
<li class="item  odd"><a href="#">Terms of Service</a></li>
<li class="item last"><a href="{{store_url=catalogsearch/term/popular/}}">Search Terms</a></li>
<li class="item last"><a href="{{store_url=contacts/}}"><strong>Contact Us</strong></a></li>
</ol></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home2 Slider Banner Block',
    'identifier' => 'elantra_home2_slider_banner_block',
    'content' => "<div id=\"rev_slider_4_1_wrapper\" class=\"rev_slider_wrapper fullwidthbanner-container\" style=\"margin: 0px auto; background-color: transparent; padding: 0px; margin-top: 0px; margin-bottom: 0px;\" data-alias=\"classicslider1\"><!-- START REVOLUTION SLIDER 5.0.7 auto mode -->
<div id=\"rev_slider_4_1\" class=\"rev_slider fullwidthabanner\" style=\"display: none;\" data-version=\"5.0.7\">
<ul><!-- SLIDE  -->
<li data-index=\"rs-16\" data-transition=\"zoomout\" data-slotamount=\"default\" data-easein=\"Power4.easeInOut\" data-easeout=\"Power4.easeInOut\" data-masterspeed=\"2000\" data-thumb=\"{{skin url='images/ver2-slide-img1.jpg'}}\" data-rotate=\"0\" data-fstransition=\"fade\" data-fsmasterspeed=\"1500\" data-fsslotamount=\"7\" data-saveperformance=\"off\" data-title=\"Intro\" data-description=\"\"><!-- MAIN IMAGE --> <img alt=\"\" src=\"{{skin url='images/ver2-slide-img1.jpg'}}\" /> <!-- LAYERS --> <!-- LAYER NR. 1 -->
<div id=\"slide-16-layer-1\" class=\"tp-caption NotGeneric-Title   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 5; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" data-lineheight=\"['70','70','70','50']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:0px;s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1000\" data-splitin=\"chars\" data-splitout=\"none\" data-responsive_offset=\"on\" data-elementdelay=\"0.05\">SEASON SALE</div>
<!-- LAYER NR. 2 -->
<div id=\"slide-16-layer-4\" class=\"tp-caption NotGeneric-SubTitle   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 6; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['52','52','52','51']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1500\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">Elantra ecommerce store is updated regularly with offers.</div>
<!-- LAYER NR. 3 -->
<div id=\"slide-16-layer-8\" class=\"tp-caption NotGeneric-Icon   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 7; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['-68','-68','-68','-68']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-style_hover=\"cursor:default;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"2000\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">&nbsp;</div>
</li>
<!-- SLIDE  -->
<li data-index=\"rs-17\" data-transition=\"fadetotopfadefrombottom\" data-slotamount=\"default\" data-easein=\"Power3.easeInOut\" data-easeout=\"Power3.easeInOut\" data-masterspeed=\"1500\" data-thumb=\"{{skin url='images/ver2-slide-img3.jpg'}}\" data-rotate=\"0\" data-saveperformance=\"off\" data-title=\"Parallax\" data-description=\"\"><!-- MAIN IMAGE --> <img alt=\"\" src=\"{{skin url='images/ver2-slide-img3.jpg'}}\" /> <!-- LAYERS --> <!-- LAYER NR. 1 -->
<div id=\"slide-17-layer-1\" class=\"tp-caption NotGeneric-Title   tp-resizeme rs-parallaxlevel-3\" style=\"z-index: 5; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['-40','0','0','0']\" data-lineheight=\"['60','70','70','50']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rZ:-35deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:0px;\" data-mask_out=\"x:inherit;y:inherit;\" data-start=\"1000\" data-splitin=\"chars\" data-splitout=\"none\" data-responsive_offset=\"on\" data-elementdelay=\"0.05\">Mens Collection</div>
<!-- LAYER NR. 2 -->
<div id=\"slide-17-layer-4\" class=\"tp-caption NotGeneric-SubTitle   tp-resizeme rs-parallaxlevel-2\" style=\"z-index: 6; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['10','52','52','51']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];\" data-mask_out=\"x:inherit;y:inherit;\" data-start=\"1500\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
<!-- LAYER NR. 3 -->
<div id=\"slide-17-layer-8\" class=\"tp-caption NotGeneric-Icon   tp-resizeme rs-parallaxlevel-1\" style=\"z-index: 7; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['50','100','100','100']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-style_hover=\"cursor:default;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"2000\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\"><a href=\"#\">Learn More</a></div>
<!-- LAYER NR. 4 -->
<div id=\"slide-17-layer-10\" class=\"tp-caption   tp-resizeme rs-parallaxlevel-8\" style=\"z-index: 8;\" data-x=\"['left','left','left','left']\" data-hoffset=\"['680','680','680','680']\" data-y=\"['top','top','top','top']\" data-voffset=\"['632','632','632','632']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:1000;e:Power2.easeInOut;\" data-transform_out=\"opacity:0;s:1000;s:1000;\" data-start=\"2000\" data-responsive_offset=\"on\">
<div class=\"rs-looped rs-pendulum\" data-easing=\"linearEaseNone\" data-startdeg=\"-20\" data-enddeg=\"360\" data-speed=\"35\" data-origin=\"50% 50%\"><img alt=\"\" src=\"{{skin url='images/ver2-blurflake4.png'}}\" height=\"240\" width=\"240\" data-ww=\"['240px','240px','240px','240px']\" data-hh=\"['240px','240px','240px','240px']\" data-no-retina=\"\" /></div>
</div>
<!-- LAYER NR. 5 -->
<div id=\"slide-17-layer-11\" class=\"tp-caption   tp-resizeme rs-parallaxlevel-7\" style=\"z-index: 9;\" data-x=\"['left','left','left','left']\" data-hoffset=\"['948','948','948','948']\" data-y=\"['top','top','top','top']\" data-voffset=\"['487','487','487','487']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:1000;e:Power2.easeInOut;\" data-transform_out=\"opacity:0;s:1000;s:1000;\" data-start=\"2000\" data-responsive_offset=\"on\">
<div class=\"rs-looped rs-wave\" data-speed=\"20\" data-angle=\"0\" data-radius=\"50px\" data-origin=\"50% 50%\"><img alt=\"\" src=\"{{skin url='images/ver2-blurflake3.png'}}\" height=\"170\" width=\"170\" data-ww=\"['170px','170px','170px','170px']\" data-hh=\"['170px','170px','170px','170px']\" data-no-retina=\"\" /></div>
</div>
<!-- LAYER NR. 6 -->
<div id=\"slide-17-layer-12\" class=\"tp-caption   tp-resizeme rs-parallaxlevel-4\" style=\"z-index: 10;\" data-x=\"['left','left','left','left']\" data-hoffset=\"['719','719','719','719']\" data-y=\"['top','top','top','top']\" data-voffset=\"['200','200','200','200']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:1000;e:Power2.easeInOut;\" data-transform_out=\"opacity:0;s:1000;s:1000;\" data-start=\"2000\" data-responsive_offset=\"on\">
<div class=\"rs-looped rs-rotate\" data-easing=\"Power2.easeInOut\" data-startdeg=\"-20\" data-enddeg=\"360\" data-speed=\"20\" data-origin=\"50% 50%\"><img alt=\"\" src=\"{{skin url='images/ver2-blurflake2.png'}}\" height=\"51\" width=\"50\" data-ww=\"['50px','50px','50px','50px']\" data-hh=\"['51px','51px','51px','51px']\" data-no-retina=\"\" /></div>
</div>
<!-- LAYER NR. 7 -->
<div id=\"slide-17-layer-13\" class=\"tp-caption   tp-resizeme rs-parallaxlevel-6\" style=\"z-index: 11;\" data-x=\"['left','left','left','left']\" data-hoffset=\"['187','187','187','187']\" data-y=\"['top','top','top','top']\" data-voffset=\"['216','216','216','216']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:1000;e:Power2.easeInOut;\" data-transform_out=\"opacity:0;s:1000;s:1000;\" data-start=\"2000\" data-responsive_offset=\"on\">
<div class=\"rs-looped rs-wave\" data-speed=\"4\" data-angle=\"0\" data-radius=\"10\" data-origin=\"50% 50%\"><img alt=\"\" src=\"{{skin url='images/ver2-blurflake1.png'}}\" height=\"120\" width=\"120\" data-ww=\"['120px','120px','120px','120px']\" data-hh=\"['120px','120px','120px','120px']\" data-no-retina=\"\" /></div>
</div>
</li>
<!-- SLIDE  -->
<li data-index=\"rs-18\" data-transition=\"zoomin\" data-slotamount=\"7\" data-easein=\"Power4.easeInOut\" data-easeout=\"Power4.easeInOut\" data-masterspeed=\"2000\" data-thumb=\"{{skin url='images/ver2-slide-img2.jpg'}}\" data-rotate=\"0\" data-saveperformance=\"off\" data-title=\"Ken Burns\" data-description=\"\"><!-- MAIN IMAGE --> <img alt=\"\" src=\"{{skin url='images/ver2-slide-img2.jpg'}}\" /> <!-- LAYERS --> <!-- LAYER NR. 1 -->
<div id=\"slide-18-layer-9\" class=\"tp-caption tp-shape tp-shapewrapper   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 5; background-color: rgba(0, 0, 0, 0.75); border-color: rgba(0, 0, 0, 0.50);\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['15','15','15','15']\" data-width=\"500\" data-height=\"140\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:0px;\" data-mask_out=\"x:inherit;y:inherit;\" data-start=\"2000\" data-responsive_offset=\"on\">&nbsp;</div>
<!-- LAYER NR. 2 -->
<div id=\"slide-18-layer-1\" class=\"tp-caption NotGeneric-Title   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 6; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" data-lineheight=\"['70','70','70','50']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:0px;s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1000\" data-splitin=\"chars\" data-splitout=\"none\" data-responsive_offset=\"on\" data-elementdelay=\"0.05\">Sunday Sale</div>
<!-- LAYER NR. 3 -->
<div id=\"slide-18-layer-4\" class=\"tp-caption NotGeneric-SubTitle   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 7; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['52','51','51','31']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1500\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">Lorem ipsum dolor sit amet, consectetur</div>
</li>
<!-- SLIDE  -->
<li data-index=\"rs-19\" data-transition=\"zoomout\" data-slotamount=\"default\" data-easein=\"Power4.easeInOut\" data-easeout=\"Power4.easeInOut\" data-masterspeed=\"2000\" data-thumb=\"{{skin url='images/ver2-video-img.jpg'}}\" data-rotate=\"0\" data-saveperformance=\"off\" data-title=\"HTML5 Video\" data-description=\"\"><!-- MAIN IMAGE --> <img alt=\"\" src=\"{{skin url='images/ver2-video-img.jpg'}}\" /> <!-- LAYERS --> <!-- BACKGROUND VIDEO LAYER -->
<div class=\"rs-background-video-layer\" data-forcerewind=\"on\" data-volume=\"mute\" data-videowidth=\"100%\" data-videoheight=\"100%\" data-videomp4=\"{{skin url='images/bg3.mp4'}}\" data-videowebm=\"{{skin url='images/bg3.webm'}}\" data-videopreload=\"preload\" data-videoloop=\"none\" data-forcecover=\"1\" data-aspectratio=\"16:9\" data-autoplay=\"true\" data-autoplayonlyfirsttime=\"false\" data-nextslideatend=\"true\">&nbsp;</div>
<!-- LAYER NR. 1 -->
<div id=\"slide-19-layer-10\" class=\"tp-caption tp-shape tp-shapewrapper   rs-parallaxlevel-0\" style=\"z-index: 5; background-color: rgba(0, 0, 0, 0.25); border-color: rgba(0, 0, 0, 0);\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" data-width=\"full\" data-height=\"full\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:2000;e:Power3.easeInOut;\" data-transform_out=\"opacity:0;s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-start=\"2000\" data-basealign=\"slide\" data-responsive_offset=\"on\" data-responsive=\"off\">&nbsp;</div>
<!-- LAYER NR. 2 -->
<div id=\"slide-19-layer-1\" class=\"tp-caption NotGeneric-Title   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 6; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" data-lineheight=\"['70','70','70','50']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;s:1500;e:Power3.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1000\" data-splitin=\"chars\" data-splitout=\"none\" data-responsive_offset=\"on\" data-elementdelay=\"0.05\">Fresh Arrivals</div>
<!-- LAYER NR. 3 -->
<div id=\"slide-19-layer-4\" class=\"tp-caption NotGeneric-SubTitle   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 7; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['52','52','52','51']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1500\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">Lorem ipsum dolor sit amet, consectetur</div>
<!-- LAYER NR. 4 -->
<div id=\"slide-19-layer-8\" class=\"tp-caption NotGeneric-Icon   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 8; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['-68','-68','-68','-68']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-style_hover=\"cursor:default;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"2000\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">&nbsp;</div>
</li>
<!-- SLIDE  --></ul>
<div class=\"tp-static-layers\">&nbsp;</div>
<div class=\"tp-bannertimer\" style=\"height: 7px; background-color: rgba(255, 255, 255, 0.25);\">&nbsp;</div>
</div>
</div>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


$staticBlock = array(
    'title' => 'Elantra Home2 Offer Banner Block',
    'identifier' => 'elantra_home2_offer_banner_block',
    'content' => '<div class="RHS-banner">
<div class="add"><a href="#"><img alt="banner-img" src="{{skin url="images/rhs-banner1.jpg"}}" /><div class="overlay"><span class="info">Learn More</span></div></a></div>
<div class="add"><a href="#"><img alt="banner-img" src="{{skin url="images/rhs-banner2.jpg"}}" /><div class="overlay"><span class="info">Learn More</span></div></a></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Banner Block',
    'identifier' => 'elantra_banner_block',
    'content' => '<div class="offer-slider wow animated parallax parallax-2">
<div class="container">
<h3>Elantra Season Sale</h3>
<h2>up to 25% off <br /> womens collection</h2>
<p>Elantra womens clothing store is updated regularly with offers.</p>
<a class="shop-now" href="#">Shop Now</a></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Left Navigation Block',
    'identifier' => 'elantra_left_navigation_block',
    'content' => '<div class="row">
<div class="mega-col col-sm-88 " data-widgets="wid-1" data-colwidth="8">
<div class="mega-col-inner">
<div class="magik-widget">
<div class="product-block">
<div class="image"><a href="#"><img alt="Fauxwaii Shirt - Oldss" src="{{skin url="images/custom-img1.jpg"}}" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
</div>
</div>
</div>
</div>
<div class="mega-col col-sm-88 " data-widgets="wid-2" data-colwidth="8">
<div class="mega-col-inner">
<div class="magik-widget">
<div class="widget-product">
<div class="widget-inner">
<div class="product-block">
<div class="image"><a href="#"><img alt="Framed-Sleeve Mid" src="{{skin url="images/custom-img2.jpg"}}" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="mega-col col-sm-88 " data-widgets="wid-1" data-colwidth="8">
<div class="mega-col-inner">
<div class="magik-widget">
<div class="product-block">
<div class="image"><a href="#"><img alt="Fauxwaii Shirt - Oldss" src="{{skin url="images/custom-img3.jpg"}}" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
</div>
</div>
</div>
</div>
<div class="mega-col col-sm-88 " data-widgets="wid-2" data-colwidth="8">
<div class="mega-col-inner">
<div class="magik-widget">
<div class="widget-product">
<div class="widget-inner">
<div class="product-block">
<div class="image"><a href="#"><img alt="Framed-Sleeve Mid" src="{{skin url="images/custom-img4.jpg"}}" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


$staticBlock = array(
    'title' => 'Elantra Banner2 Block',
    'identifier' => 'elantra_banner2_block',
    'content' => '<div class="top-banner-section">
<div class="container">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img alt="offer banner3" src="{{skin url="images/home-banner1.jpg"}}" /></a></div>
</div>
<div class="ccol-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img alt="offer banner3" src="{{skin url="images/home-banner2.jpg"}}" /></a></div>
</div>
<div class="ccol-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img alt="offer banner3" src="{{skin url="images/home-banner3.jpg"}}" /></a></div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Recommended Text Block',
    'identifier' => 'elantra_recommended_text_block',
    'content' => '<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Blog Text Block',
    'identifier' => 'elantra_blog_text_block',
    'content' => '<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Footer Payment Block',
    'identifier' => 'elantra_footer_payment_block',
    'content' => '<div class="payment-accept">
<div><img alt="payment1" src="{{skin url="images/payment-1.png"}}" /> <img alt="payment2" src="{{skin url="images/payment-2.png"}}" /> <img alt="payment3" src="{{skin url="images/payment-3.png"}}" /> <img alt="payment4" src="{{skin url="images/payment-4.png"}}" /></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Detail Banner Block',
    'identifier' => 'elantra_detail_banner_block',
    'content' => '<div class="side-banner"><img alt="banner image" src="{{skin url="images/side-brand-logo.jpg"}}" /></div>
<div><img alt="banner" src="{{skin url="images/side-banner.jpg"}}" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//14-10-15
$staticBlock = array(
    'title' => 'Elantra Header Top Block',
    'identifier' => 'elantra_header_top_block',
    'content' => '<div class="header-banner">
	  <div class="assetBlock">
	  <div id="slideshow" style="height: 20px; overflow: hidden;">
	  <p style="display: block;">Final Days! - <span>50%</span> Off New Season Arrivals &gt;</p>
	  <p style="display: none;"><span>5%</span> Discount! - on selected items &gt;</p>
	  </div>
	  <a class="cross-img" href="javascript:void(0)"><img alt="close" src="{{skin url="images/cross-img.png"}}" /></a></div>
	  </div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Logo3',
    'identifier' => 'elantra_logo_3',
    'content' => '<div><img alt="elantra Store" src="{{skin url="images/logo3.png"}}" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home3 Slider Banner Block',
    'identifier' => 'elantra_home3_slider_banner_block',
    'content' => '<div id="magik-slideshow" class="magik-slideshow">
<div class="container">
<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
<div id="rev_slider_4" class="rev_slider fullwidthabanner">
<ul>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000" data-thumb="{{skin url="images/slide3-img1.jpg"}}"><img alt="" src="{{skin url="images/slide3-img1.jpg"}}" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="280" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Summer</span> 2015</div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="350" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Women Collection</span></div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="580" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Shop Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="480" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
</div>
</li>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000" data-thumb="{{skin url="images/slide3-img2.jpg"}}"><img alt="" src="{{skin url="images/slide3-img2.jpg"}}" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;" data-x="0" data-y="280" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Special day</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="350" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Our elantra Shop</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="580" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Buy Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="480" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</div>
</li>
</ul>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home3 Offer Banner Block',
    'identifier' => 'elantra_home3_offer_banner_block',
    'content' => '<div class="top-offer-banner wow bounceInUp animated animated">
<div class="container">
<div class="row">
<div class="offer-inner col-lg-12">
<div class="left">
<div class="col-1">
<div class="inner-text">
<h3>Hanadbags</h3>
</div>
<a href="#"><img alt="offer banner1" src="{{skin url="images/offer3-banner11.jpg"}}" /></a></div>
<div class="col mid">
<div class="inner-text">
<h3>Watches</h3>
</div>
<a href="#"><img alt="offer banner2" src="{{skin url="images/offer3-banner2.jpg"}}" /></a></div>
<div class="col last">
<div class="inner-text">
<h3>Shoes</h3>
</div>
<a href="#"><img alt="offer banner3" src="{{skin url="images/offer3-banner3.jpg"}}" /></a></div>
</div>
<div class="right">
<div class="col">
<div class="inner-text">
<h4>Super Hot</h4>
<h3>Collection</h3>
</div>
<a href="#"><img alt="offer banner4" src="{{skin url="images/offer3-banner4.jpg"}}" /></a></div>
</div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home3 Banner Block',
    'identifier' => 'elantra_home3_banner_block',
    'content' => "<div class=\"offer-slider wow animated parallax parallax-2 animated\" style=\"visibility: visible;\">
<div class=\"container\">
<h3>elantra Season Sale</h3>
<h2>Women's Collection</h2>
<p>elantra women's clothing store is updated regularly with offers.</p>
<a class=\"shop-now\" href=\"#\">Shop Now</a></div>
</div>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();
$staticBlock = array(
    'title' => 'Elantra Home3 Banner Bottom Block',
    'identifier' => 'elantra_home3_banner_bottom_block',
    'content' => '<div class="our-features-box wow bounceInUp animated animated">
<div class="container">
<ul>
<li>
<div class="feature-box">
<div class="icon-truck">&nbsp;</div>
<div class="content">FREE SHIPPING on order over $99</div>
</div>
</li>
<li>
<div class="feature-box">
<div class="icon-support">&nbsp;</div>
<div class="content">Need Help +1 800 123 1234</div>
</div>
</li>
<li>
<div class="feature-box">
<div class="icon-money">&nbsp;</div>
<div class="content">Money Back Guarantee</div>
</div>
</li>
<li class="last">
<div class="feature-box">
<div class="icon-return">&nbsp;</div>
<div class="content">30 days return Service</div>
</div>
</li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Footer3 Contact Us',
    'identifier' => 'elantra_footer3_contact_us',
    'content' => '<div class="footer-logo"><a href="#"><img alt="footer logo" src="{{skin url="images/footer3-logo.png"}}" /></a></div>
<address>
<div><i class="fa fa-map-marker">&nbsp;</i><span>123 Main Street, Anytown, CA 12345 USA</span></div>
<div><i class="fa fa-phone">&nbsp;</i><span>+(408) 394-7557</span></div>
<div><i class="fa fa-envelope">&nbsp;</i><span>support@magikcommerce.com</span></div>
</address>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Listing Page Block',
    'identifier' => 'elantra_listing_page_block',
    'content' => '<div class="custom-slider">
<div>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
<div class="carousel-inner">
<div class="item active"><img alt="slide3" src="{{skin url="images/slide3.jpg"}}" />
<div class="carousel-caption">
<h3><a title=" Sample Product" href="#">50% OFF</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<a class="link" href="#">Buy Now</a></div>
</div>
<div class="item"><img alt="slide1" src="{{skin url="images/slide1.jpg"}}" />
<div class="carousel-caption">
<h3><a title=" Sample Product" href="#">Hot collection</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>
</div>
<div class="item"><img alt="slide2" src="{{skin url="images/slide2.jpg"}}" />
<div class="carousel-caption">
<h3><a title=" Sample Product" href="#">Summer collection</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>
</div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home4 Shipping Block',
    'identifier' => 'elantra_home4_shipping_block',
    'content' => '<div class="free-shipping">Free Shipping on order over $99</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Logo4',
    'identifier' => 'elantra_logo_4',
    'content' => '<p><img alt="Magento Commerce" src="{{skin url="images/logo4.png"}}" /></p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home4 Slider Banner Block',
    'identifier' => 'elantra_home4_slider_banner_block',
    'content' => "<div id=\"magik-slideshow\" class=\"magik-slideshow\">
<div class=\"container\">
<div id=\"rev_slider_4_wrapper\" class=\"rev_slider_wrapper fullwidthbanner-container\">
<div id=\"rev_slider_4\" class=\"rev_slider fullwidthabanner\">
<ul>
<li data-transition=\"random\" data-slotamount=\"7\" data-masterspeed=\"1000\"><img alt=\"\" src=\"{{skin url=\"images/slide4-img1.jpg\"}}\" data-bgposition=\"left top\" data-bgfit=\"cover\" data-bgrepeat=\"no-repeat\" />
<div class=\"info\">
<div class=\"tp-caption ExtraLargeTitle sft  tp-resizeme \" style=\"z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;\" data-x=\"0\" data-y=\"105\" data-endspeed=\"500\" data-speed=\"500\" data-start=\"1100\" data-easing=\"Linear.easeNone\" data-splitin=\"none\" data-splitout=\"none\" data-elementdelay=\"0.1\" data-endelementdelay=\"0.1\">New Season</div>
<div class=\"tp-caption LargeTitle sfl  tp-resizeme \" style=\"z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;\" data-x=\"0\" data-y=\"150\" data-endspeed=\"500\" data-speed=\"500\" data-start=\"1300\" data-easing=\"Linear.easeNone\" data-splitin=\"none\" data-splitout=\"none\" data-elementdelay=\"0.1\" data-endelementdelay=\"0.1\">Hot Deal</div>
<div class=\"tp-caption sfb  tp-resizeme \" style=\"z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;\" data-x=\"0\" data-y=\"320\" data-endspeed=\"500\" data-speed=\"500\" data-start=\"1500\" data-easing=\"Linear.easeNone\" data-splitin=\"none\" data-splitout=\"none\" data-elementdelay=\"0.1\" data-endelementdelay=\"0.1\"><a class=\"buy-btn\" href=\"#\">Shop Now</a></div>
<div class=\"tp-caption Title sft  tp-resizeme \" style=\"z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;\" data-x=\"0\" data-y=\"250\" data-endspeed=\"500\" data-speed=\"500\" data-start=\"1500\" data-easing=\"Power2.easeInOut\" data-splitin=\"none\" data-splitout=\"none\" data-elementdelay=\"0.1\" data-endelementdelay=\"0.1\">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
</div>
</li>
<li data-transition=\"random\" data-slotamount=\"7\" data-masterspeed=\"1000\"><img alt=\"\" src=\"{{skin url=\"images/slide4-img2.jpg\"}}\" data-bgposition=\"left top\" data-bgfit=\"cover\" data-bgrepeat=\"no-repeat\" />
<div class=\"info\">
<div class=\"tp-caption ExtraLargeTitle sft slide2  tp-resizeme \" style=\"z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;\" data-x=\"0\" data-y=\"105\" data-endspeed=\"500\" data-speed=\"500\" data-start=\"1100\" data-easing=\"Linear.easeNone\" data-splitin=\"none\" data-splitout=\"none\" data-elementdelay=\"0.1\" data-endelementdelay=\"0.1\">Men's</div>
<div class=\"tp-caption LargeTitle sfl slide2  tp-resizeme \" style=\"z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;\" data-x=\"0\" data-y=\"150\" data-endspeed=\"500\" data-speed=\"500\" data-start=\"1300\" data-easing=\"Linear.easeNone\" data-splitin=\"none\" data-splitout=\"none\" data-elementdelay=\"0.1\" data-endelementdelay=\"0.1\">Mega Sale</div>
<div class=\"tp-caption sfb slide2  tp-resizeme \" style=\"z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;\" data-x=\"0\" data-y=\"320\" data-endspeed=\"500\" data-speed=\"500\" data-start=\"1500\" data-easing=\"Linear.easeNone\" data-splitin=\"none\" data-splitout=\"none\" data-elementdelay=\"0.1\" data-endelementdelay=\"0.1\"><a class=\"buy-btn\" href=\"#\">Buy Now</a></div>
<div class=\"tp-caption Title sft slide2  tp-resizeme \" style=\"z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;\" data-x=\"0\" data-y=\"250\" data-endspeed=\"500\" data-speed=\"500\" data-start=\"1500\" data-easing=\"Power2.easeInOut\" data-splitin=\"none\" data-splitout=\"none\" data-elementdelay=\"0.1\" data-endelementdelay=\"0.1\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</div>
</li>
</ul>
</div>
</div>
</div>
</div>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home4 Offer Banner Block',
    'identifier' => 'elantra_home4_offer_banner_block',
    'content' => '<div class="top-banner-section">
<div class="container">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img alt="offer banner1" src="{{skin url="images/block1-home4.jpg"}}" /></a></div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img alt="offer banner2" src="{{skin url="images/block2-home4.jpg"}}" /></a></div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img alt="offer banner3" src="{{skin url="images/block3-home4.jpg"}}" /></a></div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home4 Banner Bottom Block',
    'identifier' => 'elantra_home4_banner_bottom_block',
    'content' => '<div class="full-width-banner home-rhs wow bounceInUp animated">
<div class="container offer-banner"><a href="#"><img alt="offer banner3" src="{{skin url="images/full-width-banner.jpg"}}" /></a></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Footer4 Information Links Block',
    'identifier' => 'elantra_footer4_information_links_block',
    'content' => '<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Shopping Guide</h4>
<ul class="links">
<li class="first"><a title="How to buy" href="{{store_url=blog}}">Blog</a></li>
<li><a title="FAQs" href="#">FAQs</a></li>
<li><a title="Payment" href="#">Payment</a></li>
<li><a title="Shipment" href="#">Shipment</a></li>
<li><a title="Where is my order?" href="#">Where is my order?</a></li>
<li class="last"><a title="Return policy" href="#">Return policy</a></li>
</ul>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Style Advisor</h4>
<ul class="links">
<li class="first"><a title="Your Account" href="{{store_url=customer/account/}}">Your Account</a></li>
<li><a title="Information" href="#">Information</a></li>
<li><a title="Addresses" href="#">Addresses</a></li>
<li><a title="Addresses" href="#">Discount</a></li>
<li><a title="Orders History" href="#">Orders History</a></li>
<li class="last"><a title=" Additional Information" href="#"> Additional Information</a></li>
</ul>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Information</h4>
<ul class="links">
<li class="first"><a title="Site Map" href="{{store_url=catalog/seo_sitemap/category/}}">Site Map</a></li>
<li><a title="Search Terms" href="{{store_url=catalogsearch/term/popular/}}">Search Terms</a></li>
<li><a title="Advanced Search" href="{{store_url=catalogsearch/advanced/}}">Advanced Search</a></li>
<li><a title="History" href="{{store_url=about-us}} ">About Us</a></li>
<li><a title="History" href="{{store_url=contacts}} ">Contact Us</a></li>
<li><a title="Suppliers" href="#">Suppliers</a></li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Footer4 Contact Us',
    'identifier' => 'elantra_footer4_contact_us',
    'content' => '<div class="col-md-3 col-sm-6">
<div class="footer-column-last">
<h4>Contact us</h4>
<div class="contacts-info"><address><i class="add-icon">&nbsp;</i>123 Main Street, Anytown, <br /> &nbsp;CA 12345 USA</address>
<div class="phone-footer"><i class="phone-icon">&nbsp;</i> +1 800 123 1234</div>
<div class="email-footer"><i class="email-icon">&nbsp;</i> <a href="#">support@magikcommerce.com</a></div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Store Logo 2',
    'identifier' => 'elantra_logo_2',
    'content' => '<div><img alt="Elantra Store" src="{{skin url="images/logo2.png"}}" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Header2 Block',
    'identifier' => 'elantra_header2_block',
    'content' => '<div class="our-features-box"><div class="container">
<ul>
<li>
<div class="feature-box"><span class="icon-globe-alt">&nbsp;</span>
<div class="content">
<h3>FREE SHIPPING WORLDWIDE</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
<li class="seprator-line">&nbsp;</li>
<li>
<div class="feature-box"><span class="icon-support">&nbsp;</span>
<div class="content">
<h3>24/7 CUSTOMER SUPPORT</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
<li class="seprator-line">&nbsp;</li>
<li class="last">
<div class="feature-box"><span class="icon-share-alt">&nbsp;</span>
<div class="content">
<h3>RETURNS AND EXCHANGES</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
</ul>
</div>
</div></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home2 Bottom Offer Banner Block',
    'identifier' => 'elantra_home2_bottom_offer_banner_block',
    'content' => '<div class="offer-slider wow animated parallax parallax-2">
<div class="container">
<h3>Elantra Sale</h3>
<h2>up to 25% off <br /> womens collection</h2>
<p>Elantra womens clothing store is updated regularly with offers.</p>
<a class="shop-now" href="#">Shop Now</a></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Logo Brand2 block',
    'identifier' => 'elantra_logo_brand2_block',
    'content' => '<div class="brand-logo wow bounceInUp animated">
<div class="container">
<div class="slider-items-products">
<div id="brand-logo-slider" class="product-flexslider hidden-buttons">
<div class="slider-items slider-width-col6">
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo1.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo2.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo3.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo4.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo5.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo6.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo2.png"}}" /></a></div>
<div class="item"><a href="#x"><img alt="brand-logo" src="{{skin url="images/b-logo3.png"}}" /></a></div>
</div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Footer2 Contact Us',
    'identifier' => 'elantra_footer2_contact_us',
    'content' => '<div style="text-align: center;"><img alt="" src="{{skin url="images/footer-logo2.png"}}" /></div>
<address><span>123 Main Street, Anytown, CA 12345 USA</span> <span> +(408) 394-7557</span> <span> abc@magikcommerce.com</span></address>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Custom2',
    'identifier' => 'elantra_navigation2_block',
    'content' => '<div class="grid12-4">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<p>Our designed to deliver almost everything you want to do online.</p>
<div><img alt="" src="{{skin url="images/home-banner1.jpg"}}" /></div>
</div>
<div class="grid12-4">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<p>Responsive design is a Web design to provide an optimal navigation.</p>
<div><img alt="" src="{{skin url="images/home-banner2.jpg"}}" /></div>
</div>
<div class="grid12-4">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<p>Smart Product Grid is uses maximum available width of the screen.</p>
<div><img alt="" src="{{skin url="images/home-banner3.jpg"}}" /></div>
</div>
<p>&nbsp;</p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Top Links2 Block',
    'identifier' => 'elantra_top_links2_block',
    'content' => '<ul class="dropdown-menu" role="menu">
<li role="presentation"><a role="menuitem" href="#">About Us </a></li>
<li role="presentation"><a role="menuitem" href="#">Customer Service</a></li>
<li role="presentation"><a role="menuitem" href="#">Privacy Policy</a></li>
<li role="presentation"><a role="menuitem" href="#">Site Map</a></li>
<li role="presentation"><a role="menuitem" href="#">Search Terms</a></li>
<li role="presentation"><a role="menuitem" href="#">Advanced Search </a></li>
</ul>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home5 Slider Banner Block',
    'identifier' => 'elantra_home5_slider_banner_block',
    'content' => "<div id=\"rev_slider_4_1_wrapper\" class=\"rev_slider_wrapper fullwidthbanner-container\" style=\"margin: 0px auto; background-color: transparent; padding: 0px; margin-top: 0px; margin-bottom: 0px;\" data-alias=\"classicslider1\"><!-- START REVOLUTION SLIDER 5.0.7 auto mode -->
<div id=\"rev_slider_4_1\" class=\"rev_slider fullwidthabanner\" style=\"display: none;\" data-version=\"5.0.7\">
<ul><!-- SLIDE  -->
<li data-index=\"rs-16\" data-transition=\"zoomout\" data-slotamount=\"default\" data-easein=\"Power4.easeInOut\" data-easeout=\"Power4.easeInOut\" data-masterspeed=\"2000\" data-thumb=\"{{skin url=\"images/slide5-img2.jpg\"}}\" data-rotate=\"0\" data-fstransition=\"fade\" data-fsmasterspeed=\"1500\" data-fsslotamount=\"7\" data-saveperformance=\"off\" data-title=\"Intro\" data-description=\"\"><!-- MAIN IMAGE --> <img alt=\"slide1\" src=\"{{skin url=\"images/slide5-img2.jpg\"}}\" /> <!-- LAYERS --> <!-- LAYER NR. 1 -->
<div id=\"slide-16-layer-1\" class=\"tp-caption NotGeneric-Title slide_1   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 5; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" data-lineheight=\"['70','70','70','50']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:0px;s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1000\" data-splitin=\"chars\" data-splitout=\"none\" data-responsive_offset=\"on\" data-elementdelay=\"0.05\">SEASON SALE</div>
<!-- LAYER NR. 2 -->
<div id=\"slide-16-layer-4\" class=\"tp-caption NotGeneric-SubTitle slide_1   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 6; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['52','52','52','51']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1500\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">Elantra ecommerce store is updated regularly with offers.</div>
<!-- LAYER NR. 3 -->
<div id=\"slide-16-layer-8\" class=\"tp-caption NotGeneric-Icon   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 7; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['-68','-68','-68','-68']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-style_hover=\"cursor:default;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"2000\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">&nbsp;</div>
</li>
<!-- SLIDE  -->
<li data-index=\"rs-17\" data-transition=\"fadetotopfadefrombottom\" data-slotamount=\"default\" data-easein=\"Power3.easeInOut\" data-easeout=\"Power3.easeInOut\" data-masterspeed=\"1500\" data-thumb=\"{{skin url=\"images/slide5-img3.jpg\"}}\" data-rotate=\"0\" data-saveperformance=\"off\" data-title=\"Parallax\" data-description=\"\"><!-- MAIN IMAGE --> <img alt=\"slide2\" src=\"{{skin url=\"images/slide5-img3.jpg\"}}\" /> <!-- LAYERS --> <!-- LAYER NR. 1 -->
<div id=\"slide-17-layer-1\" class=\"tp-caption NotGeneric-Title   tp-resizeme rs-parallaxlevel-3\" style=\"z-index: 5; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['-40','0','0','0']\" data-lineheight=\"['60','70','70','50']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rZ:-35deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:0px;\" data-mask_out=\"x:inherit;y:inherit;\" data-start=\"1000\" data-splitin=\"chars\" data-splitout=\"none\" data-responsive_offset=\"on\" data-elementdelay=\"0.05\">Mens Collection</div>
<!-- LAYER NR. 2 -->
<div id=\"slide-17-layer-4\" class=\"tp-caption NotGeneric-SubTitle   tp-resizeme rs-parallaxlevel-2\" style=\"z-index: 6; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['10','52','52','51']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];\" data-mask_out=\"x:inherit;y:inherit;\" data-start=\"1500\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
<!-- LAYER NR. 3 -->
<div id=\"slide-17-layer-8\" class=\"tp-caption NotGeneric-Icon   tp-resizeme rs-parallaxlevel-1\" style=\"z-index: 7; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['50','100','100','100']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-style_hover=\"cursor:default;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"2000\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\"><a href=\"#\">Learn More</a></div>
<!-- LAYER NR. 4 -->
<div id=\"slide-17-layer-10\" class=\"tp-caption   tp-resizeme rs-parallaxlevel-8\" style=\"z-index: 8;\" data-x=\"['left','left','left','left']\" data-hoffset=\"['680','680','680','680']\" data-y=\"['top','top','top','top']\" data-voffset=\"['632','632','632','632']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:1000;e:Power2.easeInOut;\" data-transform_out=\"opacity:0;s:1000;s:1000;\" data-start=\"2000\" data-responsive_offset=\"on\">
<div class=\"rs-looped rs-pendulum\" data-easing=\"linearEaseNone\" data-startdeg=\"-20\" data-enddeg=\"360\" data-speed=\"35\" data-origin=\"50% 50%\"><img alt=\"slide3\" src=\"{{skin url=\"images/blurflake4-v5.png\"}}\" height=\"240\" width=\"240\" data-ww=\"['240px','240px','240px','240px']\" data-hh=\"['240px','240px','240px','240px']\" data-no-retina=\"\" /></div>
</div>
<!-- LAYER NR. 5 -->
<div id=\"slide-17-layer-11\" class=\"tp-caption   tp-resizeme rs-parallaxlevel-7\" style=\"z-index: 9;\" data-x=\"['left','left','left','left']\" data-hoffset=\"['948','948','948','948']\" data-y=\"['top','top','top','top']\" data-voffset=\"['487','487','487','487']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:1000;e:Power2.easeInOut;\" data-transform_out=\"opacity:0;s:1000;s:1000;\" data-start=\"2000\" data-responsive_offset=\"on\">
<div class=\"rs-looped rs-wave\" data-speed=\"20\" data-angle=\"0\" data-radius=\"50px\" data-origin=\"50% 50%\"><img alt=\"slide4\" src=\"{{skin url=\"images/blurflake3-v5.png\"}}\" height=\"170\" width=\"170\" data-ww=\"['170px','170px','170px','170px']\" data-hh=\"['170px','170px','170px','170px']\" data-no-retina=\"\" /></div>
</div>
<!-- LAYER NR. 6 -->
<div id=\"slide-17-layer-12\" class=\"tp-caption   tp-resizeme rs-parallaxlevel-4\" style=\"z-index: 10;\" data-x=\"['left','left','left','left']\" data-hoffset=\"['719','719','719','719']\" data-y=\"['top','top','top','top']\" data-voffset=\"['200','200','200','200']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:1000;e:Power2.easeInOut;\" data-transform_out=\"opacity:0;s:1000;s:1000;\" data-start=\"2000\" data-responsive_offset=\"on\"><!-- LAYER NR. 7 -->
<div id=\"slide-17-layer-13\" class=\"tp-caption   tp-resizeme rs-parallaxlevel-6\" style=\"z-index: 11;\" data-x=\"['left','left','left','left']\" data-hoffset=\"['187','187','187','187']\" data-y=\"['top','top','top','top']\" data-voffset=\"['216','216','216','216']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:1000;e:Power2.easeInOut;\" data-transform_out=\"opacity:0;s:1000;s:1000;\" data-start=\"2000\" data-responsive_offset=\"on\">
<div class=\"rs-looped rs-wave\" data-speed=\"4\" data-angle=\"0\" data-radius=\"10\" data-origin=\"50% 50%\"><img alt=\"slide6\" src=\"{{skin url=\"images/blurflake1-v5.png\"}}\" height=\"120\" width=\"120\" data-ww=\"['120px','120px','120px','120px']\" data-hh=\"['120px','120px','120px','120px']\" data-no-retina=\"\" /></div>
</div>
</div>
</li>
<!-- SLIDE  -->
<li data-index=\"rs-18\" data-transition=\"zoomin\" data-slotamount=\"7\" data-easein=\"Power4.easeInOut\" data-easeout=\"Power4.easeInOut\" data-masterspeed=\"2000\" data-thumb=\"{{skin url=\"images/slide5-img1.jpg\"}}\" data-rotate=\"0\" data-saveperformance=\"off\" data-title=\"Ken Burns\" data-description=\"\"><!-- MAIN IMAGE --> <img alt=\"slide7\" src=\"{{skin url=\"images/slide5-img1.jpg\"}}\" /> <!-- LAYERS --> <!-- LAYER NR. 1 -->
<div id=\"slide-18-layer-9\" class=\"tp-caption tp-shape tp-shapewrapper   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 5; background-color: rgba(0, 0, 0, 0.75); border-color: rgba(0, 0, 0, 0.50);\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['15','15','15','15']\" data-width=\"500\" data-height=\"140\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:0px;\" data-mask_out=\"x:inherit;y:inherit;\" data-start=\"2000\" data-responsive_offset=\"on\">&nbsp;</div>
<!-- LAYER NR. 2 -->
<div id=\"slide-18-layer-1\" class=\"tp-caption NotGeneric-Title   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 6; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" data-lineheight=\"['70','70','70','50']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:0px;s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1000\" data-splitin=\"chars\" data-splitout=\"none\" data-responsive_offset=\"on\" data-elementdelay=\"0.05\">Sunday Sale</div>
<!-- LAYER NR. 3 -->
<div id=\"slide-18-layer-4\" class=\"tp-caption NotGeneric-SubTitle   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 7; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['52','51','51','31']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1500\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">Lorem ipsum dolor sit amet, consectetur</div>
</li>
<!-- SLIDE  -->
<li data-index=\"rs-19\" data-transition=\"zoomout\" data-slotamount=\"default\" data-easein=\"Power4.easeInOut\" data-easeout=\"Power4.easeInOut\" data-masterspeed=\"2000\" data-thumb=\"{{skin url=\"images/video5-img.jpg\"}}\" data-rotate=\"0\" data-saveperformance=\"off\" data-title=\"HTML5 Video\" data-description=\"\"><!-- MAIN IMAGE --> <img alt=\"slide8\" src=\"{{skin url=\"images/video5-img.jpg\"}}\" /> <!-- LAYERS --> <!-- BACKGROUND VIDEO LAYER -->
<div class=\"rs-background-video-layer\" data-forcerewind=\"on\" data-volume=\"mute\" data-videowidth=\"100%\" data-videoheight=\"100%\" data-videomp4=\"{{skin url='images/bg3.mp4'}}\" data-videowebm=\"{{skin url='images/bg3.webm'}}\" data-videopreload=\"preload\" data-videoloop=\"none\" data-forcecover=\"1\" data-aspectratio=\"16:9\" data-autoplay=\"true\" data-autoplayonlyfirsttime=\"false\" data-nextslideatend=\"true\">&nbsp;</div>
<!-- LAYER NR. 1 -->
<div id=\"slide-19-layer-10\" class=\"tp-caption tp-shape tp-shapewrapper   rs-parallaxlevel-0\" style=\"z-index: 5; background-color: rgba(0, 0, 0, 0.25); border-color: rgba(0, 0, 0, 0);\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" data-width=\"full\" data-height=\"full\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"opacity:0;s:2000;e:Power3.easeInOut;\" data-transform_out=\"opacity:0;s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-start=\"2000\" data-basealign=\"slide\" data-responsive_offset=\"on\" data-responsive=\"off\">&nbsp;</div>
<!-- LAYER NR. 2 -->
<div id=\"slide-19-layer-1\" class=\"tp-caption NotGeneric-Title   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 6; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" data-lineheight=\"['70','70','70','50']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;s:1500;e:Power3.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1000\" data-splitin=\"chars\" data-splitout=\"none\" data-responsive_offset=\"on\" data-elementdelay=\"0.05\">Fresh Arrivals</div>
<!-- LAYER NR. 3 -->
<div id=\"slide-19-layer-4\" class=\"tp-caption NotGeneric-SubTitle   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 7; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['52','52','52','51']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"1500\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">Lorem ipsum dolor sit amet, consectetur</div>
<!-- LAYER NR. 4 -->
<div id=\"slide-19-layer-8\" class=\"tp-caption NotGeneric-Icon   tp-resizeme rs-parallaxlevel-0\" style=\"z-index: 8; white-space: nowrap;\" data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['-68','-68','-68','-68']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-transform_idle=\"o:1;\" data-style_hover=\"cursor:default;\" data-transform_in=\"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;\" data-transform_out=\"y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;\" data-mask_in=\"x:0px;y:[100%];s:inherit;e:inherit;\" data-mask_out=\"x:inherit;y:inherit;s:inherit;e:inherit;\" data-start=\"2000\" data-splitin=\"none\" data-splitout=\"none\" data-responsive_offset=\"on\">&nbsp;</div>
</li>
<!-- SLIDE  --></ul>
<div class=\"tp-static-layers\">&nbsp;</div>
<div class=\"tp-bannertimer\" style=\"height: 7px; background-color: rgba(255, 255, 255, 0.25);\">&nbsp;</div>
</div>
</div>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Header5 Block',
    'identifier' => 'elantra_header5_block',
    'content' => '<div id="categories-section">
<div class="container clearfix">
<ul class="banner-images">
<li class="grid right-space two-height">
<figure class="effect wow fadeInLeft"><img alt="Category" src="{{skin url="images/banner5-img1.jpg"}}" /> <figcaption>
<div class="banner-images_content">
<h2><strong>Designer</strong> Bags</h2>
</div>
<a href="#">View more</a> </figcaption></figure>
</li>
<li class="grid two-width">
<figure class="effect wow fadeInRight"><img alt="Category" src="{{skin url="images/banner5-img2.jpg"}}" /> <figcaption>
<div class="banner-images_content">
<h2><strong>Summer</strong> Season</h2>
</div>
<a href="#">View more</a> </figcaption></figure>
</li>
<li class="grid right-space">
<figure class="effect wow fadeInUp"><img alt="Category" src="{{skin url="images/men5.jpg"}}" /> <figcaption>
<div class="banner-images_content">
<h2><strong>Mens</strong> Collection</h2>
</div>
<a href="#">View more</a> </figcaption></figure>
</li>
<li class="grid">
<figure class="effect wow fadeInRight"><img alt="Category" src="{{skin url="images/banner5-img4.jpg"}}" /> <figcaption>
<div class="banner-images_content">
<h2><strong>Womens</strong> Collection</h2>
</div>
<a href="#">View more</a> </figcaption></figure>
</li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home5 Bottom Offer Banner Block',
    'identifier' => 'elantra_home5_bottom_offer_banner_block',
    'content' => '<div class="offer-slider wow animated parallax parallax-2">
<div class="container">
<div class="offer-info">
<h3><span><strong>Elantra</strong> Sale </span></h3>
<h2>up to 25% off womens collection</h2>
<p>Elantra womens clothing store is updated regularly with offers.</p>
<a class="shop-now" href="#">Shop Now</a></div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home5 Bottom Banner Block',
    'identifier' => 'elantra_home5_bottom_banner_block',
    'content' => '<div class="our-features-box">
<div class="container">
<ul>
<li>
<div class="feature-box"><span class="icon-globe-alt">&nbsp;</span>
<div class="content">
<h3>FREE SHIPPING WORLDWIDE</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
<li class="seprator-line"></li>
<li>
<div class="feature-box"><span class="icon-support">&nbsp;</span>
<div class="content">
<h3>24/7 CUSTOMER SUPPORT</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
<li class="seprator-line"></li>
<li class="last">
<div class="feature-box"><span class="icon-share-alt">&nbsp;</span>
<div class="content">
<h3>RETURNS AND EXCHANGES</h3>
<p>Lorem ipsum dolor sit amet, adipiscing elit.</p>
</div>
</div>
</li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Footer5 Contact Us',
    'identifier' => 'elantra_footer5_contact_us',
    'content' => '<div style="text-align: center;"><img alt="footer img" src="{{skin url="images/footer-logo5.png"}}" /></div>
<address><span>123 Main Street, Anytown, CA 12345 USA</span> <span> +(408) 394-7557</span> <span> abc@magikcommerce.com</span></address>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Custom',
    'identifier' => 'elantra_navigation5_block',
    'content' => '<div class="grid12-4">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<p>Our designed to deliver almost everything you want to do online.</p>
<div><img alt="img" src="{{skin url="images/home-banner1.jpg"}}" /></div>
</div>
<div class="grid12-4">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<p>Responsive design is a Web design to provide an optimal navigation.</p>
<div><img alt="img" src="{{skin url="images/home-banner2.jpg"}}" /></div>
</div>
<div class="grid12-4">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<p>Smart Product Grid is uses maximum available width of the screen.</p>
<div><img alt="img" src="{{skin url="images/home-banner3.jpg"}}" /></div>
</div>
<p>&nbsp;</p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Custom',
    'identifier' => 'elantra_navigation3_block',
    'content' => '<div class="grid12-3">
<h4 class="heading">Get 20% Off, 48 Hours Only!</h4>
<p>Our designed to deliver almost everything you want to do online.</p>
<div><img alt="custom-image" src="{{skin url="images/custom-img1.jpg"}}" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">Flat 20% On Selected Items!</h4>
<p>Responsive design is a Web design to provide an optimal navigation.</p>
<div><img alt="custom-image" src="{{skin url="images/custom-img2.jpg"}}" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">Hot Womens Collection!</h4>
<p>Our font delivery service is built upon a reliable, global network of servers.</p>
<div><img alt="custom-image" src="{{skin url="images/custom-img3.jpg"}}" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">New Arrivals!</h4>
<p>Smart Product Grid is uses maximum available width of the screen.</p>
<div><img alt="custom-image" src="{{skin url="images/custom-img4.jpg"}}" /></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Elantra Home4 Tab Dropdown Block',
    'identifier' => 'elantra_home4_tab_dropdown_block',
    'content' => '<ul class="submenu">
<li><a href="http://mas1.magikcommerce.com/index.php/elantra">Home Version 1</a></li>
<li><a href="http://mas1.magikcommerce.com/index.php/elantrademo2">Home Version 2</a></li>
<li><a href="http://mas1.magikcommerce.com/index.php/elantrademo3">Home Version 3</a></li>
<li><a href="http://mas1.magikcommerce.com/index.php/elantrademo4">Home Version 4</a></li>
<li><a href="http://mas1.magikcommerce.com/index.php/elantrademo5">Home Version 5</a></li>
</ul>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

}
catch (Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while installing Elantra theme pages and cms blocks.'));
}