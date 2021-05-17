<?php


namespace Skies\LianLianPay\Objects;


class Shipment extends ObjectBase
{
    /**
     * Required: M
     * @var string 承运商编码，参考 6.3.6
     */
    public string $carrierCode;

    /**
     * Required: M
     * @var string 物流单号
     */
    public string $trackingNo;

    /**
     * Required: O
     * @var string 发货国家缩写，参照 6.3.1 Country abbreviations, see 6.3.1
     */
    public string $country;
}
