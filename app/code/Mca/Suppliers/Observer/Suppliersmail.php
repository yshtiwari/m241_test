<?php namespace Mca\Suppliers\Observer;

class Suppliersmail implements \Magento\Framework\Event\ObserverInterface
{
    const XML_PATH_EMAIL_RECIPIENT_NAME = 'trans_email/ident_support/name';
    const XML_PATH_EMAIL_RECIPIENT_EMAIL = 'trans_email/ident_support/email';
     
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
     
    public function __construct(
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        array $data = []
    ){
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        //$this->messageManager = $context->getMessageManager();
        //parent::__construct($context);
    }
	
	public function execute(\Magento\Framework\Event\Observer $observer)
    {
	    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	    $order = $observer->getEvent()->getOrder();	
		
		$billaddress = $order->getBillingAddress();		
		$shippingAddress = $order->getShippingAddress();	
		
		$addressConfig = $objectManager->create('\Magento\Customer\Model\Address\Config');
		$renderer = $addressConfig->getFormatByCode('html')->getRenderer();	
		
		$billingaddress = $renderer->renderArray($billaddress);		
		$formattedShippingAddress = $renderer->renderArray($shippingAddress);
		
		$templateParams = [];		
		$emailTempVariables['order'] = $order;				
		
		$postObject = new \Magento\Framework\DataObject();		
		$postObject->setData($emailTempVariables);		
		$emailTemplateVariables = array();				
		$emailTempVariables['incrementid'] = $order->getId();		
		$emailTempVariables['createdat'] = $order->getCreatedAt();		
		$emailTempVariables['customer_firstname'] = $order->getCustomerFirstname().' '.$order->getCustomerLastname();		
		$emailTempVariables['billingaddress'] = $billingaddress;		
		$emailTempVariables['formattedShippingAddress'] = $formattedShippingAddress;
		$orderItems = $order->getAllVisibleItems();	
		// echo '<pre>';	
		// print_r($orderItems->getData());
		// die();	
		
			
		$manufacturer_array=[];		
		foreach ($orderItems as $item)		
		{			
		//$items_template .= '<tr>';			 
		$resultopt = [];				
		$options = $item->getProductOptions();				
		if ($options) 
		{					
			if (isset($options['options'])) {						
			$resultopt = array_merge($resultopt, $options['options']);					
			}					
			if (isset($options['additional_options'])) {						
			$resultopt = array_merge($resultopt, $options['additional_options']);
			}					
			if (isset($options['attributes_info'])) {						
			$resultopt = array_merge($resultopt, $options['attributes_info']);					
			}				
		}							
		$options1 = '';			
		if($resultopt) {				
			$options1 .= '<dt class="options">';					
			foreach ($resultopt as $_option) : 						
			$options1 .= '<dd>'.$_option['label'].'</dd><dd>&nbsp;&nbsp;'.$_option['value'].'</dd>';
			endforeach; 				
			$options1 .= '</dt>';			
		}									
		$product_id = $item->getProductId();			
		$qty = (int)$item->getQtyOrdered();			
		$product_name = $item->getName();			
		$product = $objectManager->get('\Magento\Catalog\Model\Product')->load($product_id);
		
		$manufacturer = $product->getManufacturer();
							
		
		$objectManagerk = \Magento\Framework\App\ObjectManager::getInstance();	
		$custom_email_check = $objectManagerk->create('Mca\Suppliers\Model\Suppliers')->load($manufacturer,'suppliers_name');							
		if($custom_email_check->getData('suppliers_email')){					
			$supplier_email = $custom_email_check->getData('suppliers_email');
		//echo $supplier_email;
		}else{
		    $supplier_email = '';
		}
		//else				
		//	$supplier_email =  "dsatts@magentoecommerceagency.co.uk";
			
		////$supplier_email =  "dsatts@magentoecommerceagency.co.uk";				
		///$supplier_email =  "mcaanita1@gmail.com";
		
			if($supplier_email!='')
			{
				$manufacturer_array[$supplier_email][]=array($product_name,
				$options1,$qty);
			}		
		}
		//print_r($manufacturer_array);	
	    if(!empty($manufacturer_array)){
		foreach($manufacturer_array as $key => $values)		
		{
        $items_template='';			
		$items_template = '<table width="100%" border="1"  cellpadding="8" style="border:1px solid #c2c2c2;width:100%;">';			
		$receiverMail = $key;			
		$items_template .= '<tr>';			
		$items_template .= '<td class="item-info" style="color:#000;border:1px solid #333;width:80%;">Product</td>';			
		$items_template .= '<td class="item-info" style="color:#000;border:1px solid #333;width:20;">Qty</td>';			
		$items_template .= '<\tr>';			
		
		foreach($values as $ivalue)			
		{				
			$product_title = $ivalue[0];				
			$product_option = $ivalue[1];				
			$product_qty = $ivalue[2];						 
			$items_template .= '<tr>';				
			$items_template .= '<td class="item-info">'.$product_title.'<br/>'.$product_option.'</td>';				
			$items_template .= '<td class="item-info">'.$product_qty.'</td>';
			$items_template .= '</tr>';			
		}			
			$items_template .= '</table>';			
			//echo $items_template;

			$emailTempVariables['items'] = $items_template;
			//$receiverMail = "js5874938@gmail.com";			
			$receiverMail = $receiverMail;			
			//$receiverMail = "js5874938@gmail.com";
			
			$transportBuilder='';			
			$transportBuilder = $objectManager->create("Magento\Framework\Mail\Template\TransportBuilder");	
			
			$transport = $transportBuilder->setTemplateIdentifier(1)
				->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => 1])						
				->setTemplateVars($emailTempVariables)						
				->setFrom(array('email' => 'info@justradiators.co.uk', 'name' => 'info'))						
				->addTo($receiverMail, "RecaiverName")												
				->getTransport();			
				$transport->sendMessage();
		}
		}
    }
}