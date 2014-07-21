<?php

/**
 * GlixGalore Checkout Block
 * 
 * @category   Shopix
 * @package    Shopix_ClixGalore
 * @author     Lucas van Staden (sales@proxiblue.com.au)
 */
class Shopix_ClixGalore_Block_Checkout_Success extends Mage_Checkout_Block_Onepage_Success {

    const PRODUCTION_URL = 'https://www.clixGalore.com/AdvTransaction.aspx';

    /**
     * The url (is there a testing site??)
     * @return type
     */
    public function getProdUrl() {
	return self::PRODUCTION_URL;
    }

    /**
     * Get The account Id from Config
     * @return string
     */
    public function getAccountId() {
	return $this->escapeHtml(Mage::getStoreConfig('checkout/clixgalore/adid'));
    }

    /**
     * Return the url params
     *
     * @return mixed boolean|string
     */
    public function getUrlParams() {
	if ($this->getOrderId() && $this->getAccountId()) {
	    $_order = Mage::getModel('sales/order')->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
	    $_value = $_order->getGrandTotal() - $_order->getShippingAmount();

	    $params = http_build_query(array('AdID' => $this->getAccountId(),
		'SV' => $_value,
		'OID' => $_order->getIncrementId()), '', '&amp;');

	    return $params;
	}
	return false;
    }

}
