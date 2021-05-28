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
		/*print_r($customerId);
		die();*/
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
                $ids[$value['item_id']] = $value['product_id'];
            }
        }
        return $ids;
    }

    protected function calculatePrice($price, $quantity){
        return $price * $quantity;
    }

	public function AddToCartAction()
	{
		try {
			$cart =  $this->_getCart();
			$items = $this->getRequest()->getPost('addItem');
			$itemId = $this->getItemIds($cart);
			if($items){
				foreach($items as $id=>$status){
                	$product = Mage::getModel('catalog/product')->load($id);

                	if(in_array($id,$itemId)){
                    $cartItem = Mage::getModel('order/order_cart_item')->load(array_search($id,$itemId));
                    $cartItem->quantity++;
                    $price = $this->calculatePrice($cartItem->getBasePrice(),$cartItem->getQuantity());
                    $cartItem->setPrice($price);
                	
                	}else{
                    $cartItem = Mage::getModel('order/order_cart_item');
                    $cartItem->setCartId($cart->getId());
                    $cartItem->setProductId($id);
                    $cartItem->setBasePrice($product->getPrice());
                    $cartItem->setPrice($product->getPrice());
                    date_default_timezone_set('Asia/Kolkata');
                    $cartItem->setCreatedAt(date('Y-m-d  H:i:s'));
                }

                $cartItem->save();
            	}
		$product = $this->getLayout()->createBlock('order/adminhtml_order_cart_index_product')->toHtml();
        $cartDetails = $this->getLayout()->createBlock('order/adminhtml_order_cart_index_cartDetails')->toHtml();
        $response = [
            'status' => 'success',
            'message' => 'cart Created',
            'elements'=> [  
                [
                    'selector' => '#productContent',
                    'html' => $product
                ],
                [
                    'selector' => '#cartDetails',
                    'html' => $cartDetails
                ]
            ]
        ];
        header("Content-type:application/json");
        echo json_encode($response);
			}
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
	}

	public function updateAddressAction()
    {
    	$cart = $this->_getCart();
        $cartId = $cart->cart_id;
        if ($this->getRequest()->getParam('type') == "billing") {
            $billingAddressData = $this->getRequest()->getPost('billing');
            $billingAddress = $cart->getBillingAddress();
            $billingAddress->addData($billingAddressData);
            $billingAddress->setId($billingAddress->getId());
            $billingAddress->save();
            if ($this->getRequest()->getPost('billingAddressBook')) {
                $customerAddressBook = $cart
                                    ->getCustomer()
                                    ->getDefaultBillingAddress();
                $customerAddressBook->setData($billingAddressData);
                $customerAddressBook->parent_id = $cart->customer_id;
                $customerAddressBook->save();                   
            }
        } else {
            
            if ($this->getRequest()->getPost('sameAsBilling')) {
                $shippingAddressData = $this->getRequest()->getPost('billing');
            } else {
                $shippingAddressData = $this->getRequest()->getPost('shipping');
            }
            
            $shippingAddress =$cart->getShippingAddress();
            $shippingAddress->setData($shippingAddressData);
            $shippingAddress->sameAsBilling = 1;
            $shippingAddress->save();
            if ($this->getRequest()->getPost('shippingAddressBook')) {
                $customerAddressBook = $cart
                                    ->getCustomer()
                                    ->getPrimaryShippingAddress();
                $customerAddressBook->setData($shippingAddressData);
                $customerAddressBook->parent_id = $cart->customer_id;
                $customerAddressBook->save();                   
            }
        }
        $address = $this->getLayout()->createBlock('order/adminhtml_order_cart_index_address')->toHtml();
        $response = [
            'status' => 'success',
            'message' => 'i am excellent',
            'elements'=> [
                [
                    'selector' => '#addressContent',
                    'html' => $address
                ]
            ]
        ];
        header("Content-type:application/json");
        echo json_encode($response);
      
    }

	public function updateShippingAction()
	{
		$methodId = $this->getRequest()->getPost('shippingMethod');
        $cart = $this->_getCart();
        $cartId = $this->_getCart()->cartId;
        $cartClone = clone $cart;
        $cart->cartId = $cartId;
        $cart->shipment_code = $methodId;
        $cart->save();
        $cartClone->cart_id = $cartId;
        $cartClone->shippingAmount = $cart->getShippingMethod()->amount;
        $cartClone->save();

        $shipping =  $this->getLayout()->createBlock('order/adminhtml_order_cart_index_shipping')->toHtml();
        $cartDetails =  $this->getLayout()->createBlock('order/adminhtml_order_cart_index_cartDetails')->toHtml();
        $response = [
            'status' => 'success',
            'message' => 'i am excellent',
            'elements'=> [
                [
                    'selector' => '#shippingContent',
                    'html' => $shipping
                ],
                [
                    'selector' => '#cartDetails',
                    'html' => $cartDetails
                ]
            ]
        ];
        header("Content-type:application/json");
        echo json_encode($response);

	}

	public function updatePaymentAction()
	{
		$methodId = $this->getRequest()->getPost('paymentMethod');
        $cartId = $this->_getCart()->cart_id;
		$cart = Mage::getModel('order/order_cart');
		$cart->cart_id = $cartId;
		$cart->payment_code = $methodId;
		$cart->save();

	
		$payment = $this->getLayout()->createBlock('order/adminhtml_order_cart_index_payment')->toHtml();
        $response = [
            'status' => 'success',
            'message' => 'i am excellent',
            'elements'=> [
                [
                    'selector' => '#paymentContent',
                    'html' => $payment
                ]
            ]
        ];
        header("Content-type:application/json");
        echo json_encode($response);

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
        $product =  $this->getLayout()->createBlock('order/adminhtml_order_cart_index_product')->toHtml();
        $cartDetails =  $this->getLayout()->createBlock('order/adminhtml_order_cart_index_cartDetails')->toHtml();
        $response = [
            'status' => 'success',
            'message' => 'i am excellent',
            'elements'=> [
                [
                    'selector' => '#productContent',
                    'html' => $product
                ],
                [
                    'selector' => '#cartDetails',
                    'html' => $cartDetails
                ]
            ]
        ];
        header("Content-type:application/json");
        echo json_encode($response);
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
        $product =  $this->getLayout()->createBlock('order/adminhtml_order_cart_index_product')->toHtml();
        $cartDetails =  $this->getLayout()->createBlock('order/adminhtml_order_cart_index_cartDetails')->toHtml();
        $response = [
            'status' => 'success',
            'message' => 'i am excellent',
            'elements'=> [
                [
                    'selector' => '#productContent',
                    'html' => $product
                ],
                [
                    'selector' => '#cartDetails',
                    'html' => $cartDetails
                ]
            ]
        ];
        header("Content-type:application/json");
        echo json_encode($response);
    }
	
}

?>