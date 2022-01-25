<?php

namespace easysdk\ByteMini;

use easysdk\Kernel\BaseContainer;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 *
 * @property \easysdk\ByteMini\token\AccessToken              $access_token
 * @property \easysdk\ByteMini\auth\Client                    $auth
 * @property \easysdk\ByteMini\qrcode\Client                  $qrcode
 * @property \easysdk\ByteMini\storage\Client                 $storage
 * @property \easysdk\ByteMini\crypto\Client                  $crypto
 * @property \easysdk\ByteMini\secure\Client                  $secure
 * @property \easysdk\ByteMini\message\Client                 $message
 * @property \easysdk\ByteMini\other\Client                   $other
 * @property \easysdk\ByteMini\order\Client                   $order
 */
class Application extends BaseContainer
{
    /**
     * @var array
     */
    protected $providers = [
        token\ServiceProvider::class,
        auth\ServiceProvider::class,
        qrcode\ServiceProvider::class,
        storage\ServiceProvider::class,
        crypto\ServiceProvider::class,
        secure\ServiceProvider::class,
        message\ServiceProvider::class,
        other\ServiceProvider::class,
        order\ServiceProvider::class
    ];

    /**
     * @var string[]
     */
    protected $defaultConfig = [
        'http_post_data_type' => 'json',
        'http' => [
            'timeout' => 30.0,
            'verify' => false,
            'base_uri' => 'https://developer.toutiao.com/api/',
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