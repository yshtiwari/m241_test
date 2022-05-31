<?php
namespace Dotsquares\Shipping\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Config;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\State;
use Magento\Backend\App\Area\FrontNameResolver;

class Condition extends AbstractCarrier implements CarrierInterface
{
    protected $_code = 'dotsquares';
    
    protected $_isFixed = true;
    
    protected $defaultConditionName = 'package_weight';
    
    protected $conditionNames = [];
    
    protected $rateResultFactory;
    
    protected $resultMethodFactory;
    
    protected $matrixrateFactory;
    
    protected $appState;
    
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $resultMethodFactory,
        \Dotsquares\Shipping\Model\ResourceModel\Carrier\ShippingmethodFactory $shippingFactory,
    	State $appState,
        array $data = []
    ) {
        $this->rateResultFactory = $rateResultFactory;
        $this->resultMethodFactory = $resultMethodFactory;
        $this->shippingFactory = $shippingFactory;
    	$this->appState = $appState;
    	$this->scopeConfig = $scopeConfig;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        
    }
    
    public function collectRates(RateRequest $request)
    {
    	if (!$this->isActive()) {
    		return false;
    	}
    	
    	if ($request->getAllItems()) {
            foreach ($request->getAllItems() as $item) {
                if ($item->getParentItem()) {
                    continue;
                }
                if ($item->getHasChildren() && $item->isShipSeparately()) {
                    foreach ($item->getChildren() as $child) {
                        if ($child->getProduct()->isVirtual()) {
                            $request->setPackageValue($request->getPackageValue() - $child->getBaseRowTotal());
                        }
                    }
                } elseif ($item->getProduct()->isVirtual()) {
                    $request->setPackageValue($request->getPackageValue() - $item->getBaseRowTotal());
                }
            }
        }
        if (!$request->getConditionMRName()) {
            $conditionName = $this->getConfigData('condition_type');
            $request->setConditionMRName($conditionName ? $conditionName : 'package_weight');
        }
        $result = $this->rateResultFactory->create();
        if(!$this->isAdmin()){
            $rateArray = $this->getapply_rules($request);
            $foundRates = false;
    	    foreach ($rateArray as $rate) {
                if (!empty($rate) && $rate['price'] >= 0) {
                    $method = $this->resultMethodFactory->create();
                    $method->setCarrier('dotsquares');
                    $method->setCarrierTitle($this->getConfigData('title'));
                    $method->setMethod('dotsquares' . $rate['id']);
                    $method->setMethodTitle(__($rate['shipping_method']));
                    $method->setPrice($rate['price']);
                    $method->setCost($rate['cost']);
                    $result->append($method);
                    $foundRates = true;
                }
            }
            if (!$foundRates) {
                $error = $this->_rateErrorFactory->create(
                    [
                        'data' => [
                        	'carrier' => 'dotsquares',
                        	'carrier_title' => $this->getConfigData('title'),
                        	'error_message' => $this->getConfigData('errormsg'),
                        ],
                    ]
            	);
                $result->append($error);		
            }
        }else{
            if($this->getConfigData('adminfreeshipping')){
                $result = $this->rateResultFactory->create();
                /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
                $method = $this->resultMethodFactory->create();
                $method->setCarrier('dotsquares');
                $method->setCarrierTitle($this->getConfigData('title'));
                $method->setMethod('dotsquares');
                $method->setMethodTitle($this->getConfigData('adminname'));
                $method->setPrice('0.00');
                $method->setCost('0.00');
                $result->append($method);
            }	
    	}

        return $result;
    }

	
    public function getapply_rules(\Magento\Quote\Model\Quote\Address\RateRequest $request)
    {
		return $this->shippingFactory->create()->getshippingrules($request);
    }

	public function getAllowedMethods()
	{
		return [$this->getCarrierCode() => __($this->getConfigData('title'))];
	}

	protected function isAdmin()
    {
        if ($this->appState->getAreaCode() === FrontNameResolver::AREA_CODE) {
            return true;
        }
        return false;
    }
}