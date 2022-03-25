<?php

namespace easysdk\WechatWeb;

use easysdk\Kernel\BaseContainer;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 *
 * @property \easysdk\WechatWeb\accessToken\AccessToken     $access_token
 * @property \easysdk\WechatWeb\auth\Client                 $auth
 */
class Application extends BaseContainer
{
    /**
     * @var array
     */
    protected $providers = [
        \easysdk\WechatWeb\accessToken\ServiceProvider::class,
        \easysdk\WechatWeb\auth\ServiceProvider::class
    ];

    /**
     * @var string[]
     */
    protected $defaultConfig = [
        'http_post_data_type' => 'json',
        'http' => [
            'timeout' => 30.0,
            'verify' => false,
            'base_uri' => 'https://api.weixin.qq.com/',
            'headers' => ['Content-Type' => 'application/json']
        ],
    ];

    /**
     * @param $method
     * @param $args
     * @return mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function __call($method, $args)
    {
        return $this->base->$method(...$args);
    }
}