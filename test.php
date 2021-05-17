<?php

require 'vendor/autoload.php';

const MERCHNAT_ID = "MERCHNAT_ID";
const PRIVATE_KEY = "PRIVATE_KEY";
const LL_PUBLIC_KEY = "LL_PUBLIC_KEY";

use Skies\LianLianPay\LianLianPay;

$lianLianPay = new LianLianPay([
    'merchant_id' => MERCHNAT_ID,
    'private_key' => PRIVATE_KEY,
    'll_public_key' => LL_PUBLIC_KEY,
    'mode' => 'test', //test for Test Env, proc for product Env
    'notification_url' => 'notification url',
    'cancel_url' => 'cancel notification url',
    'redirect_url' => 'after payment success redirect url',
]);

$address = new \Skies\LianLianPay\Objects\Address();
$address->streetName = 'Mei Sang House';
$address->houseNumber = 'Room 09, Floor 10';
$address->district = "Kowloon";
$address->city = "HONGKONG";
$address->state = 'HK';
$address->country = "US";
$address->postalCode = "210932";

$customer = new \Skies\LianLianPay\Objects\Customer();
$customer->customerType = "I";
$customer->fullName = "zhang san";
$customer->firstName = "zhang";
$customer->lastName = "san";
$customer->address = $address;

$product = new \Skies\LianLianPay\Objects\Product();
$product->productId = 'P2020070001';
$product->name =  "female clothes";
$product->price = "26.6";
$product->quantity = 1;
$product->category = "clothes";
$product->sku = "sku-103848";
$product->shippingProvider = "DHL";
$product->url = "https://www.baidu.com";

$merchantOrder = new \Skies\LianLianPay\Objects\MerchantOrder();
$merchantOrder->merchantOrderID = time();
$merchantOrder->merchantOrderTime = date('YmdHis');
$merchantOrder->mcc = 5732;
$merchantOrder->orderAmount = "40";
$merchantOrder->orderCurrencyCode = "USD";
$merchantOrder->products = [$product];

$r = $lianLianPay->payment((string)time(), $merchantOrder, $customer);
var_dump($r);

$refundData = new \Skies\LianLianPay\Objects\RefundRequestRefundData();
$refundData->refundAmount = "10";
$refundData->reason = "Test";
$refundData->refundCurrencyCode = "USD";

////var_dump($lianLianPay->refund((string)time(), date('YmdHis'), '1619661564', $refundData));
//var_dump($lianLianPay->findRefund('1619662065'));


