<?php

namespace easysdk\Kernel\Client;

use easysdk\Kernel\BaseContainer;
use easysdk\Kernel\Support\AcpService;
use easysdk\Kernel\Traits\HasHttpRequests;
use easysdk\Kernel\Traits\InteractsWithCache;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */
class UnionPayUtpPaymentClient
{
    use HasHttpRequests;
    use InteractsWithCache;

    /**
     * @var BaseContainer
     */
    protected $app;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $endpoint = "https://service.fpsd.unionpay.com/gateway/prod.do";

    /**
     * @var string
     */
    protected $requestMethod = 'POST';

    /**
     * @param BaseContainer $app
     */
    public function __construct(BaseContainer $app)
    {
        $this->app = $app;
        $this->config = $app['config']->toArray();
        // url 处理
        $this->setEndpoint();
    }

    /**
     * @param $credentials
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function send($credentials)
    {
        $credentials = $this->signature($credentials);
        $contents = $this->requestToken($credentials);
        return $contents ? json_decode($contents, JSON_UNESCAPED_UNICODE) : [];
    }

    /**
     * setEndpoint
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/4/20
     * @param $uri
     */
    protected function setEndpoint($uri = '')
    {
        $base_uri = $this->config['debug'] ? $this->config['test_base_uri'] : $this->config['base_uri'];
        $this->endpoint = $base_uri . $uri;
    }

    /**
     * signature 签名
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/4/20
     */
    protected function signature($data)
    {
        $svcApi = $data['svcApi'];
        unset($data['svcApi']);
        $param = [
            'svcId' => $this->config['svcId'],
            'svcApi' => $svcApi,
            'serId' => $this->config['serId'],
            'format' => 'json',
            'charset' => 'utf-8',
            'signType' => 'RSA2',
            'timestamp' => date("YmdHis"),
            'version' => '2.0.0',
            'notifyUrl' => $this->config['notifyUrl'],
            'bizContent' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ];

        // 过滤非空项
        $param = array_filter($param);
        ksort($param);
        // 排序
        $queryParam_arr = [];
        foreach ($param as $k => $v) {
            $queryParam_arr[] = $k . "=" . $v;
        }
        // kv拼接
        $str = implode("&", $queryParam_arr);
        // sha256
        $str = hash("sha256", $str);
        // 签名
        $key = openssl_get_privatekey($this->getPrivateKey());
        openssl_sign($str,$sign, $key,OPENSSL_ALGO_SHA256);
        openssl_free_key($key);
        $param['sign'] = base64_encode($sign);
        return $param;
    }

    /**
     * verify 验签
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/4/24
     * @param $data
     * @return bool
     */
    protected function verify($data)
    {
        $sign = $data['sign'];
        unset($data['sign']);

        // 过滤非空项
        $data = array_filter($data);
        ksort($data);
        // 排序
        $queryParam_arr = [];
        foreach ($data as $k => $v) {
            $queryParam_arr[] = $k . "=" . $v;
        }
        // kv拼接
        $str = implode("&", $queryParam_arr);
        // sha256
        $str = hash("sha256", $str);
        // 签名
        $key = openssl_get_publickey($this->getPublicKey());
        $result = (bool)openssl_verify($str,base64_decode($sign), $key,OPENSSL_ALGO_SHA256);
        openssl_free_key($key);
        return $result;
    }

    /**
     * getPrivateKey
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/4/20
     */
    private function getPrivateKey()
    {
        return  "-----BEGIN PRIVATE KEY-----\n" . wordwrap($this->config['priKey'], 64, "\n", true) . "\n-----END PRIVATE KEY-----";
    }

    /**
     * getPrivateKey
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/4/20
     */
    private function getPublicKey()
    {
        return  "-----BEGIN PUBLIC KEY-----\n" . wordwrap($this->config['pubKey'], 64, "\n", true) . "\n-----END PUBLIC KEY-----";
    }
}
