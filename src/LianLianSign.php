<?php
namespace Skies\LianLianPay;

class LianLianSign
{
    public function signForLianlian(&$data, $privateKey)
    {
        return $this->genSign($this->genSignContent($data), $privateKey);
    }

    public function verifySignForLianlian(&$data, $sign, $pubKey)
    {
        return $this->verifySign($this->genSignContent($data), $sign, $pubKey);
    }

    /**
     * 生成签名内容
     * @param $req
     * @return string
     */
    private function genSignContent(&$req)
    {
        $arr = array($req);
        $strs = array();
        ksort($arr);
        $this->items(0, $arr, $strs);
        $msg = implode('&', $strs);
        return $msg;
    }

    /**
     * 递归深度优先排序
     * @param $x
     * @param $y
     * @param $strs
     */
    private function items($x, $y, &$strs)
    {
        if ($y == null) {
            return;
        }
        if (is_array($y)) {
            ksort($y);
            foreach ($y as $key => $value) {
                $this->items($key, $value, $strs);
            }
            return;
        }
        $strs[] = $x . "=" . $y;
    }

    /**
     * 生成签名
     * @param $toSign
     * @param $privateKey
     * @return string
     */
    public function genSign($toSign, $privateKey)
    {
        //这里他是拼接成和pem文件一样的格式
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($privateKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        $key = openssl_get_privatekey($privateKey);
        openssl_sign($toSign, $signature, $key);
        openssl_free_key($key);
        $sign = base64_encode($signature);
        return $sign;
    }



    /**
     * 验证签名
     * @param $data
     * @param $sign
     * @param $pubKey
     * @return bool
     */
    public function verifySign($data, $sign, $pubKey)
    {
        $sign = base64_decode($sign);

        $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";

        $key = openssl_pkey_get_public($pubKey);
        $result = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1) === 1;
        return $result;
    }

}
