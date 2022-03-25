<?php

namespace easysdk\AliyunSms;

use easysdk\Kernel\BaseContainer;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 *
 * @property \easysdk\AliyunSms\sms\Client                  $sms
 * @property \easysdk\AliyunSms\query\Client                $query
 */
class Application extends BaseContainer
{
    /**
     * @var array
     */
    protected $providers = [
        \easysdk\AliyunSms\sms\ServiceProvider::class,
        \easysdk\AliyunSms\query\ServiceProvider::class,
    ];

    /**
     * @var string[]
     */
    protected $defaultConfig = [
        'http_post_data_type' => 'json',
        'http' => [
            'timeout' => 30.0,
            'verify' => false,
            'base_uri' => 'https://dysmsapi.aliyuncs.com/',
            'headers' => ['Content-Type' => 'application/json']
        ]
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