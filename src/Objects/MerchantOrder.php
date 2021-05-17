<?php


namespace Skies\LianLianPay\Objects;


class MerchantOrder extends ObjectBase
{
    /**
     * Required: M
     * @var string
     * 商户订单 ID
     * Unique identifier for order
     */
    public string $merchantOrderID;

    /**
     * Required: O
     * @var string
     * 商户的用户 ID
     * Unique identifier for merchant user
     */
    public string $merchantUserNo;

    /**
     * Required: M
     * @var string
     * 商户订单时间:yyyyMMddHHmmss
     * Merchant order time: yyyyMMddHHmmss
     */
    public string $merchantOrderTime;

    /**
     * Required: O
     * @var string
     * 订单描述，收银台页面显示
     * Order description, displayed at checkout page
     */
    public string $orderDescription;

    /**
     * Required: O
     * @var string
     * 订单有效期:yyyyMMdd
     * Order valid date: yyyyMMdd
     */
    public string $dueDate;

    /**
     * Required: M
     * @var float
     * 订单金额(不含税)，需保留两位小数 Eg.100.00
     * Order amount (tax exclusive), keep 2 decimals
     */
    public float $orderAmount;

    /**
     * Required: M
     * @var string
     * 订单币种:详见 6.3.2
     * Order currency: See 6.3.2
     */
    public string $orderCurrencyCode;

    /**
     * Required: O
     * @var float
     * 税
     * Tax
     */
    public float $tax;

    /**
     * Required: O
     * @var array
     * 商品详情列表，product 详见 4.1 总长度不能超过 2048
     * Product details, see 4.1 Max length is 2048
     */
    public array $products;

    /**
     * Required: O
     * @var Shipping
     * See 4.3
     */
    public Shipping $shipping;

    /**
     * Required: M
     * @var string
     * See 6.3.4
     */
    public string $mcc;

}
