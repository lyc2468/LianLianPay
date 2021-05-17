<?php


namespace Skies\LianLianPay\Objects;


class Customer extends ObjectBase
{
    /**
     * Required: M
     * @var string 客户身份类型，目前仅支持个人 I =Individual (个人) C=Corporation(公司)
                    Customer identity type, currently support individual only
     */
    public string $customerType;

    /**
     * @var string Mandatory when customer_type=”I”
     */
    public string $firstName;

    /**
     * @var string Mandatory when customer_type=”I”
     */
    public string $lastName;

    /**
     * @var string 个人全名或者公司名称
                    Full name of individual or company
     */
    public string $fullName;

    /**
     * @var string 性别:male, female, undefined Gender: male, female, undefined
     */
    public string $gender;

    /**
     * @var string 证件类型:CPF;CNPJ Identity type: CPF, CNPJ
     */
    public string $idType;

    /**
     * @var string 证件号
                    Identify number
     */
    public string $idNo;

    /**
     * @var string 客户邮件地址
                    Email address of customer
     */
    public string $email;

    /**
     * @var string 格式:”+区号-手机号” Format:”+district code-mobile number”
     */
    public string $phone;

    /**
     * @var string 个人公司名称
                    Company name where the individual works
     */
    public string $company;

    /**
     * @var Address 地址信息,详见 4.2.
                Address information, see 4.2
     */
    public Address $address;
}
