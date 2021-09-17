<?php


namespace Skies\LianLianPay\Objects;


class Address extends ObjectBase
{
    /**
     * Required: M
     * @var string 街道
     */
    public string $streetName;

    /**
     * Required: C
     * @var string
     */
    public string $houseNumber;

    /**
     * Required: C
     * @var string 区
     */
    public string $district;

    /**
     * Required: M
     * @var string 城市
     */
    public string $city;

    /**
     * Required: C
     * @var string 省份，查阅附录省份&缩写，部分 国家(美国\巴西\加拿大)请参照
     * 6.3.3
     * State/province, see appendix, Some countries such as(US\BR\CA) see 6.3.3
     */
    public string $state;

    /**
     * Required: M
     * @var string 国家缩写，参照 6.3.1
     * Country abbreviations, see 6.3.1
     */
    public string $country;

    /**
     * Required: M
     * @var string 邮编
     * Zip code
     */
    public string $postalCode;

}
