<?php

namespace Amasty\CheckoutGraphQl\Model\Resolver;

use Amasty\CheckoutCore\Api\AdditionalFieldsManagementInterface;
use Amasty\CheckoutCore\Api\Data\AdditionalFieldsInterface;
use Amasty\CheckoutCore\Model\AdditionalFields;
use Amasty\CheckoutGraphQl\Model\Utils\CartProvider;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetAdditionalFields implements ResolverInterface
{
    /**
     * @var CartProvider
     */
    private $cartProvider;

    /**
     * @var AdditionalFieldsManagementInterface
     */
    private $additionalFieldsManagement;

    public function __construct(
        CartProvider $cartProvider,
        AdditionalFieldsManagementInterface $additionalFieldsManagement
    ) {
        $this->cartProvider = $cartProvider;
        $this->additionalFieldsManagement = $additionalFieldsManagement;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return AdditionalFieldsInterface|AdditionalFields|Value|mixed
     * @throws GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args[CartProvider::CART_ID])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', CartProvider::CART_ID));
        }

        $cart = $this->cartProvider->getCartForUser($args[CartProvider::CART_ID], $context);

        try {
            $additionalFields = $this->additionalFieldsManagement->getByQuoteId($cart->getId());
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()), $e);
        }

        return $additionalFields;
    }
}
