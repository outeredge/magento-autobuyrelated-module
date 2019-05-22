<?php

namespace OuterEdge\AutoBuyRelated\Ui\DataProvider\Product\Form\Modifier;

use Magento\Ui\Component\Form\Fieldset;

class Related extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related
{
    const DATA_SCOPE_AUTOBUY = 'autobuy';

    /**
     * @var string
     */
    private static $previousGroup = 'search-engine-optimization';

    /**
     * @var int
     */
    private static $sortOrder = 90;

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                static::GROUP_RELATED => [
                    'children' => [
                        $this->scopePrefix . static::DATA_SCOPE_RELATED => $this->getRelatedFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_UPSELL => $this->getUpSellFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_CROSSSELL => $this->getCrossSellFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_AUTOBUY => $this->getAutoBuyFieldset()
                    ],
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Related Products, Up-Sells, Cross-Sells and AutoBuy Products'),
                                'collapsible' => true,
                                'componentType' => Fieldset::NAME,
                                'dataScope' => static::DATA_SCOPE,
                                'sortOrder' =>
                                    $this->getNextGroupSortOrder(
                                        $meta,
                                        self::$previousGroup,
                                        self::$sortOrder
                                    ),
                            ],
                        ],

                    ],
                ],
            ]
        );

        return $meta;
    }

    /**
     * Prepares config for the Autobuy products fieldset
     *
     * @return array
     */
    protected function getAutoBuyFieldset()
    {
        $content = __(
            'Auto buy products are added to the cart in addition to the item the customer is looking at.'
        );

        return [
            'children' => [
                'button_set' => $this->getButtonSet(
                    $content,
                    __('Add Auto Buy Products'),
                    $this->scopePrefix . static::DATA_SCOPE_AUTOBUY
                ),
                'modal' => $this->getGenericModal(
                    __('Add Auto Buy Products'),
                    $this->scopePrefix . static::DATA_SCOPE_AUTOBUY
                ),
                static::DATA_SCOPE_AUTOBUY => $this->getGrid($this->scopePrefix . static::DATA_SCOPE_AUTOBUY),
            ],
            'arguments' => [
                'data' => [
                    'config' => [
                        'additionalClasses' => 'admin__fieldset-section',
                        'label' => __('Auto Buy Products'),
                        'collapsible' => false,
                        'componentType' => Fieldset::NAME,
                        'dataScope' => '',
                        'sortOrder' => 90,
                    ],
                ],
            ]
        ];
    }

    /**
     * Retrieve all data scopes
     *
     * @return array
     */
    protected function getDataScopes()
    {
        return [
            static::DATA_SCOPE_RELATED,
            static::DATA_SCOPE_CROSSSELL,
            static::DATA_SCOPE_UPSELL,
            static::DATA_SCOPE_AUTOBUY
        ];
    }
}