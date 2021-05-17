<?php

namespace Skies\LianLianPay\Objects;

class Product extends ObjectBase
{
    /**
     * Required: M
     * @var string 商品 ID
     * Unique identify for product
     */
    public string $productId;

    /**
     * Required: M
     * @var string 商品名称
     * Product name
     */
    public string $name;

    /**
     * Required: O
     * @var string 商品描述，不允许包含”’等特殊字符
     * Product description, no special characters
     */
    public string $description;

    /**
     * Required: M
     * @var float 商品价格，需保留两位小数
     * Eg.100.00 Product price, keep 2 decimals
     */
    public float $price;

    /**
     * Required: M
     * @var int 商品数量，正整数
     * Product quantity, positive integer
     */
    public int $quantity;

    /**
     * Required: O
     * @var string 商品分类
     * Product category
     */
    public string $category;

    /**
     * Required: C
     * @var string 商品 sku, 信用卡支付必填
     * Product SKU，mandatory when payment method is credit card
     */
    public string $sku;

    /**
     * Required: C
     * @var string 商品网址，支付方式为国际信用卡时 必须
     * Product URL, mandatory when payment method is credit card
     */
    public string $url;

    /**
     * @var string 物流供应商，信用卡必填
     * Logistics service provider e.g. DHL,Fedex, sedex, pac;,carrier, other. Mandatory when payment method is credit card
     */
    public string $shippingProvider;

}
