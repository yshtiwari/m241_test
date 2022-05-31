<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutLayoutBuilder
*/


declare(strict_types=1);

namespace Amasty\CheckoutLayoutBuilder\Block\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Add new type of field renderer - hidden field with custom id
 * @method AbstractElement getElement()
 */
class LayoutBuilderField extends Field
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_template = 'Amasty_CheckoutLayoutBuilder::system/config/form/field/layout_builder_field.phtml';
        parent::_construct();
    }

    /**
     * Get the grid and scripts contents
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $this->setElement($element);

        return $this->_toHtml();
    }
}
