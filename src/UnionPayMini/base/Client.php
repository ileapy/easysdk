<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\UnionPayMini\base;

use easysdk\Kernel\Client\UnionPayMiniClient;
use easysdk\Kernel\Support\Str;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends UnionPayMiniClient
{
    /**
     * @param $url
     * @return array
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 11:53
     * @throws \Exception
     */
    public function config($url)
    {
        if (!$url) throw new \Exception("请传递页面url地址，不包含#号之后的部分");

        $nonceStr = Str::nonceStr();
        $timestamp = time();
        $signature = Str::signature([
            'appId'=>$this->config['appid'],
            'secret'=>$this->config['secret'],
            'timestamp'=>$timestamp,
            'url'=>$url,
            'nonceStr'=>$nonceStr,
            'frontToken'=>$this->app->front_token->getToken()['frontToken']
        ]);

        return [
            'appId' => $this->config['appid'],
            'timestamp' => $timestamp,
            'nonceStr' => $nonceStr,
            'signature' => $signature,
            'debug' => $this->config['debug']
        ];
    }
}
