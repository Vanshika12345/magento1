<?php 
class Ccc_Order_Model_Order_Cart extends Mage_Core_Model_Abstract
{

	protected $_customer;
	protected $billingAddress;
	protected $shippingAddress;
	protected $totals = [
		'subtotal' =>['amount' => 0, 'label' => 'SubTotal'],
		'shippping_amount' =>['amount' => 0, 'label' => 'Shipping Amount'],
		'discount' =>['amount' => 0, 'label' => 'Discount'],
		'grandtotal' =>['amount' => 0, 'label' => 'Grand Total']
	];
	function _construct()
	{
		$this->_init('order/order_cart');
	}


	public function setCustomer(Mage_Customer_Model_Customer $customer)
    {
        $this->_customer = $customer;
        return $this;
    }

	public function getCustomer() {
		if ($this->_customer) {
			return $this->_customer;
		}
		$customer = Mage::getModel('customer/customer')->load($this->customer_id);
		$this->setCustomer($customer);
		return $this->_customer;

	}

	public function getCartItems()
	{
		$cartItem = Mage::getModel('order/order_cart_item');
		$collection = $cartItem->getCollection();
		$select = $collection->getSelect()
				->reset(Zend_Db_Select::FROM)->reset(Zend_Db_Select::COLUMNS)->from('cart_item')->where('cart_id = ?',$this->getCartId());
		/*foreach ($collection as $model) {
			return $model;
		}*/
		// die();
		 $collection->getResource()->getReadConnection()->fetchAll($select);	
		return $collection;
	}
	public function setBillingAddress(Ccc_Order_Model_Order_Cart_Address $billingAddress)
	{
		$this->billingAddress = $billingAddress;
		return $this;
	}

	public function getBillingAddress()
	{
		$cartAddress = Mage::getModel('order/order_cart_address');
		$collection = $cartAddress->getCollection();
		
		$select = $collection->getSelect()->reset(Zend_Db_Select::FROM)->reset(Zend_Db_Select::COLUMNS)->from('cart_address')->where('cart_id = ?',$this->cart_id)->where('address_type = ?',1);
		$cartAddress->getResource()->getReadConnection()->fetchRow($select);
		
			$this->setBillingAddress($cartAddress);
		return $this->billingAddress;
	}

	public function setShippingAddress(Ccc_Order_Model_Order_Cart_Address $shippingAddress)
	{
		$this->shippingAddress = $shippingAddress;
		return $this;	
	}
	public function getShippingAddress()
	{
		$cartAddress = Mage::getModel('order/order_cart_address');
		$collection = $cartAddress->getCollection();
		
		$select = $collection->getSelect()->reset(Zend_Db_Select::FROM)->reset(Zend_Db_Select::COLUMNS)->from('cart_address')->where('cart_id = ?',$this->cart_id)->where('address_type = ?',2);
		$cartAddress->getResource()->getReadConnection()->fetchRow($select);
			$this->setShippingAddress($cartAddress);
		return $this->shippingAddress;
	}

	public function getPaymentMethod()
	{
		$payments = Mage::getSingleton('payment/config')->getActiveMethods();
		
		foreach ($payments as $paymentCode=>$paymentModel) {
		    $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
		    $methods[$paymentCode] = array(
		        'label'   => $paymentTitle,
		        'value' => $paymentCode,
		    );
		}
		return $methods;
	}

	public function getShipmentMethod()
	{
		$methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
		foreach ($methods as $shippingMethodCode => $shippingMethod) 
		{	
			$price = $shippingMethod->getConfigData('price');
			 $shippingTitle[$shippingMethodCode] = [Mage::getStoreConfig('carriers/'.$shippingMethodCode.'/title'),$price];
		}
		//return $price;
		return $shippingTitle;
	}

	public function calculateTotal()
	{
		$this->calculateSubTotal();
		$this->calculateShippingAmount();
		$this->calculateDiscount();
		$this->calculateGrandTotal();
	}
	public function calculateSubTotal()
	{
		$subTotal = 0;
		$items = $this->getCartItems();
		foreach ($items as $key => $item) {
				$subTotal += $item->quantity * $item->getProduct()->price;
		}
		$this->totals['subtotal']['amount'] = $subTotal;
	}

	public function calculateShippingAmount()
	{
		/*$subTotal = 0;
		$items = $this->getCartItems();
		foreach ($items as $key => $item) {
				$subTotal += $item->quantity * $item->getProduct()->price;
		}
		$this->total['subtotal'] = $subTotal;*/
	}

	public function calculateDiscount()
	{
		$discountTotal = 0;
		$items = $this->getCartItems();
		foreach ($items as $key => $item) {
				$discountTotal += $item->getProduct()->price - $item->discount;
		}
		$this->totals['discount']['amount'] = $discountTotal;
	}

	public function calculateGrandTotal()
	{
		$grandTotal = ($this->calculateSubTotal()+$this->calculateShippingAmount()) - $this->calculateDiscount();
		$this->totals['grandtotal']['amount'] = $grandTotal;		
	}
}

?>