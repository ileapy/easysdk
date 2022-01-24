<?php

namespace easysdk\Wechat;

use easysdk\Kernel\BaseContainer;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 *
 * @property \easysdk\Wechat\token\AccessToken              $access_token
 * @property \easysdk\Wechat\base\Client                    $base
 * @property \easysdk\Wechat\user\Client                    $user
 * @property \easysdk\Wechat\tags\Client                    $tags
 * @property \easysdk\Wechat\qrcode\Client                  $qrcode
 * @property \easysdk\Wechat\menu\Client                    $menu
 * @property \easysdk\Wechat\material\Client                $material
 */
class Application extends BaseContainer
{
    /**
     * @var array
     */
    protected $providers = [
        token\ServiceProvider::class,
        base\ServiceProvider::class,
        user\ServiceProvider::class,
        tags\ServiceProvider::class,
        qrcode\ServiceProvider::class,
        menu\ServiceProvider::class,
        material\ServiceProvider::class
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