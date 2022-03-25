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
class WechatWebClient
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
    protected $endpoint = "https://api.weixin.qq.com/";

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
     * @param $credentials
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    protected function uploadFile($credentials)
    {
        $contents = $this->sendFileRequest($credentials);
        return $contents ? json_decode($contents, JSON_UNESCAPED_UNICODE) ?: $contents : [];
    }

    /**
     * @param $data
     * @return mixed
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
        $data['access_token'] = $this->app->access_token->getToken()['access_token'];
        $this->endpoint = $uri . "?" . http_build_query(array_filter($data));
    }

    /**
     * @param $data
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    protected function signature(&$data)
    {

    }

    /**
     * 验签
     * @param $data
     * @return bool
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    protected function validate($data)
    {
        $signature = $data['signature'];
        $_arr = array($data['timestamp'], $this->getToken(), $data['nonce']);
        sort($_arr, SORT_STRING);
        $str = implode($_arr);
        return $signature == sha1($str);
    }

    /**
     * @return mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    protected function getAppid()
    {
        return $this->config['appid'];
    }

    /**
     * @return mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    protected function getToken()
    {
        return $this->config['token'];
    }
}