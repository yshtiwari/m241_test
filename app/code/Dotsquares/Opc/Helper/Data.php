<?php

namespace Dotsquares\Opc\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magento\Framework\Message\Session\Proxy as Session;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Customer\Model\Session\Proxy as CustomerSession;
use Dotsquares\Opc\Model\FlagFactory;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\UrlInterface;
use \Magento\Framework\Mail\Template\TransportBuilder;

final class Data extends AbstractHelper
{

    const XML_PATH_ENABLE = 'dotsquares_opc/general/enable';
    const XML_PATH_CHECKOUT_SUITE_DESIGN = 'dotsquares_opc/general/checkout_suite_design';

    const XML_PATH_TITLE = 'dotsquares_opc/extended/title';
    const XML_PATH_DOTSQUARES_EXPERIENCE = 'dotsquares_opc/extended/use_dotsquares_checkout_experience';
    const XML_PATH_DISCOUNT_VISIBILITY = 'dotsquares_opc/extended/show_discount';
    const XML_PATH_COMMENT_VISIBILITY = 'dotsquares_opc/extended/show_comment';
    const XML_PATH_GIFT_MESSAGE_VISIBILITY = 'dotsquares_opc/extended/show_gift_message';
    const XML_PATH_SUBSCRIBE_VISIBILITY = 'dotsquares_opc/extended/show_subscribe';
    const XML_PATH_SUBSCRIBE_BY_DEFAULT = 'dotsquares_opc/extended/subscribe_by_default';
    const XML_PATH_RELOAD_SHIPPING_ON_DISCOUNT = 'dotsquares_opc/extended/reload_shipping_methods_on_discount';
    const XML_PATH_DEFAULT_SHIPPING_METHOD = 'dotsquares_opc/extended/default_shipping_method';
    const XML_PATH_DEFAULT_PAYMENT_METHOD = 'dotsquares_opc/extended/default_payment_method';
    const XML_PATH_PAYMENT_TITLE_TYPE = 'dotsquares_opc/extended/payment_title_type';
    const XML_PATH_DISPLAY_ALL_METHODS = 'dotsquares_opc/extended/show_all_ship_methods';

    const XML_PATH_RESTRICT_PAYMENT_ENABLE = 'dotsquares_opc/restrict_payment/enable';
    const XML_PATH_RESTRICT_PAYMENT_METHODS = 'dotsquares_opc/restrict_payment/methods';

    const XML_PATH_GA_AB_TEST_ENABLE = 'dotsquares_opc/ga_ab_test/enable';
    const XML_PATH_GA_AB_TEST_CODE = 'dotsquares_opc/ga_ab_test/code';

    const XML_PATH_GM_AUTOCOMPLETE_ENABLE = 'dotsquares_opc/extended/gm_autocomplete';
    const XML_PATH_GM_APIKEY = 'dotsquares_opc/extended/gm_apikey';

    public $storeManager;
    public $resourceConfig;
    public $curlFactory;
    public $session;
    public $customerSession;
    public $flagFactory;
    public $response = null;
    public $jsonHelper;
    public $request;
    protected $transportBuilder;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        CustomerSession $customerSession,
        CurlFactory $curlFactory,
        Session $session,
        ConfigInterface $resourceConfig,
        FlagFactory $flagFactory,
        JsonHelper $jsonHelper,
        TransportBuilder $transportBuilder
    ) {
        parent::__construct($context);
        $this->resourceConfig = $resourceConfig;
        $this->storeManager = $storeManager;
        $this->curlFactory = $curlFactory;
        $this->session = $session;
        $this->customerSession = $customerSession;
        $this->flagFactory = $flagFactory;
        $this->jsonHelper = $jsonHelper;
        $this->transportBuilder = $transportBuilder;
    }

    public function isEnable()
    {
        $status = $this->scopeConfig->getValue(self::XML_PATH_ENABLE);
        return (bool)$status;
    }

    public function isCheckoutDesign()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_CHECKOUT_SUITE_DESIGN);
    }

    public function isLoginAccountCreationEnabled()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_DOTSQUARES_EXPERIENCE);
    }

    public function isGaAbEnable()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_GA_AB_TEST_ENABLE);
    }

    public function getGaAbCode()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_GA_AB_TEST_CODE);
    }

    public function isGmAutocompleteEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_GM_AUTOCOMPLETE_ENABLE);
    }

    public function getGmApikey()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_GM_APIKEY);
    }

    public function isCheckoutPage()
    {
        return $this->_getRequest()->getModuleName() === 'onepage'
            && $this->isEnable()
            && $this->isCheckoutDesign()
            && $this->isModuleOutputEnabled('Dotsquares_Opc');
    }

    public function isCurrentlySecure()
    {
        return (bool)$this->storeManager->getStore()->isCurrentlySecure();
    }

    public function getTitle()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_TITLE);
    }

    public function getDefaultShippingMethod()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_DEFAULT_SHIPPING_METHOD);
    }

    public function getDefaultPaymentMethod()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_DEFAULT_PAYMENT_METHOD);
    }

    public function getRestrictPaymentMethods()
    {
        $methods = $this->scopeConfig->getValue(self::XML_PATH_RESTRICT_PAYMENT_METHODS);
        return $methods ? $this->jsonHelper->jsonDecode($methods) : [];
    }

    public function isRestrictPaymentEnable()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_RESTRICT_PAYMENT_ENABLE);
    }

    public function isShowComment()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_COMMENT_VISIBILITY);
    }

    public function isShowDiscount()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_DISCOUNT_VISIBILITY);
    }

    public function isShowGiftMessage()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_GIFT_MESSAGE_VISIBILITY);
    }

    public function isShowLoginButton()
    {
        return true;
    }

    public function isSuccessPageAccountCreationEnabled()
    {
        return true;
    }

    public function isShowSuccessPage()
    {
        return true;
    }

    public function isShowSubscribe()
    {
        $moduleStatus = $this->isModuleOutputEnabled('Magento_Newsletter');
        return $this->scopeConfig->getValue(self::XML_PATH_SUBSCRIBE_VISIBILITY)
            && $moduleStatus;
    }

    public function isSubscribeByDefault()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_SUBSCRIBE_BY_DEFAULT);
    }

    public function isAssignOrderToCustomer()
    {
        return true;
    }

    public function isReloadShippingOnDiscount()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_RELOAD_SHIPPING_ON_DISCOUNT);
    }

    public function getPaymentTitleType()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PAYMENT_TITLE_TYPE);
    }

    public function getClientEmail()
    {
        return trim($this->scopeConfig->getValue('dotsquares_opc/general/license_email'));
    }

    public function isBluePayEnabled()
    {
        $isBluePayActive = trim($this->scopeConfig->getValue('payment/dotsquares_bluepay/active'));
        $bluePayAccountId = trim($this->scopeConfig->getValue('payment/dotsquares_bluepay/account_id'));
        $bluePaySecretKey = trim($this->scopeConfig->getValue('payment/dotsquares_bluepay/secret_key'));

        $result = $isBluePayActive && $bluePayAccountId && $bluePaySecretKey ? true : false;

        return $result;
    }

    public function setModuleActive($isActive)
    {
        $this->resourceConfig->saveConfig(self::XML_PATH_ENABLE, (int)$isActive, 'default', 0);
    }

    public function changeModuleOutput($outputDisabled)
    {
        $this->resourceConfig->saveConfig('advanced/modules_disable_output/IWD_Opc', $outputDisabled, 'default', 0);
    }

    public function getLicensingInformation()
    {
        return '<a href="https://www.dotsquares.com">
                    licensing information
                </a>';
    }

    public function getBaseUrl()
    {
        $defaultStore = $this->storeManager->getDefaultStoreView();
        if (!$defaultStore) {
            $allStores = $this->storeManager->getStores();
            if (isset($allStores[0])) {
                $defaultStore = $allStores[0];
            }
        }

        return $defaultStore->getBaseUrl(UrlInterface::URL_TYPE_LINK);
    }

    public function getDisplayAllMethods()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_DISPLAY_ALL_METHODS);
    }

}
