<?php

class Ccc_Vendor_Helper_Data extends Mage_Core_Helper_Abstract {

	const ROUTE_ACCOUNT_LOGIN = 'vendor/account/login';
	const REFERER_QUERY_PARAM_NAME = 'referer';

	const XML_PATH_VENDOR_STARTUP_REDIRECT_TO_DASHBOARD = 'vendor/startup/redirect_dashboard';

	public function getAccountUrl() {
		return $this->_getUrl('vendor/account');
	}

	public function getRegisterUrl() {
		return $this->_getUrl('vendor/account/create');
	}

	public function getLoginUrl() {
		return $this->_getUrl(self::ROUTE_ACCOUNT_LOGIN, $this->getLoginUrlParams());
	}

	public function getLoginUrlParams() {
		$params = array();

		$referer = $this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME);

		if (!$referer && !Mage::getStoreConfigFlag(self::XML_PATH_VENDOR_STARTUP_REDIRECT_TO_DASHBOARD)
			&& !Mage::getSingleton('vendor/session')->getNoReferer()
		) {
			$referer = Mage::getUrl('*/*/*', array('_current' => true, '_use_rewrite' => true));
			$referer = Mage::helper('core')->urlEncode($referer);
		}

		if ($referer) {
			$params = array(self::REFERER_QUERY_PARAM_NAME => $referer);
		}

		return $params;
	}

	public function getLoginPostUrl() {
		$params = array();
		if ($this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME)) {
			$params = array(
				self::REFERER_QUERY_PARAM_NAME => $this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME),
			);
		}
		return $this->_getUrl('vendor/account/loginPost', $params);
	}

	public function getLogoutUrl() {
		return $this->_getUrl('vendor/account/logout');
	}

	public function getRegisterPostUrl() {
		return $this->_getUrl('vendor/account/createpost');
	}

	public function getDashboardUrl() {
		return $this->_getUrl('vendor/account');
	}

	public function getOldFieldMap() {
		$node = Mage::getConfig()->getNode('global/vendorproduct/old_fields_map');
		if ($node === false) {
			return array();
		}
		return (array) $node;
	}

	public function getGroupPostUrl($group) {
		return $this->_getUrl('vendor/group/save', ['id' => $group->getGroupId()]);
	}

	public function _getSession() {
		return Mage::getSingleton('vendor/session');
	}

	public function authenticate($action, $controller) {
		$openActions = array(
			'create',
			'login',
			'logoutsuccess',
			'forgotpassword',
			'forgotpasswordpost',
			'changeforgotten',
			'resetpassword',
			'resetpasswordpost',
			'confirm',
			'confirmation',
		);
		$pattern = '/^(' . implode('|', $openActions) . ')/i';

		if (!preg_match($pattern, $action)) {
			if (!$this->_getSession()->authenticate($controller)) {
				$controller->setFlag('', 'no-dispatch', true);
			}
		} else {
			$this->_getSession()->setNoReferer(true);
		}
	}

}