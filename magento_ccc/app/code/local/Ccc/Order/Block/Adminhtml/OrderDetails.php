<?php  


class Ccc_Order_Block_Adminhtml_OrderDetails extends Mage_Core_Block_Template
{
    protected $order;
    protected $subtotal = 0;
    protected $finaltotal = 0;
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('order/orderdetails.phtml');
    }

    public function getOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        return Mage::getModel('order/order')->load($id);
    }

    public function setSubtotal(){
        $order = $this->getOrder();
        $items = $order->getItems();
        foreach($items as $key=>$item){
            $this->subtotal += $this->getTotalByQuantityPrice($item['quantity'],$item['price']/$item['quantity']);
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
        if($amount = $this->getOrder()->getShippingAmount()){
            return $amount;
        }
        return 0;
    }

    public function getFinalTotal(){
        return $this->getSubTotal() + $this->getShippingAmount();
    }

}

?>