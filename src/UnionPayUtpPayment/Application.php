<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/15 22:55
 * Copyright: php
 */

namespace easysdk\UnionPayUtpPayment;

use easysdk\Kernel\BaseContainer;

/**
 * Class Application
 *
 * @property \easysdk\UnionPayUtpPayment\auth\Client                    $auth
 *
 * @package easysdk\UnionPayAppPayment
 */
class Application extends BaseContainer
{
    /**
     * @var array
     */
    protected $providers = [
        auth\ServiceProvider::class,
    ];

    /**
     * @var string[]
     */
    protected $defaultConfig = [
        // 是否测试模式， 测试模式下网关为测试地址
        'debug' => false,
        // 请求数据类型
        'http_post_data_type' => 'json',
        // 正式环境域名
        'base_uri' => 'https://service.fpsd.unionpay.com/gateway/prod.do',
        // 测试环境域名
        'test_base_uri' => 'http://101.231.114.212:10003/gateway/prod.do',
        // json
        'http' => [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ],
        'notifyUrl' => '',
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
