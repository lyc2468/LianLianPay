<?php


namespace Skies\LianLianPay\Objects;


class RefundRequestRefundData extends ObjectBase
{
    /**
     * Required: M
     * @var string
     * 报价币种:USD、BRL
     * Refund currency: USD, BRL
     */
    public string $refundCurrencyCode;

    /**
     * Required: M
     * @var float
     * 退款金额，累计退款不可超出 原支付金额
     * Refund amount, accumulated amount can’t exceed original payment amount
     */
    public float $refundAmount;


    /**
     * Required: O
     * @var array
     * 银行卡信息详见 4.5
     * See 4.5 for bank card information
     */
    public array $card;

    /**
     * Required: O
     * @var string
     * 退款原因描述
     * Refund reason description
     */
    public string $reason;
}
