<?php

class Neklo_Core_Adminhtml_Neklo_Core_ContactController extends Mage_Adminhtml_Controller_Action
{
    const CONTACT_URL = 'https://store.neklo.com/neklo_support/';

    public function indexAction()
    {
        $result = array(
            'error' => 0,
        );
        try {
            $data = $this->getRequest()->getPost();
            $data['version'] = Mage::getVersion();
            $data['url'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
            $data['id'] = '0-0-0';
            $this->_sendContactEmail($data);
        } catch (Exception $e) {
            $result['message'][] = $e->getMessage();
            $result['error'] = 1;
            $this->getResponse()->setBody(Zend_Json::encode($result));
            return;
        }
        $result['message'][] = $this->__("Thank you for your request.");
        $result['message'][] = $this->__("We'll respond as soon as possible.");
        $result['message'][] = $this->__("We'll send copy of your request to your email.");
        $this->getResponse()->setBody(Zend_Json::encode($result));
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/neklo_core');
    }

    protected function _sendContactEmail($data)
    {
        $params = Mage::helper('core')->urlEncode(Mage::helper('core')->jsonEncode($data));
        if ($params) {
            $httpClient = new Varien_Http_Client();
            $httpClient
                ->setMethod(Zend_Http_Client::POST)
                ->setUri(self::CONTACT_URL)
                ->setConfig(
                    array(
                        'maxredirects' => 0,
                        'timeout'      => 30,
                    )
                )
                ->setRawData($params)
                ->request()
            ;
        }
    }
}