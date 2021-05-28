<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Account extends Mage_Core_Block_Template {
    protected $cart;
    public function _construct() {
        $this->setTemplate('order/cart/index/account.phtml');
    }

    public function setCart(Ccc_Order_Model_Order_Cart $cart) {
        $this->cart = $cart;
        return $this;
    }

    public function getCart() {
        if (!$this->cart) {
            return false;
        }
        return $this->cart;
    }
}

?>