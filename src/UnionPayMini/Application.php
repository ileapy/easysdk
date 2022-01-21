<?php

namespace easysdk\UnionPayMini;

use easysdk\Kernel\BaseContainer;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */
class Application extends BaseContainer
{
    /**
     * @var array
     */
    protected $providers = [

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
     * Handle dynamic calls.
     * @param $method
     * @param $args
     * @return mixed
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/18 22:24
     */
    public function __call($method, $args)
    {
        return $this->base->$method(...$args);
    }
}