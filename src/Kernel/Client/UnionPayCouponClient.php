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
class UnionPayCouponClient
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
    protected $endpoint = "https://gateway.95516.com/gateway/api/";

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
        $contents = $this->requestToken($credentials);
        $result = !$contents && is_string($contents) ? AcpService::parseQString($contents) : json_decode($contents, JSON_UNESCAPED_UNICODE);

        if (empty($result) || !isset($result['resp']) || $result['resp'] != '00') return $result;

        return isset($result['params']) ? $result['params'] : $result;
    }

    /**
     * @param string $uri
     */
    protected function setEndpoint($uri = '')
    {
        $base_uri = $this->config['debug'] == 'pm'
            ? $this->config['pm_base_uri']
            : ($this->config['debug'] ? $this->config['test_base_uri'] : $this->config['base_uri']);

        $this->endpoint = $base_uri . $uri;
    }

    /**
     * @param $data
     * @param bool $need_access_token
     * @return mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    protected function getCredentials($data)
    {
        $array = [
            'issCode' => $this->config['org_code'],
            'ssn' => 'req' . time() . rand(10000, 99999),
            'reqDate' => date('Ymd'),
            'reqTime' => date('Hms'),
            'data' => $data
        ];
        return ;
    }

    /**
     * @param $array
     * @return array|false|string|string[]
     * Author cfn <cfn@leapy.cn>
     * Date 2022/2/17
     */
    private function signature($array)
    {
        unset($array['sign']);
        //????????????????????????value???????????????????????????????????????
        $this->array_filter_recursive($array);
        // ??????
        ksort($array);
        // ??????????????????
        openssl_sign(json_encode($array, JSON_UNESCAPED_UNICODE), $signature, $this->config['org_private_key'], OPENSSL_ALGO_SHA256);
        openssl_free_key($this->config['org_private_key']);
        // ??????????????????????????????
        $_array_request['sign'] = bin2hex($signature);
        // ??????json??????????????????
        return json_encode($_array_request, JSON_UNESCAPED_UNICODE);
    }
}