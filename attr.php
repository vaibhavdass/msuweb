<?php
        $mageFilename = 'app/Mage.php';
        require_once $mageFilename;
        Mage::app();

        Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
        $installer = new Mage_Sales_Model_Mysql4_Setup;
        $attribute  = array(
                'type'          => 'int',
                'backend_type'  => '',
                'frontend_input' => 'checkbox',
                'is_user_defined' => true,
                'label'         => 'DDP',
                'visible'       => true,
                'required'      => false,
                'user_defined'  => false,   
                'searchable'    => false,
                'filterable'    => false,
                'comparable'    => false,
                'default'       => 0
        );
        $installer->addAttribute('order', 'ddp', $attribute);
        $installer->endSetup();
?>