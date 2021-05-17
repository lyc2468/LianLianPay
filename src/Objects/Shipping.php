<?php


namespace Skies\LianLianPay\Objects;


class Shipping extends ObjectBase
{
    /**
     * Required: C
     * @var string 收货人名
     * First name of recipient
     */
    public string $firstName;

    /**
     * Required: C
     * @var string 收货人姓
     * Last name of recipient
     */
    public string $lastName;

    /**
     * Required: M
     * @var string 收货人姓名 first_name+空格+ last_name
                    Full name of recipient
                    f first_name +” ”+ last_name
     */
    public string $name;

    /**
     * Required: C
     * @var string 收货人手机号
                    Mobile phone number
     */
    public string $phone;

    /**
     * Required: M
     * @var string 配送周期 Dispatch time 12h: Within 12 hours; 24h: Within 24 hours; 48h: Within 48 hours; 72h: Within 72 hours; other: Over 72 hours
     */
    public string $cycle;

    /**
     * Required: M
     * @var Address 地址信息，详见 4.2 Address information, see 4.2
     */
    public Address $address;
}
