<?php
namespace Magento\Bundle\Block\Catalog\Product\View\Type\Bundle\Option\Radio;

/**
 * Interceptor class for @see \Magento\Bundle\Block\Catalog\Product\View\Type\Bundle\Option\Radio
 */
class Interceptor extends \Magento\Bundle\Block\Catalog\Product\View\Type\Bundle\Option\Radio implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Catalog\Helper\Data $catalogData, \Magento\Framework\Registry $registry, \Magento\Framework\Stdlib\StringUtils $string, \Magento\Framework\Math\Random $mathRandom, \Magento\Checkout\Helper\Cart $cartHelper, \Magento\Tax\Helper\Data $taxData, \Magento\Framework\Pricing\Helper\Data $pricingHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $jsonEncoder, $catalogData, $registry, $string, $mathRandom, $cartHelper, $taxData, $pricingHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getData($key = '', $index = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getData');
        return $pluginInfo ? $this->___callPlugins('getData', func_get_args(), $pluginInfo) : parent::getData($key, $index);
    }
}
