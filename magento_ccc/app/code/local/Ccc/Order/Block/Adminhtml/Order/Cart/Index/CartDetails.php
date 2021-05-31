<?php  

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_CartDetails extends Mage_Adminhtml_Block_Template
{
	protected $cart;
	protected $subtotal = 0;
    protected $finaltotal = 0;
	public function __construct()
	{
        parent::__construct();
		$this->setTemplate('order/cart/index/cartdetails.phtml');
	}

	public function setCart(Ccc_Order_Model_Order_Cart $cart)
	{
		$this->cart = $cart;
		return $this;
	}
	public function getCart()
	{
		return $this->cart;
	}

   
    public function setSubtotal(){
        $cart = $this->getCart();
        $items = $cart->getItems();
        foreach($items as $key=>$item){
            $this->subtotal += $this->getTotalByQuantityPrice($item['quantity'],$item['base_price']);
        }
        return $this;
    }

    public function getSubTotal(){
        if(!$this->subtotal){
            $this->setSubtotal();
        }
        return $this->subtotal;
    }

    public function getTotalByQuantityPrice($quantity, $price){
        return $quantity*$price;
    }

    public function getShippingAmount(){
        if($amount = $this->getCart()->getShippingAmount()){
            return $amount;
        }
        return 0;
    }

    public function getFinalTotal(){
        return $this->getSubTotal() + $this->getShippingAmount();
    }

    public function getSaveUrl(){
        return $this->getUrl('*/adminhtml_order_cart/placeOrder',array('_current'=>true));
    }
}

?>