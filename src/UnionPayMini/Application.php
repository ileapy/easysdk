<?php

namespace easysdk\UnionPayMini;

use easysdk\Kernel\BaseContainer;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 *
 * @property \easysdk\UnionPayMini\token\AccessToken            $access_token
 * @property \easysdk\UnionPayMini\token\BackendToken           $backend_token
 * @property \easysdk\UnionPayMini\token\FrontToken             $front_token
 * @property \easysdk\UnionPayMini\crypto\Client                $crypto

 */
class Application extends BaseContainer
{
    /**
     * @var array
     */
    protected $providers = [
        token\ServiceProvider::class,
        crypto\ServiceProvider::class
    ];

    /**
     * @var string[]
     */
    protected $defaultConfig = [
        'http_post_data_type' => 'json',
        'http' => [
            'timeout' => 30.0,
            'verify' => false,
            'base_uri' => 'https://open.95516.com/open/access/'
        ],
        // 银联公钥 -注意格式要保持一致
        'publicKey' => <<<EOF
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0QRJ81dxUdJNXoJwx81d
vExIWP9zGhVVdYWKgOajcQI/5F1Qt67ipEL+pSh30P9roPBv6LWHb42z/htmPUrK
XJ4f/WspXkbfBZsERe8XT8NZRnSdR3iZ9RqJKMzgjOetuoeFzTQ5QBalQKfQN9g5
8FEY0wrGH8DbrRzRImsnOVl0vvdIrqvTji+vD6GzZ8egSz9HZ0e9fQKG4dI1nuH1
45OfHY/fNe23oWINbXfFpVWiw+WgTTf8XzjVERD3qAT4i3cwB8RdhNlk3ysW0EJr
t2/WOJiI2NNK3xzXohqPYdUDRA4aWbRPtIma5EtBcnLFm76mXwkTlk9PJm7CJA3c
2QIDAQAB
-----END PUBLIC KEY-----
EOF
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