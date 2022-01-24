<?php

namespace easysdk\WechatMini;

use easysdk\Kernel\BaseContainer;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 *
 * @property \easysdk\WechatMini\auth\Client                    $auth
 * @property \easysdk\WechatMini\token\AccessToken              $access_token
 * @property \easysdk\WechatMini\qrcode\Client                  $qrcode
 */
class Application extends BaseContainer
{
    /**
     * @var array
     */
    protected $providers = [
        auth\ServiceProvider::class,
        token\ServiceProvider::class,
        qrcode\ServiceProvider::class
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