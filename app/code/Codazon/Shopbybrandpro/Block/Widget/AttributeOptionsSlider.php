<?php
/**
 * Copyright © 2022 Codazon, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Codazon\Shopbybrandpro\Block\Widget;

use Magento\Framework\View\Element\Template;
use Codazon\Shopbybrandpro\Model\BrandFactory as BrandFactory;

class AttributeOptionsSlider extends \Codazon\Shopbybrandpro\Block\Widget\BrandSlider
{
    public function __construct(
		Template\Context $context,
		BrandFactory $brandFactory,
		\Magento\Framework\App\Http\Context $httpContext,
        \Magento\Framework\Registry $coreRegistry,
        \Codazon\Shopbybrandpro\Helper\Data $helper,
        array $data = []
	){
		parent::__construct($context, $brandFactory, $httpContext, $coreRegistry, $helper, $data);
        $this->_attributeCode = $this->_helper->getCurrentAttributeCode() ? : $this->_helper->getStoreBrandCode();
	}
}