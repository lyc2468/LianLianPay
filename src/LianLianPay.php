<?php

namespace Skies\LianLianPay;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Skies\LianLianPay\Objects\Customer;
use Skies\LianLianPay\Objects\MerchantOrder;
use Skies\LianLianPay\Objects\ObjectBase;
use Skies\LianLianPay\Objects\RefundRequestRefundData;
use Skies\LianLianPay\Objects\Shipping;

class LianLianPay
{
    const TEST_API_URL = 'https://celer-api.LianLianpay-inc.com';
    const PROC_API_URL = 'https://gpapi.LianLianpay.com';

    private string $merchantID;
    private string $privateKey;
    private string $lianLianPublicKey;
    private string $apiUrl;
    private string $notificationUrl;
    private string $cancelUrl;
    private string $country;
    private string $bizCode;
    private string $redirectUrl;

    public Client $client;

    public function __construct(array $config)
    {
        $this->merchantID = $config['merchant_id'] ?? '';
        $this->privateKey = $config['private_key'] ?? '';
        $this->lianLianPublicKey = $config['ll_public_key'];

        if (empty($config['api_url'])) {
            $this->apiUrl = ($config['mode'] == 'test') ? self::TEST_API_URL : self::PROC_API_URL;
        } else {
            $this->apiUrl = $config['api_url'];
        }

        $this->notificationUrl = $config['notification_url'] ?? '';
        $this->redirectUrl = $config['redirect_url'] ?? '';
        $this->cancelUrl = $config['cancel_url'] ?? '';
        $this->country = $config['country'] ?? 'US';
        $this->bizCode = $config['biz_code'] ?? 'EC';

        $this->client = new Client([
            'base_uri' => $this->apiUrl
        ]);
    }

    public function payment(string $transactionID, MerchantOrder $merchantOrder, Customer $customer, string $cancelUrl = null, string $redirectUrl = null)
    {
        $paymentUrl = "/v3/merchants/{$this->merchantID}/payments";

        $response = $this->request($paymentUrl, [
            'merchant_transaction_id' => $transactionID,
            'merchant_id' => $this->merchantID,
            'biz_code' => $this->bizCode,
            'notification_url' => $this->notificationUrl,
            'cancel_url' => $cancelUrl ?? $this->cancelUrl,
            'country' => $this->country,
            'merchant_order' => $merchantOrder,
            'redirect_url' => $redirectUrl ?? $this->redirectUrl,
            'customer' => $customer,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function findPayment(string $transactionID)
    {
        $queryPaymentUrl = "/v3/merchants/{$this->merchantID}/payments/{$transactionID}";

        $response = $this->request($queryPaymentUrl, [
            'merchant_id' => $this->merchantID,
            'merchant_transaction_id' => $transactionID,
        ], 'get');

        return json_decode($response->getBody(), true);
    }

    public function refund(string $transactionID, $merchantRefundTime, $originalTransactionID, RefundRequestRefundData $refundData)
    {
        $refundUrl = "/v3/merchants/{$this->merchantID}/payments/{$originalTransactionID}/refunds";
        try {
            $response = $this->request($refundUrl, [
                'merchant_transaction_id' => $transactionID,
                'merchant_id' => $this->merchantID,
                'merchant_refund_time' => $merchantRefundTime,
                'original_transaction_id' => $originalTransactionID,
                'refund_data' => $refundData,
                'notification_url' => $this->notificationUrl,
            ]);
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody(), true);
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $transactionID 退款ID
     * @return mixed
     */
    public function findRefund(string $transactionID)
    {
        $queryRefundUrl = "/v3/merchants/{$this->merchantID}/refunds/{$transactionID}";

        $response = $this->request($queryRefundUrl, [
            'merchant_id' => $this->merchantID,
            'merchant_transaction_id' => $transactionID,
        ], 'get');

        return json_decode($response->getBody(), true);
    }

    public function uploadShipping(string $merchantTransactionId, array $shipments): array
    {
        $uploadShippingUrl = "/v3/merchants/{$this->merchantID}/payments/{$merchantTransactionId}/shippings";

        $response = $this->request($uploadShippingUrl, [
            'merchant_id' => $this->merchantID,
            'merchant_transaction_id' => $merchantTransactionId,
            'shipments' => $shipments,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function updateShipping()
    {

    }

    public function cancel(string $merchantTransactionId): array
    {
        $cancelUrl = "/v3/merchants/{$this->merchantID}/payments/{$merchantTransactionId}/cancelpay";
        $response = $this->request($cancelUrl, [
            'merchant_id' => $this->merchantID,
            'merchant_transaction_id' => $merchantTransactionId,
        ], 'get');

        return json_decode($response->getBody(), true);
    }

    public function verify()
    {
        $signature = $_SERVER['HTTP_SIGNATURE'];
        if (empty($signature)) {
            return false;
        }
        $body = file_get_contents('php://input');
        $body = preg_replace('/:\s*([0-9]*\.?[0-9]+)/', ': "$1"', $body);
        $data = json_decode($body, true);

        $signTools = new LianLianSign();
        if (!$signTools->verifySignForLianlian($data, $signature, $this->lianLianPublicKey)) {
            return false;
        }

        return $data;
    }

    protected function request(string $url, array $data, string $method = 'post')
    {
        foreach ($data as $key => $val) {
            if ($val instanceof ObjectBase) {
                $data[$key] = $val->toArray();
            }
        }

        //生成签名
        $signTools = new LianLianSign();
        $signature = $signTools->signForLianlian($data, $this->privateKey);

        //生成Header
        $header = [
            'sign-type' =>  'RSA',
            'timestamp' => date("YmdHis", time()),
            'timezone'  => date_default_timezone_get(),
            'Content-Type' => 'application/json',
            'signature' => $signature
        ];

        //发送请求
        return $this->client->$method($url, [
            'json' => $data,
            'headers' => $header,
        ]);
    }

}
