<?php 
class Naresh_Measurement_Block_Customer_Account_Navigation extends Mage_Customer_Block_Account_Navigation {
	protected $_links = array();

    protected $_activeLink = false;

    // public function removeLinkByName($name) {
    //     unset($this->_links[$name]);
    // }
	public function removeLinkByName() {
		$NavigationLinks = array('account'=>'account', 'account_edit'=>'account_edit', 'address_book'=>'address_book', 'orders'=>'orders', 'billing_agreements'=>'billing_agreements', 'recurring_profiles'=>'recurring_profiles', 'reviews'=>'reviews', 'tags'=>'tags', 'wishlist'=>'wishlist', 'OAuth Customer Tokens'=>'oauth_customer_tokens', 'newsletter'=>'newsletter', 'downloadable_products'=>'downloadable_products');
		
		foreach ($NavigationLinks as $link => $configName) {
			$display = Mage::getStoreConfig('customer_navigation/display/'.$configName);
			if (isset($this->_links[$link]) && !$display) {
				unset($this->_links[$link]);
			}
		}
	}

	public function renameLinkByName() {
		$NavigationLinks = array('account'=>'account', 'account_edit'=>'account_edit', 'address_book'=>'address_book', 'orders'=>'orders', 'billing_agreements'=>'billing_agreements', 'recurring_profiles'=>'recurring_profiles', 'reviews'=>'reviews', 'tags'=>'tags', 'wishlist'=>'wishlist', 'OAuth Customer Tokens'=>'oauth_customer_tokens', 'newsletter'=>'newsletter', 'downloadable_products'=>'downloadable_products');			
		
		foreach ($NavigationLinks as $link => $configName) {
			$name = Mage::getStoreConfig('customer_navigation/rename/'.$configName);
			if (isset($this->_links[$link]) && $name != '') {					
				$this->_links[$link]["label"] = $name;					
			}
		}
	}
	public function addLink($name, $path, $label, $urlParams=array()) {
		$this->_links[$name] = new Varien_Object(array(
			'name' => $name,
			'path' => $path,
			'label' => $label,
			'url' => $this->getUrl($path, $urlParams),
		));
		return $this;
	}
	
    public function setActive($path)
    {
        $this->_activeLink = $this->_completePath($path);
        return $this;
    }

    public function getLinks()
    {
        return $this->_links;
    }

    public function isActive($link)
    {
        if (empty($this->_activeLink)) {
            $this->_activeLink = $this->getAction()->getFullActionName('/');
        }
        if ($this->_completePath($link->getPath()) == $this->_activeLink) {
            return true;
        }
        return false;
    }

    protected function _completePath($path)
    {
        $path = rtrim($path, '/');
        switch (sizeof(explode('/', $path))) {
            case 1:
                $path .= '/index';
                // no break

            case 2:
                $path .= '/index';
        }
        return $path;
    }
}