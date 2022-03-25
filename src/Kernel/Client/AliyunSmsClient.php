<?php

namespace easysdk\Kernel\Client;

use easysdk\Kernel\BaseContainer;
use easysdk\Kernel\Traits\HasHttpRequests;
use easysdk\Kernel\Traits\InteractsWithCache;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */
class AliyunSmsClient
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
    protected $endpoint = "https://dysmsapi.aliyuncs.com/";

    /**
     * @var string
     */
    protected $requestMethod = 'GET';

    /**
     * @param BaseContainer $app
     */
    public function __construct(BaseContainer $app)
    {
        $this->app = $app;
        $this->config = $app['config']->toArray();
    }

    /**
     * @param null $credentials 数据
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    protected function send($credentials=null)
    {
        $contents = $this->requestToken($credentials);
        return $contents ? json_decode($contents, JSON_UNESCAPED_UNICODE) ?: $contents : [];
    }

    /**
     * @param $data
     * @return array
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    protected function getCredentials($data)
    {
        return array_filter($data);
    }

    /**
     * @param $uri
     * @param $data
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    protected function setEndpoint($uri, $data = [])
    {
        $this->endpoint = $uri . "?" . http_build_query(array_filter($data));
    }

    /**
     * @param $data
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    protected function signature(&$data)
    {
        ksort ($data);
        $_str = '';
        foreach ($data as $key => $value) $_str .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        $stringToSign = 'GET&%2F&' . $this->percentencode(substr($_str,1));
        $data['Signature'] = base64_encode(hash_hmac('sha1', $stringToSign, $this->config['AccessKeySecret'] . '&',true));
    }

    /**
     * percentEncode
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/3/25
     * @param $string
     * @return array|string|string[]|null
     */
    private function percentEncode($string)
    {
        $string = urlencode($string);
        $string = preg_replace('/\+/','%20', $string);
        $string = preg_replace('/\*/','%2A', $string);
        return preg_replace('/%7E/','~', $string);
    }

    /**
     * getCommonData
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/3/25
     * @return array
     */
    protected function getCommonData()
    {
        return [
            'Version' => '2017-05-25',
            'Format' => 'JSON',
            'AccessKeyId' => $this->config['AccessKeyId'],
            'SignatureNonce' => time() . rand(1000,9999),
            'Timestamp' => gmdate("Y-m-d\TH:i:s\Z"),
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureVersion' => '1.0'
        ];
    }
}