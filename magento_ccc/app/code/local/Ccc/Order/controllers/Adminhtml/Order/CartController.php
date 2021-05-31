<?php 

class Ccc_Order_Adminhtml_Order_CartController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        try{

            $cart = $this->_getCart();
            $this->loadLayout();
            $block = $this->getLayout()->getBlock('cart');
            $block->setCart($cart);
            $this->renderLayout();

        }catch(Exception $e){
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }

    }

    protected function _getCart() {
        $customerId =  $this->getRequest()->getParam('id');
        $customer = Mage::getModel('customer/customer')->load($customerId);

        if (!$customer->getId()) {
            throw new Exception('Customer not found');
        }

        $session = Mage::getModel('order/session');
        $session->setCustomerId($customerId);

        $cart = Mage::getModel('order/order_cart')->load($customerId, 'customer_id');
        if ($cart->getId()) {
            return $cart;
        }
        $cart->customer_id = $customerId;
        $cart->created_at = date('Y-m-d H:i:s');
        $cart->save();
        return $cart;
    }

    protected function getItemIds($cart){
        $ids = [];
        $collection = Mage::getModel('order/order_cart_item')->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$cart->getId()]);
        if($collection->count()){
            foreach($collection->getData() as $key=>$value){
                $ids[$value['cart_item_id']] = $value['product_id'];
            }
        }
        return $ids;
    }

    protected function calculatePrice($price, $quantity){
        return $price * $quantity;
    }

    public function AddToCartAction(){

        $products = $this->getRequest()->getParam('product');
        $cart = $this->_getCart();
        $itemIds = $this->getItemIds($cart);
        if($products){
            foreach($products as $key=>$id){
                $product = Mage::getModel('catalog/product')->load($id);

                if(in_array($id,$itemIds)){
                    $cartItem = Mage::getModel('order/order_cart_item')->load(array_search($id,$itemIds));
                    $cartItem->quantity++;
                    $price = $this->calculatePrice($cartItem->getBasePrice(),$cartItem->getQuantity());
                    $cartItem->setPrice($price);
                }else{
                    $cartItem = Mage::getModel('order/order_cart_item');
                    $cartItem->setCartId($cart->getId());
                    $cartItem->setProductId($id);
                    $cartItem->setQuantity(1);
                    $cartItem->setBasePrice($product->getPrice());
                    $cartItem->setPrice($product->getPrice());
                    date_default_timezone_set('Asia/Kolkata');
                    $cartItem->setCreatedAt(date('Y-m-d H:i:s'));
                }
                $cartItem->save();
             //   $this->_getSession()->setData('showGrid',1);
            }
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Product is Added Successfully');
        $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));
    }

    public function updateAddressAction()
    {
        $cart = $this->_getCart();
        if ($this->getRequest()->getParam('type') == "billing") {
            $billingAddressData = $this->getRequest()->getPost('billing');
            $billingAddress = $cart->getCartBillingAddress();
            $billingAddress->addData($billingAddressData);
            $billingAddress->setCartId($cart->getId());
            $billingAddress->setAddressType(1);
            $billingAddress->save();
            if ($this->getRequest()->getPost('save_to_billing_address')) {
                $customerAddressBook = $cart
                                    ->getCustomer()
                                    ->getBillingAddress();
                $customerAddressBook->setData($billingAddressData);
                $customerAddressBook->parent_id = $cart->customer_id;
                $customerAddressBook->save();   

            }
        Mage::getSingleton('adminhtml/session')->addSuccess('Billing Address Saved Successfully');
        } else {
            
            $shippingAddress =$cart->getCartShippingAddress();
            
            if ($this->getRequest()->getPost('same_as_billing')) {
                $shippingAddress->setSameAsBilling(1);
            }   
            $shippingAddressData = $this->getRequest()->getPost('shipping');
            $shippingAddress->addData($shippingAddressData);
            $shippingAddress->setCartId($cart->getId());
            $shippingAddress->setAddressType(2);
            $shippingAddress->save();
            if ($this->getRequest()->getPost('save_to_shipping_address')) {
                $customerAddressBook = $cart
                                    ->getCustomer()
                                    ->getShippingAddress();
                $customerAddressBook->setData($shippingAddressData);
                $customerAddressBook->parent_id = $cart->customer_id;
                $customerAddressBook->save();                   
            
            }
        Mage::getSingleton('adminhtml/session')->addSuccess('Shipping Address Saved Successfully');
        }
        $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));

    
    }

    public function updateShippingAction()
    {
       $data = $this->getRequest()->getPost('shippingMethod');
        $data = explode('_',$data);
        if($data){
            $cart = $this->_getCart();
            $cart->setShipmentCode($data[0]);
            $cart->setShippingAmount($data[1]);
            $cart->save();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Shipping Method Saved');
        $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));
    

    }

    public function updatePaymentAction()
    {
        
        $data = $this->getRequest()->getPost('payment');
        if($data){
            $cart = $this->_getCart();
            $cart->setPaymentCode($data);
            $cart->save();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Payment Method Saved');
        $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));

    }

     public function changeQuantityAction(){
        $data = $this->getRequest()->getPost('quantity');
        if($data){
            foreach($data as $itemId=>$quantity){
                $model = Mage::getModel('order/order_cart_item')->load($itemId);
                if($quantity<=0){
                    $model->delete();
                    continue;
                }
                $model->setQuantity($quantity);
                $price = $this->calculatePrice($model->getBasePrice(), $quantity);
                $model->setPrice($price);
                $model->save();
            }
        }
        $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));

    }

    public function deleteAction(){
        $id = $this->getRequest()->getParam('itemId');
        $customerId = $this->getRequest()->getParam('id');
        try{
            $model = Mage::getModel('order/order_cart_item')->load($id);
            if(!$model){
                throw new Exception("Product Not Found!!");
            }
            $model->delete();
        }catch(Exception $e){
            echo $e->getMessage();
        }
        $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));
        
    }

    protected function getCartTotal($items,$shipping){
        $total = 0;
        if($items){
            foreach($items as $key=>$item){
                $total += $this->calculatePrice($item['quantity'],$item['base_price']);
            }
        }
        $total += $shipping;
        return $total;
    }
    
    public function placeOrderAction()
    {
        //echo 1; die();
        $cart = $this->_getCart();
        $cartItems = $cart->getItems();
        $billingAddress = $cart->getCartBillingAddress();
        $shippingAddress = $cart->getCartShippingAddress();

        if($cartItems->count() <= 0){
            Mage::getSingleton('adminhtml/session')->addError('Please Add At Least One Item');
            $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));
            return;
        }
        if(!$billingAddress){
            Mage::getSingleton('adminhtml/session')->addError('Please Fill The Billing Address');
            $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));
            return;
        }
        if(!$shippingAddress){
            Mage::getSingleton('adminhtml/session')->addError('Please Fill The Shipping Address');
            $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));
            return;
        }

        if(!$cart->getShipmentCode()){
            Mage::getSingleton('adminhtml/session')->addError('Please Select Shipping Method');
            $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));
            return;
        }
        if(!$cart->getPaymentCode()){
            Mage::getSingleton('adminhtml/session')->addError('Please Select Payment Method');
            $this->_redirect('*/adminhtml_order_cart/index',array('_current' => true));
            return;
        }

        $total = $this->getCartTotal($cartItems,$cart->getShippingAmount());
        $cart->setTotal($total);
        $cart->save();

        $orderModel = Mage::getModel('order/order');
        $orderModel->setData($cart->getData());
        unset($orderModel['cart_id']);
        date_default_timezone_set('Asia/Kolkata');
        $orderModel->setCreatedAt(date('Y-m-d H:i:s'));
        $orderModel->setCustomerName($billingAddress->getFirstname().' '.$billingAddress->getLastname());
        $orderModel->save();


        foreach($cartItems as $key=>$item){
            $orderItemModel = Mage::getModel('order/order_item')
                                ->setData($item->getData());

            unset($orderItemModel['cart_item_id']);
            unset($orderItemModel['cart_id']);
            $orderItemModel->setOrderId($orderModel->getId());
            $orderItemModel->save();
            $item->delete();
            
        }

        $orderAddress = Mage::getModel('order/order_address');
        $orderAddress->setData($billingAddress->getData());
        //print_r($billingAddress); 
        unset($orderAddress['cart_id']);
        unset($orderAddress['cart_address_id']);
        unset($orderAddress['address_id']);
        $orderAddress->setOrderId($orderModel->getId());
        $orderAddress->setCreatedAt(date('Y-m-d H:i:s'));
        $orderAddress->save();
        Mage::getModel('order/order_cart_address')->load($billingAddress['cart_address_id'])->delete();


        $orderAddress = Mage::getModel('order/order_address');
        $orderAddress->setData($shippingAddress->getData());
        unset($orderAddress['cart_id']);
        unset($orderAddress['cart_address_id']);
        $orderAddress->setOrderId($orderModel->getId());
        $orderAddress->setCreatedAt(date('Y-m-d H:i:s'));
        $orderAddress->save();
        $addressModel = Mage::getModel('order/order_cart_address')->load($shippingAddress['cart_address_id'])->delete();

        $cart->delete();

        Mage::getSingleton('adminhtml/session')->addSuccess("Your Order Is Placed");
        $this->_redirect('*/adminhtml_order/index');
    }
}

?>