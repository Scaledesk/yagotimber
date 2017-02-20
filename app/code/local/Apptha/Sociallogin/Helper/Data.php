<?php
/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_Marketplace
 * @version     1.2.3
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2014 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 * 
 */

/**
 * This file is used to get twitter url and license key functionality
 * 
 * In this class, get twitter url and license key operations are included.
 */

class Apptha_Sociallogin_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Get Twitter authendication URL
     * 
     * @return string Twitter authendication URL
     */
    public function getTwitterUrl($data) {
        require'sociallogin/twitter/twitteroauth.php';
        require 'sociallogin/config/twconfig.php';

        $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET);

        /**
         * Request to authendicate token, the @param string URL redirects the authorize page
         */
        if($data == 1){
             $requestToken = $twitteroauth->getRequestToken(Mage::getBaseUrl() . 'sociallogin/index/twitterlogin?fb=1');
        } else {
            $requestToken = $twitteroauth->getRequestToken(Mage::getBaseUrl() . 'sociallogin/index/twitterlogin');
        }
        if ($twitteroauth->http_code == 200) {
            $twOauthToken = Mage::getSingleton('customer/session')->setTwToken($requestToken['oauth_token']);
            $twOauthTokenSecret = Mage::getSingleton('customer/session')->setTwSecret($requestToken['oauth_token_secret']);
            return $twitteroauth->getAuthorizeURL($requestToken['oauth_token']);
        }
    }

    /**
     * Check license key 
     * 
     * @return bool either True | False
     */
    public function checkSocialloginkey() {
        $genKey = $this->socialloginKey();
        $license = Mage::getStoreConfig('sociallogin/general/license');

        if ($genKey == $license) {
            return true;
        } else {
            return false;
        }
    }
   /**
     * Generates the Social login Key
     * 
     * @return string social login license key message
     */
    public function socialloginKey() {

        $code = $this->genenrateOscdomain();
        $domainKey = substr($code, 0, 25) . "CONTUS";
        return $domainKey;
    }
    /**
     * Generates the Domain Key
     * 
     * @return string $enc_message
     */
    public function domainKey($tkey) {

       $message = "EM-MKTPMP0EFIL9XEV8YZAL7KCIUQ6NI5OREH4TSEB3TSRIF2SI1ROTAIDALG-JW";
        $lentkey = strlen($tkey);
        for ($i = 0; $i < $lentkey; $i++) {
            $key_array[] = $tkey[$i];
        }
        $enc_message = "";
        $kPos = 0;
        $chars_str = "WJ-GLADIATOR1IS2FIRST3BEST4HERO5IN6QUICK7LAZY8VEX9LIFEMP0";
        $lenstrchnars = strlen($chars_str);
        for ($i = 0; $i < $lenstrchnars; $i++) {
            $chars_array[] = $chars_str[$i];
        }
        $lenmessage = strlen($message);
        $countKeyArray = count($key_array);
        for ($i = 0; $i < $lenmessage; $i++) {
            $char = substr($message, $i, 1);

            $offset = $this->getOffset($key_array[$kPos], $char);
            $enc_message .= $chars_array[$offset];
            $kPos++;

            if ($kPos >= $countKeyArray) {
                $kPos = 0;
            }
        }

        return $enc_message;
    }
    /**
     * Get offset from character string
     * 
     * @return integer $offset
     */
    public function getOffset($start, $end) {

        $charsStr = "WJ-GLADIATOR1IS2FIRST3BEST4HERO5IN6QUICK7LAZY8VEX9LIFEMP0";
        $countcharstr = strlen($charsStr);
        for ($i = 0; $i < $countcharstr; $i++) {
            $charsArray[] = $charsStr[$i];
        }
        $countcharsArray = count($charsArray);
        for ($i = $countcharsArray - 1; $i >= 0; $i--) {
            $lookupObj[ord($charsArray[$i])] = $i;
        }

        $sNum = $lookupObj[ord($start)];
        $eNum = $lookupObj[ord($end)];

        $offset = $eNum - $sNum;

        if ($offset < 0) {
            $counrArray = count($charsArray);
            $offset = $counrArray + ($offset);
        }

        return $offset;
    }
    /**
     * Generates the Domain 
     * 
     * @return string $response
     */
    public function genenrateOscdomain() {

        $strDomainName = Mage::app()->getFrontController()->getRequest()->getHttpHost();
        preg_match("/^(http:\/\/)?([^\/]+)/i", $strDomainName, $subfolder);
        preg_match("/^(https:\/\/)?([^\/]+)/i", $strDomainName, $subfolder);
        preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $subfolder[2], $matches);
        if (isset($matches['domain'])) {
            $customerurl = $matches['domain'];
        } else {
            $customerurl = "";
        }
        $customerurl = str_replace("www.", "", $customerurl);
        $customerurl = str_replace(".", "D", $customerurl);
        $customerurl = strtoupper($customerurl);
        if (isset($matches['domain'])) {
            $response = $this->domainKey($customerurl);
        } else {
            $response = "";
        }
        return $response;
    }

}